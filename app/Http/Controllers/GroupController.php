<?php

namespace App\Http\Controllers;

use App\Group;
use App\Subject;
use App\Semester;
use App\Http\Requests;
use Illuminate\Http\Request;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GroupController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $semester = Semester::whereIsActive(true)->orderBy('key', 'desc')->first();

    if (is_null($semester)) {
      $result = [];
    } else {
      $result = Group::where('semester_id', $semester->id)
        ->orderBy('semester_id', 'desc')
        ->orderBy('subject_id', 'asc')
        ->orderBy('name', 'asc')
        ->paginate();
    }

    $data['result']   = $result;
    $data['semester'] = $semester;
    return response()->view('group.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $semesters = Semester::orderBy('id', 'desc')->pluck('long_name', 'id');
    $subjects  = Subject::orderBy('career_id', 'asc')->orderBy('semester', 'asc')->where('is_active', true)->get();

    return response()->view('group.new', compact('semesters', 'subjects'));
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
      'name' => 'bail|required',
      'semester_id' => 'required',
      'subject_id' => 'required'
    ]);

    $exists = Group::where('semester_id', $request->get('semester_id'))->where('subject_id', $request->get('subject_id'))->where('name', $request->get('name'))->count();
    if ($exists != 0) {
      flash()->error('Ya existe un grupo con las mismas características e identificador');
    } else {
      // Create the group
      if ($group = Group::create($request->all())) {
        flash('El grupo ha sido creado');
      } else {
        flash()->error('No es posible crear el grupo');
      }
    }


    return redirect()->route('groups.index');
  }

  public function upload()
  {
    $data['semester'] = Semester::whereIsActive(true)->orderBy('key', 'desc')->first();
    # return response()->view('group.upload', $data); # View for CSV
    return response()->view('group.load', $data); # View for TextArea
  }

  public function load(Request $request)
  {
    if (!empty($request->grupos)) {
      $filas = explode("\r\n", trim($request->grupos));
      foreach ($filas as $fila) {
        $grupos[] = explode("\t", trim($fila));
      }
      $syncedRecords = 0;
      $numRecords    = count($grupos);
      $semester      = Semester::whereIsActive(true)->orderBy('key', 'desc')->first();

      foreach ($grupos as $record) {
        # Verificar si existe la materia
        $subject = Subject::where('key', trim($record[0]))->first();

        if (is_null($subject)) { # Si no existe la materia, se detiene el proceso
          flash()->error("No existe la materia con identificador {$record[0]}");
          return redirect()->route('users.index');
        }

        # Verificar si existe el grupo para el periodo, sino crearlo
        $group = Group::where('subject_id', $subject->id)
          ->where('semester_id', $semester->id)
          ->where('name', trim($record[1]))
          ->first();

        if (is_null($group)) {
          $data  = [
            'name' => $record[1],
            'is_available' => true,
            'subject_id' => $subject->id,
            'semester_id' => $semester->id
          ];
          $group = Group::create($data);
          $syncedRecords++;
        }
      }
      flash("$syncedRecords/$numRecords grupos procesados");
    }
    return redirect()->route('groups.index');
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
        $csv           = Reader::createFromPath(storage_path("app/$filename"));
        $columns       = ['subject', 'name'];
        $records       = $csv->getRecords($columns);
        $syncedRecords = 0;
        $numRecords    = 0;
        $semester      = Semester::whereIsActive(true)->orderBy('key', 'desc')->first();

        foreach ($records as $record) {
          # Verificar si existe el grupo para el periodo, sino crearlo
          $subject = Subject::where('key', trim($record['subject']))->first();
          $group   = Group::where('subject_id', $subject->id)
            ->where('semester_id', $semester->id)
            ->where('name', trim($record['name']))
            ->first();
          $numRecords++;

          if (is_null($group)) {
            $data  = [
              'name' => $record['name'],
              'is_available' => true,
              'subject_id' => $subject->id,
              'semester_id' => $semester->id
            ];
            $group = Group::create($data);
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

    return redirect()->route('groups.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function show($id)
  // {
  //   //
  // }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function edit($id)
  // {
  //   //
  // }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function update(Request $request, $id)
  // {
  //   //
  // }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $group = Group::findOrFail($id);
    if ($group->moves->count() > 0) {
      flash()->error('No es posible eliminar el grupo, ya tiene movimientos registrados');
    } else {
      $group->delete();
      flash()->success('El grupo ha sido eliminado');
    }

    return redirect()->back();
  }

  /**
   * Toggle status of group
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function toggle($id)
  {
    $group               = Group::findOrFail($id);
    $group->is_available = !($group->is_available);
    $group->save();

    return redirect()->back();
  }
}