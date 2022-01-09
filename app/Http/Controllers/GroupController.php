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
    
    $synced = 0;
    foreach ($groups as $g) {
      $subject = Subject::where('key', trim($g->materia))->first();

      if(is_object($subject)){
        $data = [
          'name' => $g->clave,
          'is_available' => true,
          'subject_id' => $subject->id,
          'semester_id' => $semester->id
        ];
  
        $groupExists = Group::where('subject_id', $subject->materia)->where('semester_id', $semester->id)->first();
        if (!$groupExists) {
          $group = Group::create($data);
          $group->save();
          $synced++;
        }
      }
    }
    flash("{$synced}/" . count($groups) . " grupos creados");
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
}
