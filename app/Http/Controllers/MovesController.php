<?php

namespace App\Http\Controllers;

use Auth;
use App\Move;
use App\Group;
use App\Semester;
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
      $result = Move::paginate();
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

    $last_semester = Semester::last();

    $groups = Group::where('semester_id', $last_semester->id)->where('is_available', true)->get();
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
    $last_semester = Semester::last();
    $this->validate($request, [
      'group_id' => 'required',
      'justification' => 'required'
    ]);

    $data = [
      'semester_id' => $last_semester->id,
      'group_id' => $request->get('group_id'),
      'justification' => [
        'main' => $request->get('justification'),
        'extra' => $request->get('motivation')
      ],
      'user_id' => Auth::user()->id,
      'answer' => [],
      'status' => '0',
      'linked_to' => null,
      'type' => $request->get('type')
    ];

    if ($move = Move::create($data)) {
      flash('Solicitud registrada');
    } else {
      flash()->error('No fue posible registrar la solicitud');
    }

    return redirect()->route('moves.index');
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
