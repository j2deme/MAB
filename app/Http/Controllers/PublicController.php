<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Career;
use App\Semester;
use App\Careers;
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

  public function test()
  {
    $semester = Semester::last();

    $groups  = DB::connection('sybase')->select("SELECT materia, grupo AS clave FROM grupos WHERE periodo = :periodo AND materia NOT LIKE '%MOD_'", ['periodo' => $semester->key]);

    dd($groups);

    foreach ($subjects as $s) {
      $data = [
        'key' => $s->materia,
        'short_name' => $s->nombre_corto,
        'long_name' => $s->nombre,
        'semester' => $s->semestre,
        'ht' => $s->ht,
        'hp' => $s->hp,
        'cr' => $s->cr,
        'is_active' => true
      ];
      if ($subject = Subject::create($data)) {
        $career = Career::where('internal_key', $s->carrera)->first();
        $subject->career()->associate(isset($career->id) ? $career : null);
        $subject->save();
      }
    }
  }
}
