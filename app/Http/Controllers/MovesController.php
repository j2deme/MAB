<?php

namespace App\Http\Controllers;

use Auth;
use App\Move;
use App\Subject;
use App\Http\Requests;
use Illuminate\Http\Request;

class MovesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (Auth::user()->hasRole('Estudiante')) {
      $result = Auth::user()->moves()->latest()->paginate();
    } elseif (Auth::user()->hasRole('Coordinador')) {
      $result = Career::find(Auth::user()->career->id)->moves()->latest()->paginate();
    } else {
      $result = Moves::all()->paginate();
    }
    return view('moves.index', compact('result'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($type)
  {
    if (!in_array($type, ['up', 'down'])) {
      return redirect()->back();
    }

    $groups = Subject::where('career_id', Auth::user()->career->id)->get();
    $justifications = [
      'up' => [
        'ADELANTAR MATERIA',
        'ATRASO POR CAMBIO DE CARRERA',
        'COMPATIBILIDAD CON DOCENTE',
        'GRUPO CERRADO',
        'NO PERMITIÓ SELECCIONAR EN EL SII',
        'SE AGOTÓ EL TIEMPO DE SELECCIÓN',
        'TOMAR MATERIA DE RECURSAMIENTO',
        'TOMAR MATERIA DE CURSO ESPECIAL',
      ],
      'down' => [
        'DIFICULTAD PARA ASISTIR',
        'EMPALME',
        'HORARIO DISTANTE DEL BLOQUE',
        'HORARIO SOBRECARGADO',
        'INCOMPATIBILIDAD CON EL DOCENTE',
        'BAJA TEMPORAL',
      ]
    ];
    return view('moves.new', compact(['type', 'groups', 'justifications']));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
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
    //
  }
}
