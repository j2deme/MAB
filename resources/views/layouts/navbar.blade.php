<div class="ui fixed menu">
  <div class="ui container">
    <a href="{{ route('root') }}" class="header item">
      <i class="icons">
        <i class="blue sort up icon"></i>
        <i class="red sort down icon"></i>
      </i>
      MAB
    </a>
    <div class="right menu">
      @auth
      <a href="{{ route('root') }}" class="item">
        <i class="home icon"></i>
      </a>
      <div class="ui simple dropdown item">
        {{ Auth::user()->name }} <i class="dropdown icon"></i>
        <div class="menu">
          <a class="item" href="#">Link Item</a>
          <a class="item" href="#">Link Item</a>
          <div class="divider"></div>
          <div class="header">Header Item</div>
          <div class="item">
            <i class="dropdown icon"></i>
            Sub Menu
            <div class="menu">
              <a class="item" href="#">Link Item</a>
              <a class="item" href="#">Link Item</a>
            </div>
          </div>
          <a class="item" href="#">Link Item</a>
          <a href="{{ route('auth.logout') }}" class="item"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
        </div>
      </div>
      @orguest
      <a href="{{ route('auth.login') }}" class="item">Inicio de sesión</a>
      <a href="{{ route('auth.register') }}" class="item">Registro</a>
      @end
    </div>
  </div>
</div>
