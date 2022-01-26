<?php

namespace App\Http\Controllers;

use Auth;
use App\Career;
use App\Semester;
use App\Careers;
use App\User;
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
    # Borrado masivo de usuarios sin carrera (borra Admin y JEFE_DEP)
    /*$users = User::where('career_id', null)->orderBy('username', 'asc')->get();
    foreach ($users as $key => $user) {
      if(count($user->moves) == 0){
        //$users->forget($key);
        $user->delete();
      }
    }*/

    /*$admin = new User();
    $admin->name = "Administrador";
    $admin->username = "admin";
    $admin->email = "jesus.delgado@tecvalles.mx";
    $admin->password = 'secret';
    $admin->remember_token = str_random(10);
    $admin->save();
    $admin->assignRole('Admin');

    $jefe = new User();
    $jefe->name = 'Jefe DEP';
    $jefe->username = 'jefedep';
    $jefe->email = 'dep@tecvalles.mx';
    $jefe->password = 'secret';
    $jefe->remember_token = str_random(10);
    $jefe->save();
    $jefe->assignRole('Jefe');*/
  }
}
