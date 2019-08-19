<?php

namespace App\Http\Controllers;

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
    $result = Group::orderBy('semester_id', 'asc')->orderBy('subject_id', 'asc')->orderBy('name', 'asc')->paginate();
    return view('group.index', compact('result'));
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
