<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

  use AuthenticatesAndRegistersUsers, ThrottlesLogins;

  /**
   * Where to redirect users after login / registration.
   *
   * @var string
   */
  protected $redirectTo = '/home';

  /**
   * Which column will be used for username check
   */

  protected $username = 'username';

  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name'      => 'required|max:255',
      'last_name' => 'required|max:255',
      'username'  => 'required|max:255|unique:users',
      'email'     => 'required|email|max:255|unique:users',
      'password'  => 'required|min:6|confirmed',
    ], [
      'name.required'      => 'Ingresa tu nombre o nombres',
      'last_name.required' => 'Ingresa tus apellidos',
      'username.required'  => 'Se requiere usuario / no. de control',
      'username.unique'    => 'El número de control ya fue registrado',
      'password.required'  => 'Ingresa tu contraseña',
      'password.confirmed' => 'Las contraseñas no coinciden',
      'email.required'     => 'Ingresa tu correo electrónico',
      'email.email'        => 'Ingresa un correo electrónico válido',
      'email.unique'       => 'El correo electrónico ya se encuentra asociado a otra cuenta'
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return User
   */
  protected function create(array $data)
  {
    $user = User::create([
      'name'      => $data['name'],
      'last_name' => $data['last_name'],
      'username'  => $data['username'],
      'email'     => $data['email'],
      'password'  => $data['password'],
    ]);
    $user->assignRole('Estudiante');

    return $user;
  }
}
