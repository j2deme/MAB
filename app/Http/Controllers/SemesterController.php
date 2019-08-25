<?php

namespace App\Http\Controllers;

use App\Semester;
use App\Http\Requests;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $result = Semester::orderBy('created_at', 'desc')->paginate();
    return view('semester.index', compact('result'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('semester.new');
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
      'key' => 'bail|required|min:5|unique:semesters',
      'short_name' => 'required|unique:semesters',
      'long_name' => 'required'
    ]);

    // Create the semester
    if ($semester = Semester::create($request->all())) {
      flash('El semestre ha sido creado');
    } else {
      flash()->error('Ocurrió un error al crear el semestre');
    }

    return redirect()->route('semesters.index');
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
    $semester = Semester::findOrFail($id)->first();

    return view('semester.edit', compact('semester'));
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
    $semester = Semester::findOrFail($id)->first();

    $this->validate($request, [
      'short_name' => 'required',
      'long_name' => 'required'
    ]);

    $semester->short_name = $request->get('short_name');
    $semester->long_name = $request->get('long_name');
    $semester->begin_up = $request->get('begin_up');
    $semester->end_up = $request->get('end_up');
    $semester->begin_down = $request->get('begin_down');
    $semester->end_down = $request->get('end_down');

    // Create the semester
    if ($semester->save()) {
      flash()->success('El semestre ha sido actualizado');
    } else {
      flash()->error('Ocurrió un error al actualizar el semestre');
    }

    return redirect()->route('semesters.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  /**
   * Toggle status of semester
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function toggle($id)
  {
    $semester = Semester::findOrFail($id);
    $semester->is_active = ($semester->is_active) ? false : true;
    $semester->save();

    return redirect()->back();
  }
}
