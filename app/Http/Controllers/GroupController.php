<?php

namespace App\Http\Controllers;

use DB;
use App\Group;
use App\Subject;
use App\Semester;
use App\Http\Requests;
use Illuminate\Http\Request;

class GroupController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $semester = Semester::last();
    //dd($semester);
    $result = Group::where('semester_id', $semester->id)->orderBy('semester_id', 'desc')->orderBy('subject_id', 'asc')->orderBy('name', 'asc')->paginate();
    return view('group.index', compact('result','semester'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $semesters = Semester::orderBy('key', 'desc')->pluck('long_name', 'id');
    $subjects = Subject::orderBy('career_id', 'asc')->orderBy('semester', 'asc')->where('is_active', true)->get();

    return view('group.new', compact('semesters', 'subjects'));
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

  public function sync()
  {
    $semester = Semester::last();

    $groups  = DB::connection('sybase')->select("SELECT materia, grupo AS clave FROM grupos WHERE periodo = :periodo AND materia NOT LIKE '%MOD_' AND materia NOT LIKE '%T__'", ['periodo' => $semester->key]);
    //dd($groups);

    foreach ($groups as $g) {
      $data = [
        'name' => $g->clave,
        'is_available' => true
      ];
      # Verificar si existe el grupo para el periodo, sino crearlo
      $subject = Subject::where('key', trim($g->materia))->first();
      $model = Group::where('subject_id', $subject->id)->firstOr(function ($data, $subject) {
        if ($group = Group::create($data)) {
          #$subject = Subject::where('key', trim($g->materia))->first();
          $group->subject()->associate(isset($subject->id) ? $subject : null);
          $group->semester()->associate($semester);
          $group->save();
        }
      });
    }
    return redirect()->route('groups.index');
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

  /**
   * Toggle status of group
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function toggle($id)
  {
    $group = Group::findOrFail($id);
    $group->is_available = !($group->is_available);
    $group->save();

    return redirect()->back();
  }

  public function load(){
    echo "Loading...";
    $semester = Semester::last();

    $groups = [
      ['IAGR11 ', 'A'],
      ['IAGR11', 'B'],
      ['IAGR12', 'A'],
      ['IAGR12', 'B'],
      ['IAGR13', 'A'],
      ['IAGR13', 'B'],
      ['IAGR14', 'A'],
      ['IAGR14', 'B'],
      ['IAGR15', 'A'],
      ['IAGR15', 'B'],
      ['IAGR16', 'A'],
      ['IAGR16', 'B'],
      ['IAGR21', 'R'],
      ['IAGR31', 'A'],
      ['IAGR31', 'B'],
      ['IAGR32', 'A'],
      ['IAGR32', 'B'],
      ['IAGR33', 'A'],
      ['IAGR33', 'B'],
      ['IAGR34', 'A'],
      ['IAGR34', 'B'],
      ['IAGR35', 'A'],
      ['IAGR35', 'B'],
      ['IAGR36', 'A'],
      ['IAGR36', 'B'],
      ['IAMB11', 'A'],
      ['IAMB12', 'A'],
      ['IAMB13', 'A'],
      ['IAMB14', 'A'],
      ['IAMB15', 'A'],
      ['IAMB16', 'A'],
      ['IAMB21', 'A'],
      ['IAMB25', 'RP'],
      ['IAMB32', 'A'],
      ['IAMB33', 'A'],
      ['IAMB34', 'A'],
      ['IAMB35', 'A'],
      ['IAMB36', 'A'],
      ['IAMB44', 'A'],
      ['IAMB51', 'A'],
      ['IAMB53', 'A'],
      ['IAMB54', 'A'],
      ['IAMB55', 'A'],
      ['IAMB56', 'A'],
      ['IAMB71', 'A'],
      ['IAMB72', 'A'],
      ['IAMB73', 'A'],
      ['IAMB75', 'A'],
      ['IAMB76U', 'A'],
      ['IAMB78U', 'A'],
      ['IGE11  ', 'A'],
      ['IGE11  ', 'B'],
      ['IGE11  ', 'C'],
      ['IGE12  ', 'A'],
      ['IGE12  ', 'B'],
      ['IGE12  ', 'C'],
      ['IGE13  ', 'A'],
      ['IGE13  ', 'B'],
      ['IGE13  ', 'C'],
      ['IGE14  ', 'A'],
      ['IGE14  ', 'B'],
      ['IGE14  ', 'C'],
      ['IGE15  ', 'A'],
      ['IGE15  ', 'B'],
      ['IGE15  ', 'C'],
      ['IGE16  ', 'A'],
      ['IGE16  ', 'B'],
      ['IGE16  ', 'C'],
      ['IGE31  ', 'A'],
      ['IGE31  ', 'B'],
      ['IGE31  ', 'C'],
      ['IGE32  ', 'A'],
      ['IGE32  ', 'B'],
      ['IGE32  ', 'C'],
      ['IGE33  ', 'A'],
      ['IGE33  ', 'B'],
      ['IGE33  ', 'C'],
      ['IGE34  ', 'A'],
      ['IGE34  ', 'B'],
      ['IGE34  ', 'C'],
      ['IGE35  ', 'A'],
      ['IGE35  ', 'B'],
      ['IGE35  ', 'C'],
      ['IGE36  ', 'A'],
      ['IGE36  ', 'B'],
      ['IGE36  ', 'C'],
      ['IGE51  ', 'A'],
      ['IGE51  ', 'B'],
      ['IGE51  ', 'C'],
      ['IGE52  ', 'A'],
      ['IGE52  ', 'B'],
      ['IGE52  ', 'C'],
      ['IGE53  ', 'A'],
      ['IGE53  ', 'B'],
      ['IGE53  ', 'C'],
      ['IGE54  ', 'A'],
      ['IGE54  ', 'B'],
      ['IGE54  ', 'C'],
      ['IGE55  ', 'A'],
      ['IGE55  ', 'B'],
      ['IGE55  ', 'C'],
      ['IGE56  ', 'A'],
      ['IGE56  ', 'B'],
      ['IGE56  ', 'C'],
      ['IGE71  ', 'A'],
      ['IGE71  ', 'B'],
      ['IGE71  ', 'C'],
      ['IGE72  ', 'A'],
      ['IGE72  ', 'B'],
      ['IGE72  ', 'C'],
      ['IGE73  ', 'A'],
      ['IGE73  ', 'B'],
      ['IGE73  ', 'C'],
      ['IGE74  ', 'A'],
      ['IGE74  ', 'B'],
      ['IGE74  ', 'C'],
      ['IGE75  ', 'A'],
      ['IGE75  ', 'B'],
      ['IGE75  ', 'C'],
      ['IGE76  ', 'A'],
      ['IGE76  ', 'B'],
      ['IGE76  ', 'C'],
      ['IGEDG77', 'A'],
      ['IGEDG77', 'B'],
      ['IGEDG77', 'C'],
      ['IGEM11 ', 'A'],
      ['IGEM11 ', 'B'],
      ['IGEM12 ', 'A'],
      ['IGEM12 ', 'B'],
      ['IGEM13 ', 'A'],
      ['IGEM13 ', 'B'],
      ['IGEM14 ', 'A'],
      ['IGEM14 ', 'B'],
      ['IGEM15 ', 'A'],
      ['IGEM15 ', 'B'],
      ['IGEM16 ', 'A'],
      ['IGEM16 ', 'B'],
      ['IGEM31 ', 'A'],
      ['IGEM32 ', 'A'],
      ['IGEM33 ', 'A'],
      ['IGEM34 ', 'A'],
      ['IGEM35 ', 'A'],
      ['IGEM36 ', 'A'],
      ['IGEM51 ', 'A'],
      ['IGEM52 ', 'A'],
      ['IGEM53 ', 'A'],
      ['IGEM54 ', 'A'],
      ['IGEM55 ', 'A'],
      ['IGEM56 ', 'A'],
      ['IGEM71 ', 'A'],
      ['IGEM72 ', 'A'],
      ['IGEM73 ', 'A'],
      ['IGEM74 ', 'A'],
      ['IGEM75 ', 'A'],
      ['IGEM76 ', 'A'],
      ['IGEM77 ', 'A'],
      ['IIA11  ', 'A'],
      ['IIA11  ', 'B'],
      ['IIA12  ', 'A'],
      ['IIA12  ', 'B'],
      ['IIA13  ', 'A'],
      ['IIA13  ', 'B'],
      ['IIA14  ', 'A'],
      ['IIA14  ', 'B'],
      ['IIA15  ', 'A'],
      ['IIA15  ', 'B'],
      ['IIA16  ', 'A'],
      ['IIA16  ', 'B'],
      ['IIA23  ', 'R'],
      ['IIA31  ', 'A'],
      ['IIA31  ', 'B'],
      ['IIA32  ', 'A'],
      ['IIA32  ', 'B'],
      ['IIA33  ', 'A'],
      ['IIA33  ', 'B'],
      ['IIA35  ', 'A'],
      ['IIA35  ', 'B'],
      ['IIA42  ', 'A'],
      ['IIA42  ', 'B'],
      ['IIA45  ', 'A'],
      ['IIA45  ', 'B'],
      ['IIA51  ', 'A'],
      ['IIA51  ', 'B'],
      ['IIA52  ', 'A'],
      ['IIA52  ', 'B'],
      ['IIA54  ', 'A'],
      ['IIA54  ', 'B'],
      ['IIA55  ', 'A'],
      ['IIA55  ', 'B'],
      ['IIA56  ', 'A'],
      ['IIA56  ', 'B'],
      ['IIA66  ', 'A'],
      ['IIA66  ', 'B'],
      ['IIA71  ', 'A'],
      ['IIA71  ', 'B'],
      ['IIA72  ', 'A'],
      ['IIA72  ', 'B'],
      ['IIA73  ', 'A'],
      ['IIA73  ', 'B'],
      ['IIA74  ', 'A'],
      ['IIA74  ', 'B'],
      ['IIA75  ', 'A'],
      ['IIA75  ', 'B'],
      ['IIA76CC', 'A'],
      ['IIA76CC', 'B'],
      ['IIA77CC', 'A'],
      ['IIA77CC', 'B'],
      ['IIM11  ', 'A'],
      ['IIM11  ', 'B'],
      ['IIM12  ', 'A'],
      ['IIM12  ', 'B'],
      ['IIM13  ', 'A'],
      ['IIM13  ', 'B'],
      ['IIM14  ', 'A'],
      ['IIM14  ', 'B'],
      ['IIM15  ', 'A'],
      ['IIM15  ', 'B'],
      ['IIM16  ', 'A'],
      ['IIM16  ', 'B'],
      ['IIM31  ', 'A'],
      ['IIM32  ', 'A'],
      ['IIM33  ', 'A'],
      ['IIM34  ', 'A'],
      ['IIM35  ', 'A'],
      ['IIM36  ', 'A'],
      ['IIN11  ', 'A'],
      ['IIN11  ', 'B'],
      ['IIN11  ', 'C'],
      ['IIN12  ', 'A'],
      ['IIN12  ', 'B'],
      ['IIN12  ', 'C'],
      ['IIN13  ', 'A'],
      ['IIN13  ', 'B'],
      ['IIN13  ', 'C'],
      ['IIN14  ', 'A'],
      ['IIN14  ', 'B'],
      ['IIN14  ', 'C'],
      ['IIN15  ', 'A'],
      ['IIN15  ', 'B'],
      ['IIN15  ', 'C'],
      ['IIN16  ', 'A'],
      ['IIN16  ', 'B'],
      ['IIN16  ', 'C'],
      ['IIN31  ', 'A'],
      ['IIN31  ', 'B'],
      ['IIN31  ', 'C'],
      ['IIN32  ', 'A'],
      ['IIN32  ', 'B'],
      ['IIN32  ', 'C'],
      ['IIN33  ', 'A'],
      ['IIN33  ', 'B'],
      ['IIN34  ', 'A'],
      ['IIN34  ', 'B'],
      ['IIN34  ', 'C'],
      ['IIN35  ', 'A'],
      ['IIN35  ', 'B'],
      ['IIN35  ', 'C'],
      ['IIN36  ', 'A'],
      ['IIN36  ', 'B'],
      ['IIN36  ', 'C'],
      ['IIN46  ', 'R'],
      ['IIN51  ', 'A'],
      ['IIN51  ', 'B'],
      ['IIN51  ', 'C'],
      ['IIN52  ', 'A'],
      ['IIN52  ', 'B'],
      ['IIN52  ', 'C'],
      ['IIN53  ', 'A'],
      ['IIN53  ', 'B'],
      ['IIN53  ', 'C'],
      ['IIN54  ', 'A'],
      ['IIN54  ', 'B'],
      ['IIN54  ', 'C'],
      ['IIN55  ', 'A'],
      ['IIN55  ', 'B'],
      ['IIN55  ', 'C'],
      ['IIN56  ', 'A'],
      ['IIN56  ', 'B'],
      ['IIN56  ', 'C'],
      ['IIN57  ', 'A'],
      ['IIN57  ', 'B'],
      ['IIN57  ', 'C'],
      ['IIN71  ', 'A'],
      ['IIN71  ', 'B'],
      ['IIN71  ', 'C'],
      ['IIN73  ', 'A'],
      ['IIN73  ', 'B'],
      ['IIN73  ', 'C'],
      ['IIN74  ', 'A'],
      ['IIN74  ', 'B'],
      ['IIN74  ', 'C'],
      ['IIN75  ', 'A'],
      ['IIN75  ', 'B'],
      ['IIN75  ', 'C'],
      ['IIN76  ', 'A'],
      ['IIN76  ', 'B'],
      ['IIN76  ', 'C'],
      ['IIN77SP', 'A'],
      ['IIN77SP', 'B'],
      ['IIN77SP', 'C'],
      ['IIN79SP', 'A'],
      ['IIN79SP', 'B'],
      ['IIN79SP', 'C'],
      ['ISI11  ', 'A '],
      ['ISI11  ', 'B '],
      ['ISI11  ', 'C '],
      ['ISI12  ', 'A '],
      ['ISI12  ', 'B '],
      ['ISI12  ', 'C '],
      ['ISI12  ', 'R '],
      ['ISI13  ', 'A '],
      ['ISI13  ', 'B '],
      ['ISI13  ', 'C '],
      ['ISI14  ', 'A '],
      ['ISI14  ', 'B '],
      ['ISI14  ', 'C '],
      ['ISI15  ', 'A '],
      ['ISI15  ', 'B '],
      ['ISI15  ', 'C '],
      ['ISI16  ', 'A '],
      ['ISI16  ', 'B '],
      ['ISI16  ', 'C '],
      ['ISI21  ', 'R '],
      ['ISI22  ', 'R '],
      ['ISI31  ', 'A '],
      ['ISI31  ', 'BC'],
      ['ISI32  ', 'A '],
      ['ISI32  ', 'B '],
      ['ISI32  ', 'C '],
      ['ISI33  ', 'A '],
      ['ISI33  ', 'B '],
      ['ISI33  ', 'C '],
      ['ISI34  ', 'A '],
      ['ISI34  ', 'B '],
      ['ISI34  ', 'C '],
      ['ISI35  ', 'A '],
      ['ISI35  ', 'B '],
      ['ISI35  ', 'C '],
      ['ISI36  ', 'A '],
      ['ISI36  ', 'B '],
      ['ISI36  ', 'C '],
      ['ISI41  ', 'R '],
      ['ISI43  ', 'A '],
      ['ISI43  ', 'B '],
      ['ISI43  ', 'C '],
      ['ISI52  ', 'A '],
      ['ISI52  ', 'B '],
      ['ISI52  ', 'C '],
      ['ISI54  ', 'A '],
      ['ISI54  ', 'B '],
      ['ISI54  ', 'C '],
      ['ISI56  ', 'A '],
      ['ISI56  ', 'B '],
      ['ISI56  ', 'C '],
      ['ISI61  ', 'A '],
      ['ISI61  ', 'B '],
      ['ISI61  ', 'C '],
      ['ISI63  ', 'A '],
      ['ISI63  ', 'B '],
      ['ISI63  ', 'C '],
      ['ISI72  ', 'A '],
      ['ISI72  ', 'B '],
      ['ISI72  ', 'C '],
      ['ISI74  ', 'A '],
      ['ISI74  ', 'B '],
      ['ISI74  ', 'C '],
      ['ISI74TM', 'A '],
      ['ISI74TM', 'B '],
      ['ISI74TM', 'C '],
      ['ISI75  ', 'A '],
      ['ISI75  ', 'B '],
      ['ISI75  ', 'C '],
      ['ISI78TM', 'A '],
      ['ISI78TM', 'B '],
      ['ISI78TM', 'C '],
      ['ISI81  ', 'A '],
      ['ISI81  ', 'B '],
      ['ISI81  ', 'C '],
      ['ISI83  ', 'A '],
      ['ISI83  ', 'B '],
      ['ISI83  ', 'C '],
      ['ISI84  ', 'A '],
      ['ISI84  ', 'B '],
      ['ISI84  ', 'C '],
    ];

    foreach ($groups as $g) {
      $materia = trim($g[0]);
      $clave = trim($g[1]);
      
      # Materia del grupo a crear
      dump($materia);
      $subject = Subject::where('key', $materia)->firstorFail();
      $data = [
        'name' => $clave,
        'is_available' => true,
        'subject_id' => $subject->id,
        'semester_id' => $semester->id
      ];

      $group = Group::firstOrNew($data);
      $group->save();
      
      /*where('subject_id', $subject->id)->where('semester_id', $semester->id)
      ->firstOr(function ($data, $subject) {
        if ($group = Group::create($data)) {
          #$subject = Subject::where('key', trim($g->materia))->first();
          $group->subject()->associate(isset($subject->id) ? $subject : null);
          $group->semester()->associate($semester);
          $group->save();
        }
      });*/
    }
    return redirect()->route('groups.index');
  }
}
