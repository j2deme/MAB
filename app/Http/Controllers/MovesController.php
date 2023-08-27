<?php

namespace App\Http\Controllers;

use Auth;
use App\Move;
use App\Group;
use App\Career;
use App\Subject;
use App\Semester;
use App\Permuta;
use App\User;
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
  public function index($all = null)
  {
    $last_semester = Semester::last();
    if (Auth::user()->hasRole('Estudiante')) {
      $result = Auth::user()->moves()->where('semester_id', $last_semester->id)->latest()->paginate();
    } elseif (Auth::user()->hasRole('Coordinador')) {
      $result = Career::find(Auth::user()->career->id)->moves()->where('semester_id', $last_semester->id)->unattended()->paginate();
    } else {
      $result = Move::where('semester_id', $last_semester->id)->unattendedParallel();

      $result = (!is_null($all)) ? $result->get() : $result->paginate();
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
    $max_ups = $last->max_ups;
    $ups_open = ($last->begin_up <= $today and $last->end_up >= $today);
    $downs_open = ($last->begin_down <= $today and $last->end_down >= $today);

    $moves = ($type == 'up') ? Move::where('user_id', Auth::user()->id)
      ->where('semester_id', $last->id)
      ->where('type', 'ALTA')
      ->get() : [];

    if ($type == 'up') {
      $groups = Group::where('semester_id', $last->id)->where('is_available', true)->get();
    } else {
      $groups = Group::where('semester_id', $last->id)->get();
    }
    $justifications = [
      'up' => [
        //'CAMBIO DE BLOQUE', # AD 2023 - Se retira opción por nueva nomeclatura de grupos
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
    return view('moves.new', compact(['type', 'groups', 'justifications', 'last', 'ups_open', 'downs_open', 'today', 'moves', 'max_ups']));
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
      flash()->warning('Ya existe una solicitud idéntica');
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

    if ($request->has('url')) {
      return redirect($request->get('url'));
    } else {
      return redirect()->route('home.index');
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
    if (Move::findOrFail($id)->delete()) {
      flash()->success('La solicitud ha sido cancelada');
    } else {
      flash()->error('Ocurrió un error al cancelar la solicitud');
    }

    return redirect()->back();
  }

  public function cancel($id)
  {
    $move = Move::findOrFail($id);
    // Rechazada por coordinador: 2
    // Rechazada por jefe / admin: 5
    $move->status = (Auth::user()->hasRole('Coordinador')) ? '2' : '5';
    $move->answer = [
      'main' => 'MOVIMIENTO NO DISPONIBLE',
      'extra' => ''
    ];
    if ($move->save()) {
      flash()->success('La solicitud ha sido rechazada');
    } else {
      flash()->error('Ocurrió un error al rechazar la solicitud');
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

  /**
   * Show a list of moves ordered by semesters and subject
   */
  public function listBySubject()
  {
    $last_semester = Semester::last();
    if (!is_null(Auth::user()->career)) {
      $result = Move::with('group.subject')->where('semester_id', $last_semester->id);

      $result = ($last_semester->has_ended) ? $result->attended() : $result->unattended();
      $result = $result->get();

      $result = $result->filter(function ($move, $key) {
        if (Auth::user()->career->key == 'IIA') {
          $IAMB = Career::where('key', 'IAMB')->first();
          return (in_array($move->group->subject->career->id, [Auth::user()->career->id, $IAMB->id]));
        } else {
          return ($move->group->subject->career->id == Auth::user()->career->id);
        }
      });
    } else {
      // Jefe / Admin
      $result = Move::with('group.subject')->where('semester_id', $last_semester->id);

      $result = ($last_semester->has_ended) ? $result->attended(true) : $result->unattendedParallel();
      $result = $result->get();
    }

    $groupedBySemester = $result->sortBy('group.subject.semester')->groupBy('group.subject.semester');

    $groupedBySemester->transform(function ($item, $key) {
      return $item->sortBy('group.subject.key')->groupBy('group.subject.key');
    });

    $subjects = Subject::all()->pluck('short_name', 'key');

    return view('moves.list-semester-subject', compact('groupedBySemester', 'subjects'));
  }

  /**
   * Show a table with moves filtered by subject
   */
  public function bySubject(Request $request, $key, $all = null)
  {
    $subject = Subject::where('key', $key)->first();
    $last_semester = Semester::last();
    $groups = Group::where('semester_id', $last_semester->id)->where('subject_id', $subject->id)->pluck('id');

    $result = Move::with('group', 'group.subject', 'user')
      ->where('semester_id', $last_semester->id)
      ->whereIn('group_id', $groups);

    $result = ($last_semester->has_ended) ? $result : $result->whereIn('status', ['0', '1']);
    $result = (!is_null(Auth::user()->career)) ? $result->parallel(false) : $result;

    if (!empty($request->sort)) {
      switch ($request->sort) {
        case 'student':
          $result = $result->orderBy('user_id', 'asc')->orderBy('type', 'desc');
          break;
        case 'group':
          $result = $result->orderBy('group_id', 'asc');
          break;
        case 'type':
          $result = $result->orderBy('type', 'asc')->orderBy('user_id', 'asc');
          break;
        case 'status':
          $result = $result->orderBy('status', 'asc');
          break;
        default:
          $result = $result->orderBy('group.name');
          break;
      }
    }

    $result = (!is_null($all)) ? $result->get() : $result->paginate();

    $ups = $downs = 0;
    foreach ($result as $move) {
      if ($move->type == 'ALTA') {
        $ups++;
      } else {
        $downs++;
      }
    }

    if (!is_null(Auth::user()->career) and Auth::user()->career->id == 4) { // Industrial
      //dd($result);
    }

    $url = route('moves.listBySubject');
    session(['url' => $url]);

    return view('moves.index', compact('result', 'subject', 'url', 'ups', 'downs'));
  }

  /**
   * Show a list of moves ordered by generation
   */
  public function listByStudent()
  {
    $last_semester = Semester::last();
    if (!is_null(Auth::user()->career)) {
      $result = Move::with('user.career')->where('semester_id', $last_semester->id);

      $result = ($last_semester->has_ended) ? $result->attended() : $result->unattended();
      $result = $result->get();

      $result = $result->filter(function ($move, $key) {
        if (Auth::user()->career->key == 'IIA') {
          $IAMB = Career::where('key', 'IAMB')->first();
          return (in_array($move->user->career->id, [Auth::user()->career->id, $IAMB->id]));
        } else {
          return ($move->user->career->id == Auth::user()->career->id);
        }
      });
    } else {
      // Jefe / Admin
      $result = Move::with('user.career')->where('semester_id', $last_semester->id);

      $result = ($last_semester->has_ended) ? $result->attended(true) : $result->unattendedParallel();
      $result = $result->get();
    }

    $groupedByUser = $result->sortBy('user.username');

    $generations = [];
    $students = [];
    foreach ($groupedByUser as $move) {
      $no_control = $move->user->username;
      if (ctype_alpha($no_control[0])) {
        $no_control = substr($no_control, 1);
      }

      $gen = substr($no_control, 0, 2);
      if (!array_key_exists($gen, $generations)) {
        $generations[$gen] = [];
      }

      if (!array_key_exists($no_control, $generations[$gen])) {
        $generations[$gen][$no_control] = [];
      }

      if (!array_key_exists($no_control, $students)) {
        $students[$no_control] = 1;
      } else {
        $students[$no_control]++;
      }

      $generations[$gen][$no_control] = $move;
    }
    $generations = collect($generations);

    return view('moves.list-generations', compact('generations', 'students'));
  }

  /**
   * Show a list of moves ordered by generation where students
   * request a group switch for a subject
   */
  public function listByGroups()
  {
    $last_semester = Semester::last();
    if (!is_null(Auth::user()->career)) {
      $result = Move::with('user.career')->where('semester_id', $last_semester->id)->unattendedSwitch()->get();
      $result1 = $result->filter(function ($move, $key) {
        if (Auth::user()->career->key == 'IIA') {
          $IAMB = Career::where('key', 'IAMB')->first();
          return (in_array($move->user->career->id, [Auth::user()->career->id, $IAMB->id]));
        } else {
          return ($move->user->career->id == Auth::user()->career->id);
        }
      });

      $groupedByUser = $result1->sortBy('user.username');
      $generations = [];
      $students = [];
      foreach ($groupedByUser as $move) {
        $no_control = $move->user->username;
        $gen = substr($no_control, 0, 2);
        if (!array_key_exists($gen, $generations)) {
          $generations[$gen] = [];
        }

        if (!array_key_exists($no_control, $generations[$gen])) {
          $generations[$gen][$no_control] = [];
        }

        if (!array_key_exists($no_control, $students)) {
          $students[$no_control] = 1;
        } else {
          $students[$no_control]++;
        }

        $generations[$gen][$no_control] = $move;
      }
      $generations = collect($generations);
    } else {
      // Jefe / Admin
      $result = Move::with('user.career')->where('semester_id', $last_semester->id)->unattendedSwitch()->get();

      $groupedByUser = $result->sortBy('user.username');
      $generations = [];
      $students = [];
      foreach ($groupedByUser as $move) {
        $no_control = $move->user->username;
        $gen = substr($no_control, 0, 2);
        if (!array_key_exists($gen, $generations)) {
          $generations[$gen] = [];
        }

        if (!array_key_exists($no_control, $generations[$gen])) {
          $generations[$gen][$no_control] = [];
        }

        if (!array_key_exists($no_control, $students)) {
          $students[$no_control] = 1;
        } else {
          $students[$no_control]++;
        }

        $generations[$gen][$no_control] = $move;
      }
      $generations = collect($generations);
    }
    $title = "Solicitudes de cambio de grupo";

    return view('moves.list-generations', compact('generations', 'students', 'title'));
  }

  /**
   * Show a table with group switches for the current semester
   */
  public function listPermutas()
  {
    $last_semester = Semester::last();
    # Buscar  matches en permutas registradas con candidato
    $permutasCandidato = Permuta::with('user')->where('semester_id', $last_semester->id)->where('status', 0)->where('candidate', '<>', '')->get();
    if (count($permutasCandidato) > 0) {
      foreach ($permutasCandidato as $permuta) {
        # Revisa si existe el candidato propuesto
        $match_user = User::where('username', $permuta->candidate)->first();
        if (is_object($match_user)) {
          $match = Permuta::where('user_id', $match_user->id)
            ->where('semester_id', $last_semester->id)
            ->where('candidate', $permuta->user->username)
            ->first();
          if (is_object($match)) {
            $permuta->status = 1;
            $permuta->save();

            $match->status = 1;
            $match->save();
          }
        }
      }
    }

    $permutas = Permuta::with('user.career')->where('semester_id', $last_semester->id)->orderBy('candidate', 'desc')->paginate();

    $title = "Solicitudes de cambio de grupo";

    return view('moves.list-permutas', compact('permutas', 'students', 'title'));
  }

  /**
   * Show a table with moves filtered by student
   */
  public function byStudent($key)
  {
    $user = User::where('username', $key)->first();
    $last_semester = Semester::last();
    $result = $user->moves()->where('semester_id', $last_semester->id);

    $result = (!is_null(Auth::user()->career)) ? $result->parallel(false) : $result;
    $result = $result->paginate();

    $url = route('moves.listByStudent');
    session(['url' => $url]);

    return view('moves.index', compact('result', 'user', 'url'));
  }

  public function byTypeRegistered($all = null)
  {
    $last_semester = Semester::last();
    if (!is_null(Auth::user()->career)) {
      $career = Career::find(Auth::user()->career->id)->first();
      $result = $career->moves()->where('semester_id', $last_semester->id)->registered();
      $result = (!is_null($all)) ? $result->get() : $result->paginate();
    } else {
      $result = Move::where('semester_id', $last_semester->id)->registered(true);
      $result = (!is_null($all)) ? $result->get() : $result->paginate();
    }

    $url = route('home.index');

    $extra = "Sin Atender";

    return view('moves.index', compact('result', 'url', 'extra'));
  }

  public function byTypeRevision()
  {
    $last_semester = Semester::last();
    if (!is_null(Auth::user()->career)) {
      $career = Career::find(Auth::user()->career->id);
      $result = $career->moves()->where('semester_id', $last_semester->id)->onRevision()->paginate();
    } else {
      $result = Move::where('semester_id', $last_semester->id)->onRevision(true)->paginate();
    }

    $url = route('home.index');

    $extra = "En Revisión";

    return view('moves.index', compact('result', 'url', 'extra'));
  }

  public function byTypeAttended()
  {
    $last_semester = Semester::last();
    if (!is_null(Auth::user()->career)) {
      $career = Career::find(Auth::user()->career->id)->first();
      $result = $career->moves()->where('semester_id', $last_semester->id)->attended()->paginate();
    } else {
      $_all = Move::where('semester_id', $last_semester->id)->count();
      $result = Move::where('semester_id', $last_semester->id)->attended(true)->paginate($_all);
    }

    $url = route('home.index');

    $extra = "Aceptadas y Rechazadas";

    return view('moves.index', compact('result', 'url', 'extra'));
  }

  public function switchGroup()
  {
    $last_semester = Semester::last();
    $permuta = Permuta::where('user_id', Auth::user()->id)
      ->where('semester_id', $last_semester->id)
      ->first();
    $active_permuta = (is_object($permuta));

    return view('moves.switch-form', compact('permuta', 'active_permuta', 'last_semester'));
  }

  public function saveSwitchGroup(Request $request)
  {
    $last_semester = Semester::last();
    $this->validate($request, [
      'base_semester' => 'required',
      'base_group' => 'required',
      'switch_group' => 'required'
    ]);

    $exists = Permuta::where('user_id', Auth::user()->id)
      ->where('semester_id', $last_semester->id)
      ->count();

    $request->merge(['candidate' => trim($request->get('candidate'))]);
    $candidate = $request->get('candidate');

    # Limita a un registro de permuta por periodo
    if ($exists == 0) {
      $data = [
        'user_id' => Auth::user()->id,
        'semester_id' => $last_semester->id,
        'base_semester' => $request->get('base_semester'),
        'base_group' => $request->get('base_group'),
        'switch_group' => $request->get('switch_group'),
        'candidate' => $candidate,
        'status' => '0',
        'answer' => ''
      ];

      if ($permuta = Permuta::create($data)) {
        flash()->success('Solicitud de cambio de grupo registrada');
      } else {
        flash()->error('No fue posible registrar la solicitud');
      }
    } else {
      flash()->warning('Ya existe una solicitud de cambio de grupo para este periodo');
    }

    return redirect()->route('moves.switchGroup');

  }
}