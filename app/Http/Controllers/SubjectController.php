<?php

namespace App\Http\Controllers;

use DB;
use App\Career;
use App\Subject;
use App\Http\Requests;
use Illuminate\Http\Request;

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

  public function sync()
  {
    $careers = Career::pluck('internal_key')->toJson();
    $careers = str_replace(['[', ']'], '', $careers);
    $careers = str_replace('"', '\'', $careers);
    //dd($careers);

    $subjects  = DB::connection('sybase')->select("SELECT mc.carrera, mc.reticula, mc.materia, mc.horas_teoricas AS ht, mc.horas_practicas AS hp, mc.creditos_materia AS cr, mc.especialidad, mc.semestre_reticula AS semestre, m.nombre_completo_materia AS nombre, m.nombre_abreviado_materia AS nombre_corto FROM materias_carreras AS mc, materias AS m WHERE carrera IN ({$careers}) AND m.materia = mc.materia AND mc.estatus_materia_carrera = 'A' AND m.tipo_materia <> 4");

    foreach ($subjects as $s) {
      $data = [
        'key' => $s->materia,
        'short_name' => $s->nombre_corto,
        'long_name' => $s->nombre,
        'semester' => $s->semestre,
        'ht' => $s->ht,
        'hp' => $s->hp,
        'cr' => $s->cr,
        'is_active' => true
      ];
      if ($subject = Subject::create($data)) {
        $career = Career::where('internal_key', $s->carrera)->first();
        $subject->career()->associate(isset($career->id) ? $career : null);
        $subject->save();
      }
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
   * Show the form for uploading subjects on batch.
   *
   * @return \Illuminate\Http\Response
   */
  public function batch()
  {
    //
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
