<?php

namespace App\Http\Controllers;

use App\Career;
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
    $careers = Career::pluck('name', 'id');
    return view('home', compact('careers'));
  }
}
