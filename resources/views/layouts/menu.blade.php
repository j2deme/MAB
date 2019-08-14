@auth
<a href="{{ route('moves.index') }}" class="{{ Request::is('moves*') ? 'blue active ' : ' ' }}item">
  <i class="stream icon"></i> Solicitudes
</a>
@hasanyrole(['Jefe','Admin'])
<a href="{{ route('semesters.index') }}" class="{{ Request::is('semesters*') ? 'blue active ' : ' ' }}item">
  <i class="ui calendar alternate outline icon"></i> Semestres
</a>
<a href="{{ route('careers.index') }}" class="{{ Request::is('careers*') ? 'blue active ' : ' ' }}item">
  <i class="ui university icon"></i> Carreras
</a>
<a href="{{ route('subjects.index') }}" class="{{ Request::is('subjects*') ? 'blue active ' : ' ' }}item">
  <i class="ui project diagram icon"></i> Materias
</a>
<a href="{{ route('groups.index') }}" class="{{ Request::is('groups*') ? 'blue active ' : ' ' }}item">
  <i class="ui shapes icon"></i> Grupos
</a>
<a href="{{ route('users.index') }}" class="{{ Request::is('users*') ? 'blue active ' : ' ' }}item">
  <i class="users icon"></i> Usuarios
</a>
@endhasanyrole
@role('Admin')
<a href="{{ route('roles.index') }}" class="{{ Request::is('roles*') ? 'blue active ' : ' ' }}item">
  <i class="ui user tag icon"></i> Roles
</a>
@endrole
@end
<div class="right menu">
  @auth
  {{-- <a href="{{ route('home.index') }}" class="item">
  <i class="home icon"></i>
  </a> --}}
  <div class="ui simple dropdown item">
    {{ Auth::user()->username }} <i class="dropdown icon"></i>
    <div class="menu">
      <a class="item" href="#">
        <i class="user cog icon"></i> Cuenta
      </a>
      <div class="divider"></div>
      <a href="{{ route('auth.logout') }}" class="item">
        <i class="sign out icon"></i> Salir
      </a>
    </div>
  </div>
  @orguest
  <a href="{{ route('auth.login') }}" class="item">Inicio de sesión</a>
  <a href="{{ route('auth.register') }}" class="item">Registro</a>
  @end
</div>
