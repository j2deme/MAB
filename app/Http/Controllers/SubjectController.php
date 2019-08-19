<?php

namespace App\Http\Controllers;

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
