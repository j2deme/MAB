<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Permission;
use App\Http\Requests;
use App\Traits\Authorizable;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  use Authorizable;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $roles = Role::all();
    $permissions = Permission::all();
    $user = Auth::user();

    return response()->view('role.index', compact('roles', 'permissions', 'user'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, ['name' => 'required|unique:roles']);

    if (Role::create($request->only('name'))) {
      flash('Rol añadido');
    }

    return redirect()->back();
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
    if ($role = Role::findOrFail($id)) {
      // admin role has everything
      if ($role->name === 'Admin') {
        $role->syncPermissions(Permission::all());
        return redirect()->route('roles.index');
      }

      $permissions = $request->get('permissions', []);
      $role->syncPermissions($permissions);
      flash('Los permisos para ' . $role->name . ' han sido  actualizados.');
    } else {
      flash()->error('Rol con id ' . $id . ' no encontrado.');
    }

    return redirect()->route('roles.index');
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
}
