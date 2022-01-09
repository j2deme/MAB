<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Role;
use App\User;
use App\Career;
use App\Permission;
use App\Http\Requests;
use App\Traits\Authorizable;
use Illuminate\Http\Request;

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
    $_users = User::count();
    $users = User::orderBy('is_suspended')->orderBy('username', 'asc')->paginate($_users);
    return view('user.index', compact('users'));
  }

  public function cloneStudents()
  {
    $students  = DB::connection('sybase')->select("SELECT no_de_control AS no_control, nombre_alumno AS nombre, apellido_paterno, apellido_materno, carrera, nip FROM alumnos WHERE estatus_alumno = :estatus", ['estatus' => 'ACT']);

    $role = Role::where('name', 'Estudiante')->first();

    foreach ($students as $s) {
      $data = [
        'username' => $s->no_control,
        'name' => $s->nombre,
        'last_name' => "{$s->apellido_paterno} {$s->apellido_materno}",
        'email' => trim($s->no_control) . "@tecvalles.mx",
        'password' => $s->nip,
        'is_suspended' => false
      ];
      if ($student = User::create($data)) {
        $career = Career::where('internal_key', $s->carrera)->first();
        $student->career()->associate(isset($career->id) ? $career : null);
        $student->save();
        $student->assignRole($role);
      }
    }
    return redirect()->route('users.index');
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
      'password' => 'required|min:6',
      //'roles' => 'required|min:1'
    ]);

    // hash password
    $request->merge([
      'password' => $request->get('password')
    ]);

    // Create the user
    if ($user = User::create($request->except('roles', 'permissions'))) {
      //$this->syncPermissions($request, $user);
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
}
