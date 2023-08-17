<?php

namespace App\Http\Controllers;

use App\Career;
use App\Subject;
use App\Http\Requests;
use Illuminate\Http\Request;
use League\Csv\Reader;
use Storage;
use File;

class SubjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $result = Subject::orderBy('career_id')->paginate();
    return view('subject.index', compact('result'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $careers = Career::pluck('name', 'id');

    return view('subject.new', compact('careers'));
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
      'key' => 'bail|required|min:5',
      'short_name' => 'required',
      'long_name' => 'required',
      'career_id' => 'required|exists:careers,id',
      'semester' => 'required',
      'ht' => 'required',
      'hp' => 'required',
      'cr' => 'required'
    ]);

    // Create the semester
    if ($subject = Subject::create($request->all())) {
      flash('La materia ha sido creada');
    } else {
      flash()->error('No es posible crear la materia');
    }

    return redirect()->route('subjects.index');
  }

  public function upload()
  {
    #return view('subject.upload'); # View for CSV file
    return view('subject.load'); # View for TextArea
  }

  public function load(Request $request)
  {
    if (!empty($request->materias)) {
      $filas = explode("\r\n", trim($request->materias));
      foreach ($filas as $fila) {
        $materias[] = explode("\t", trim($fila));
      }
      $syncedRecords = 0;
      $numRecords = count($materias);

      foreach ($materias as $record) {
        $recordData = [
          'key' => $record[0],
          'short_name' => $record[1],
          'long_name' => $record[2],
          'semester' => (int) $record[4],
          'ht' => (int) $record[5],
          'hp' => (int) $record[6],
          'cr' => (int) $record[7],
        ];
        $career_id = $record[3];

        # Verificar los registros a cargar, para evitar duplicados
        $subject = Subject::where('key', $recordData['key'])->first();

        # Crear registro sino existe previamente
        if (is_null($subject)) {
          $recordData['is_active'] = true;
          $career = Career::where('internal_key', $career_id)->first();
          $recordData['career_id'] = $career->id;
          if ($subject = Subject::create($recordData)) {
            $syncedRecords++;
          }
        }
      }
      flash("$syncedRecords/$numRecords registros procesados");
    }
    return redirect()->route('subjects.index');
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
        $columns = ['key', 'short_name', 'long_name', 'career_id', 'semester', 'ht', 'hp', 'cr'];
        $records = $csv->getRecords($columns);
        $syncedRecords = 0;
        $numRecords = 0;
        foreach ($records as $record) {
          $recordData = [
            'key' => $record['key'],
            'short_name' => $record['short_name'],
            'long_name' => $record['long_name'],
            'semester' => (int) $record['semester'],
            'ht' => (int) $record['ht'],
            'hp' => (int) $record['hp'],
            'cr' => (int) $record['cr'],
          ];

          # Verificar cada registro del CSV en caso de que ya exista
          $subject = Subject::where('key', $recordData['key'])->first();
          $numRecords++;

          # Crear registro sino existe previamente
          if (is_null($subject)) {
            $recordData['is_active'] = true;
            $career = Career::where('internal_key', $record['career_id'])->first();
            $recordData['career_id'] = $career->id;
            if ($subject = Subject::create($recordData)) {
              $syncedRecords++;
            }
          }
        }
        flash("$syncedRecords/$numRecords registros procesados");
      } else {
        flash()->error('Error al procesar el archivo, intente nuevamente');
      }
    } else {
      flash()->error('Tipo de archivo incompatible, intente nuevamente');
    }
    return redirect()->route('subjects.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (Subject::findOrFail($id)->delete()) {
      flash()->success('La materia ha sido borrada');
    } else {
      flash()->success('La materia no ha sido borrada');
    }

    return redirect()->back();
  }

  /**
   * Toggle status of subject
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function toggle($id)
  {
    $subject = Subject::findOrFail($id);
    $subject->is_active = !($subject->is_active);
    $subject->save();

    return redirect()->back();
  }
}