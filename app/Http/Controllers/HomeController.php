<?php

namespace App\Http\Controllers;

use Auth;
use App\Career;
use App\Semester;
use App\Move;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (is_null(Auth::user()->career)) {
      $data['careers'] = Career::pluck('name', 'id');
      $data['ups'] = $data['downs'] = $data['attended'] = 0;
    } else {
      // Estadísticas de solicitudes por rol
      if (Auth::user()->hasRole('Estudiante')) {
        $data['ups'] = Auth::user()->ups;
        $data['downs'] = Auth::user()->downs;
        $data['attended'] = Auth::user()->attended;
      } else {
        $last_semester = Semester::last();
        if (!is_null($last_semester)) {
          if (!is_null(Auth::user()->career)) {
            $career_id = Auth::user()->career->id;
            $data['ups'] = Career::find($career_id)->moves()->where('semester_id', $last_semester->id)->where('type', 'ALTA')->count();
            $data['downs'] = Career::find($career_id)->moves()->where('semester_id', $last_semester->id)->where('type', 'BAJA')->count();
            $data['attended'] = Career::find($career_id)->moves()->where('semester_id', $last_semester->id)->whereIn('status', ['2', '3', '4', '5'])->count();
          } else {
            $data['ups'] = Move::where('semester_id', $last_semester->id)->where('type', 'ALTA')->count();
            $data['downs'] = Move::where('semester_id', $last_semester->id)->where('type', 'BAJA')->count();
            $data['attended'] = Move::where('semester_id', $last_semester->id)->whereIn('status', ['2', '3', '4', '5'])->count();
          }
        } else {
          $data['ups'] = $data['downs'] = $data['attended'] = 0;
        }
      }
    }
    return view('home', $data);
  }
}
