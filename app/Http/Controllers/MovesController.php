<?php

namespace App\Http\Controllers;

use Auth;
use App\Move;
use App\Group;
use App\Career;
use App\Semester;
use Carbon\Carbon;
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
    $last_semester = Semester::last();
    if (Auth::user()->hasRole('Estudiante')) {
      $result = Auth::user()->moves()->where('semester_id', $last_semester->id)->latest()->paginate();
    } elseif (Auth::user()->hasRole('Coordinador')) {
      $result = Career::find(Auth::user()->career->id)->moves()->where('semester_id', $last_semester->id)->unattended()->paginate();
    } else {
      $result = Move::where('semester_id', $last_semester->id)->unattended()->paginate();
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

    $last = Semester::last();
    $today = Carbon::now('America/Mexico_City');
    $ups_open = ($last->begin_up <= $today and $last->end_up >= $today);
    $downs_open = ($last->begin_down <= $today and $last->end_down >= $today);

    if ($type == 'ALTA') {
      $groups = Group::where('semester_id', $last->id)->where('is_available', true)->get();
    } else {
      $groups = Group::where('semester_id', $last->id)->get();
    }
    $justifications = [
      'up' => [
        'ADELANTAR MATERIA',
        'ATRASO POR CAMBIO DE CARRERA',
        'COMPATIBILIDAD CON DOCENTE',
        'GRUPO CERRADO',
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
    return view('moves.new', compact(['type', 'groups', 'justifications', 'last', 'ups_open', 'downs_open', 'today']));
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

    $group = Group::findOrFail([$request->get('group_id')])->first();
    $is_parallel = ($group->subject->career->id != Auth::user()->career->id);
    $exists = Move::where('user_id', Auth::user()->id)
      ->where('semester_id', $last_semester->id)
      ->where('group_id', $request->get('group_id'))
      ->where('type', ($request->get('type') == 'up') ? 'ALTA' : 'BAJA')
      ->count();

    if ($exists == 0) {
      $data = [
        'user_id' => Auth::user()->id,
        'semester_id' => $last_semester->id,
        'group_id' => $request->get('group_id'),
        'type' => $request->get('type'),
        'justification' => [
          'main' => $request->get('justification'),
          'extra' => $request->get('motivation')
        ],
        'answer' => [],
        'status' => '0',
        'linked_to' => null,
        'is_parallel' => $is_parallel
      ];

      if ($move = Move::create($data)) {
        flash()->success('Solicitud registrada');
      } else {
        flash()->error('No fue posible registrar la solicitud');
      }
    } else {
      flash()->warning('Ya existe una solicitud con las mismas características');
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
    $move = Move::with(['group', 'group.subject'])->findOrFail([$id])->first();
    return view('moves.show', compact('move'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $move = Move::with(['user', 'group'])->findOrFail([$id])->first();
    if ($move->status == '0') {
      $move->status = '1';
      $move->save();
    }
    $answers = [
      '1 EMPALME',
      '2 EMPALMES',
      '3+ EMPALMES',
      'ADEUDA CORREQUISITO',
      'ADEUDA PREREQUISITO',
      'EXCESO DE CRÉDITOS',
      'GRUPO A CAPACIDAD MÁXIMA',
      'NO AUTORIZADO POR SITUACIÓN ACADÉMICA',
      'NO EQUIVALENTE',
      'NO SE AUTORIZAN BAJAS PARA 1ER SEMESTRE',
      'SIN PROBLEMAS',
    ];
    return view('moves.check', compact('move', 'answers'));
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
    $move = Move::findOrFail([$id])->first();
    if ($request->has('acceptBtn')) {
      // Aceptada por coordinador: 3
      // Aceptada por jefe / admin: 4
      $move->status = (Auth::user()->hasRole('Coordinador')) ? '3' : '4';
    } else {
      // Rechazada por coordinador: 2
      // Rechazada por jefe / admin: 5
      $move->status = (Auth::user()->hasRole('Coordinador')) ? '2' : '5';
    }
    $move->answer = [
      'main' => $request->get('answer'),
      'extra' => $request->get('extra')
    ];

    if ($move->save()) {
      flash()->success('Solicitud atendida');
    } else {
      flash()->error('Ocurrió un error al atender la solicitud');
    }

    return redirect()->route('moves.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (Move::findOrFail($id)->delete()) {
      flash()->success('La solicitud ha sido cancelada');
    } else {
      flash()->error('La solicitud no ha sido cancelada');
    }

    return redirect()->back();
  }

  public function byCareer($key)
  {
    $last_semester = Semester::last();
    $career = Career::where('key', $key)->first();
    $result = $career->moves()->where('semester_id', $last_semester->id)->unattended()->paginate();
    return view('moves.index', compact('result', 'key'));
  }
}
