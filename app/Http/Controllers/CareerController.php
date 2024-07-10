<?php

namespace App\Http\Controllers;

use App\Career;
use App\Http\Requests;
use Illuminate\Http\Request;

class CareerController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $result = Career::orderBy('internal_key', 'asc')->paginate();
    return response()->view('career.index', compact('result'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return response()->view('career.new');
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
      'acronym' => 'bail|required|min:3|unique:careers',
      'name' => 'bail|required|unique:careers',
      'internal_key' => 'bail|required|integer|unique:careers'
    ]);

    $career               = new Career;
    $career->acronym      = $request->input('acronym');
    $career->name         = $request->input('name');
    $career->internal_key = $request->input('internal_key');

    if ($career->save()) {
      flash('La carrera ha sido creada');
    } else {
      flash()->error('Ocurrió un error al crear la carrera');
    }

    return redirect()->route('careers.index');
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
  public function edit($id)
  {
    $career = Career::findOrFail($id);
    return response()->view('career.edit', compact('career'));
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
      'acronym' => 'bail|required|min:3|unique:careers,acronym,' . $id,
      'name' => 'bail|required|unique:careers,name,' . $id,
      'internal_key' => 'bail|required|integer|unique:careers,internal_key,' . $id
    ]);

    $career               = Career::findOrFail($id);
    $career->acronym      = $request->input('acronym');
    $career->name         = $request->input('name');
    $career->internal_key = $request->input('internal_key');

    if ($career->save()) {
      flash('La carrera ha sido actualizada');
    } else {
      flash()->error('Ocurrió un error al actualizar la carrera');
    }

    return redirect()->route('careers.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $career = Career::findOrFail($id);

    if ($career->delete()) {
      flash('La carrera ha sido eliminada');
    } else {
      flash()->error('Ocurrió un error al eliminar la carrera');
    }

    return redirect()->route('careers.index');
  }
}
