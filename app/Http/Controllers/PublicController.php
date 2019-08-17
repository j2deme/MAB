<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;

class PublicController extends Controller
{
  public function index()
  {
    if (!is_null(Auth::user())) {
      return redirect()->route('home.index');
    }
    return view('index');
  }
}
