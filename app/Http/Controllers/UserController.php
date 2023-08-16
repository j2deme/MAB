<?php

namespace App\Http\Controllers;

use Auth;
use App\Role;
use App\User;
use App\Career;
use App\Permission;
use App\Http\Requests;
use App\Traits\Authorizable;
use Illuminate\Http\Request;
use League\Csv\Reader;
use Storage;
use File;

class UserController extends Controller
{
  use Authorizable;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $total = User::where('username', 'NOT LIKE', '__69____')
      ->Where('username', 'NOT LIKE', '__18____')
      ->Where('username', 'NOT LIKE', '____0___')
      ->Where('username', 'NOT LIKE', 'B________')
      ->Where('username', 'NOT LIKE', 'C________')
      ->count();
    $users = User::where('username', 'NOT LIKE', '__69____')
      ->where('username', 'NOT LIKE', '__18____')
      ->where('username', 'NOT LIKE', '____0___')
      ->where('username', 'NOT LIKE', 'B________')
      ->where('username', 'NOT LIKE', 'C________')
      ->orderBy('is_suspended')
      ->orderBy('username', 'asc')
      ->paginate(20);

    $data['users'] = $users;
    $data['title'] = "Superusuarios";
    $data['total'] = $total;

    return view('user.index', $data);
  }

  public function listStudents($all = null)
  {
    $total = User::where('username', 'LIKE', '__69____')
      ->orWhere('username', 'LIKE', '__18____')
      ->orWhere('username', 'LIKE', '____0___')
      ->orWhere('username', 'LIKE', 'B________')
      ->orWhere('username', 'LIKE', 'C________')
      ->count();
    $students = User::where('username', 'LIKE', '__69____')
      ->orWhere('username', 'LIKE', '__18____')
      ->orWhere('username', 'LIKE', '____0___')
      ->orWhere('username', 'LIKE', 'B________')
      ->orWhere('username', 'LIKE', 'C________')
      ->orderBy('is_suspended')
      ->orderBy('career_id', 'asc')
      ->orderBy('username', 'asc')
      ->paginate(
        (is_null($all)) ? 20 : $total
      );

    $data['users'] = $students;
    $data['title'] = "Estudiantes";
    $data['total'] = $total;

    return view('user.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $roles = Role::pluck('name', 'id');
    return view('user.new', compact('roles'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'bail|required|min:2',
      'email' => 'required|email|unique:users',
      'username' => 'required|unique:users',
      'password' => 'required', #|min:6
      //'roles' => 'required|min:1'
    ]);

    if ($request->has('is_student')) {
      $request->merge([
        'password' => trim($request->get('nip')),
        'password_confirmation' => trim($request->get('nip'))
      ]);
    } else {
      $request->merge([
        'password' => $request->get('password')
      ]);
    }

    $studentRole = Role::where('name', 'Estudiante')->first();

    // hash password
    /*$request->merge([
      'password' => $request->get('password')
    ]);*/

    // Create the user
    if ($user = User::create($request->except('roles', 'permissions', 'nip', 'is_student'))) {
      //$this->syncPermissions($request, $user);
      if ($request->has('is_student')) {
        $user->assignRole($studentRole);
      }
      flash()->success('El usuario ha sido creado');
    } else {
      flash()->error('Ocurrió un error al crear el usuario');
    }

    return redirect()->route('users.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::find($id);
    $roles = Role::pluck('name', 'id');
    $permissions = Permission::all('name', 'id');

    return view('user.edit', compact('user', 'roles', 'permissions'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = User::find($id);
    $roles = Role::pluck('name', 'id');
    $permissions = Permission::all('name', 'id');
    $careers = Career::pluck('name', 'id');

    return view('user.edit', compact('user', 'roles', 'permissions', 'careers'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'name' => 'bail|required|min:2',
      'email' => 'required|email|unique:users,email,' . $id,
      'roles' => 'required|min:1'
    ]);

    // Get the user
    $user = User::findOrFail($id);

    // Update user
    $user->fill($request->except('roles', 'permissions', 'password'));

    // check for password change
    if ($request->has('password') and !empty($request->get('password'))) {
      $user->password = $request->get('password');
    }

    if ($request->get('career_id')) {
      $user->career()->associate(Career::find($request->get('career_id')));
    }

    // Handle the user roles
    $this->syncPermissions($request, $user);

    if ($user->save()) {
      flash()->success('El usuario ha sido actualizado');
    } else {
      flash()->error('Ocurrió un error al actualizar el usuario');
    }
    return redirect()->route('users.index');
  }

  /**
   * Updates self
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function selfUpdate(Request $request, $id)
  {
    if (Auth::user()->id == $id) {
      $this->validate($request, [
        'name' => 'min:2',
        'email' => 'email|unique:users,email,' . $id,
        'roles' => 'min:1'
      ]);

      // Get the user
      $user = User::findOrFail($id);

      // Update user
      $user->fill($request->except('roles', 'permissions', 'password'));

      // check for password change
      if ($request->get('password')) {
        $user->password = $request->get('password');
      }

      if ($request->get('career_id')) {
        $user->career()->associate(Career::find($request->get('career_id')));
      }

      if ($user->save()) {
        flash()->success('Usuario actualizado');
      } else {
        flash()->error('Ocurrió un error al actualizar el usuario');
      }
      return redirect()->back();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (Auth::user()->id == $id) {
      flash()->warning('No es posible borrar al usuario activo')->important();
      return redirect()->back();
    }

    if (User::findOrFail($id)->delete()) {
      flash()->success('El usuario ha sido borrado');
    } else {
      flash()->success('Ocurrió un error al borrar el usuario');
    }

    return redirect()->back();
  }

  private function syncPermissions(Request $request, $user)
  {
    // Get the submitted roles
    $roles = $request->get('roles', []);
    $permissions = $request->get('permissions', []);

    // Get the roles
    $roles = Role::find($roles);

    // check for current role changes
    if (!$user->hasAllRoles($roles)) {
      // reset all direct permissions for user
      $user->permissions()->sync([]);
    } else {
      // handle permissions
      //$user->syncPermissions($permissions);
    }

    if (!$user->hasRole($roles)) {
      $user->assignRole($roles);
    }

    return $user;
  }

  /**
   * Toggle status of user
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function toggle($id)
  {
    $user = User::find($id);
    $user->is_suspended = ($user->is_suspended) ? false : true;
    $user->save();

    return redirect()->back();
  }

  public function upload()
  {
    #return view('user.upload'); # View for CSV file
    return view('user.load'); # View for TextArea
  }

  public function load(Request $request)
  {
    if (!empty($request->estudiantes)) {
      $filas = explode("\r\n", trim($request->estudiantes));
      foreach ($filas as $fila) {
        $estudiantes[] = explode("\t", trim($fila));
      }
      $syncedRecords = 0;
      $numRecords = 0;

      foreach ($estudiantes as $record) {
        # Verificar si existe el estudiante, sino crearlo
        $student = User::where('username', $record[0])->first();

        $numRecords++;

        if (is_null($student)) {
          $role = Role::where('name', 'Estudiante')->first();
          $career = Career::where('internal_key', $record[5])->first();

          $data = [
            'username' => $record[0],
            'name' => $record[1],
            'last_name' => trim($record[2] . " " . $record[3]),
            'email' => trim($record[0]) . "@tecvalles.mx",
            'password' => $record[4],
            'is_suspended' => false
          ];

          $student = User::create($data);
          $student->career()->associate(isset($career->id) ? $career : null);
          $student->assignRole($role);
          $student->save();
          $syncedRecords++;
        }
      }
      flash("$syncedRecords/$numRecords estudiantes procesados");
    }
    return redirect()->route('users.index');
  }

  public function sync(Request $request)
  {
    # Obtener el archivo CSV a subir
    $file = $request->file('file');

    # Obtener el nombre y tipo de archivo para ubicarlo en el Storage
    $filename = $file->getClientOriginalName();
    $filetype = $file->getClientOriginalExtension();

    if (Storage::disk('local')->exists($filename)) {
      # Verificar si existe el archivo, se borra para evitar colisiones
      Storage::disk('local')->delete($filename);
    }

    # Verificar que el archivo proporcionado sea un CSV
    if (in_array($filetype, ['csv', 'CSV'])) {
      # Almacenar el archivo CSV en el Storage para su lectura
      Storage::disk('local')->put($filename, File::get($file));

      if (Storage::disk('local')->exists($filename)) {
        $csv = Reader::createFromPath(storage_path("app/$filename"));
        $columns = ['noControl', 'name', 'lastName1', 'lastName2', 'nip', 'career'];
        $records = $csv->getRecords($columns);
        $syncedRecords = 0;
        $numRecords = 0;

        foreach ($records as $record) {
          # Verificar si existe el estudiante, sino crearlo
          $student = User::where('username', $record['noControl'])->first();
          $numRecords++;

          if (is_null($student)) {
            $role = Role::where('name', 'Estudiante')->first();
            $career = Career::where('internal_key', $record['career'])->first();

            $data = [
              'username' => $record['noControl'],
              'name' => $record['name'],
              'last_name' => trim($record['lastName1'] . " " . $record['lastName2']),
              'email' => trim($record['noControl']) . "@tecvalles.mx",
              'password' => $record['nip'],
              'is_suspended' => false
            ];

            $student = User::create($data);
            $student->career()->associate(isset($career->id) ? $career : null);
            $student->assignRole($role);
            $student->save();
            $syncedRecords++;
          }
        }

        flash("$syncedRecords/$numRecords registros procesados");
      } else {
        flash()->error('Error al procesar el archivo, intente nuevamente');
      }
    } else {
      flash()->error('Tipo de archivo incompatible, intente nuevamente');
    }

    return redirect()->route('users.index');
  }

  public function uploadActive()
  {
    return view('user.activate');
  }

  public function activate(Request $request)
  {
    # Obtener el archivo CSV a subir
    $file = $request->file('file');

    # Obtener el nombre y tipo de archivo para ubicarlo en el Storage
    $filename = $file->getClientOriginalName();
    $filetype = $file->getClientOriginalExtension();

    if (Storage::disk('local')->exists($filename)) {
      # Verificar si existe el archivo, se borra para evitar colisiones
      Storage::disk('local')->delete($filename);
    }

    # Verificar que el archivo proporcionado sea un CSV
    if (in_array($filetype, ['csv', 'CSV'])) {
      # Almacenar el archivo CSV en el Storage para su lectura
      Storage::disk('local')->put($filename, File::get($file));

      if (Storage::disk('local')->exists($filename)) {
        $csv = Reader::createFromPath(storage_path("app/$filename"));
        $columns = ['noControl'];
        $records = $csv->getRecords($columns);
        $syncedRecords = 0;
        $numRecords = 0;

        foreach ($records as $record) {
          # Busca el estudiante para activarlo
          $student = User::where('username', $record['noControl'])->first();
          $numRecords++;

          if (!is_null($student)) {
            $student->is_enrolled = true;
            $student->save();
            $syncedRecords++;
          }
        }

        flash("$syncedRecords/$numRecords registros procesados");
      } else {
        flash()->error('Error al procesar el archivo, intente nuevamente');
      }
    } else {
      flash()->error('Tipo de archivo incompatible, intente nuevamente');
    }

    return redirect()->route('users.index');
  }

  public function singleActivate($key)
  {
    $student = User::where('username', $key)->first();

    if (!is_null($student)) {
      $student->is_enrolled = true;
      $student->save();
    }

    return redirect()->route('moves.byStudent', ['key' => $key]);
  }
}