<div class="ui fixed menu">
  <div class="ui container">
    <a href="@auth {{route('home.index')}} @orguest {{route('root')}} @end" class="header item">
      <i class="icons">
        <i class="blue sort up icon"></i>
        <i class="red sort down icon"></i>
      </i>
      MAB
    </a>
    @auth
    @can('view_users')
    <a href="{{ route('users.index') }}" class="{{ Request::is('users*') ? 'active ' : ' ' }}item">
      <i class="users icon"></i> Usuarios
    </a>
    @endcan
    @end
    <div class="right menu">
      @auth
      <a href="{{ route('home.index') }}" class="item">
        <i class="home icon"></i>
      </a>
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
  </div>
</div>
