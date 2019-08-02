<?php

namespace App\Http\Controllers;

use App\Career;
use Auth;
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
    }
    if (Auth::user()->hasRole('Estudiante')) {
      $data['ups'] = Auth::user()->ups;
      $data['downs'] = Auth::user()->downs;
      $data['attended'] = Auth::user()->attended;
    } elseif (Auth::user()->hasRole('Coordinador')) {
      $data['ups'] = 0;
      $data['downs'] = 0;
      $data['attended'] = 0;
    } else {
      $data['ups'] = 0;
      $data['downs'] = 0;
      $data['attended'] = 0;
    }
    return view('home', $data);
  }
}
