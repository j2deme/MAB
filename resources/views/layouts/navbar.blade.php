<div class="ui fixed menu">
  <div class="ui container">
    <a href="{{ url('/') }}" class="header item">
      <i class="icons">
        <i class="blue sort up icon"></i>
        <i class="red sort down icon"></i>
      </i>
      MAB
    </a>
    <div class="right menu">
      @auth
      <a href="{{ url('/') }}" class="item">
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
          <a href="{{ url('/logout') }}" class="item"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
        </div>
      </div>
      @guest
      <a href="{{ url('/login') }}" class="item">Inicio de sesión</a>
      <a href="{{ url('/register') }}" class="item">Registro</a>
      @endauth
    </div>
  </div>
</div>
