<div class="ui fixed inverted menu">
  <div class="ui container">
    <a href="{{ url('/') }}" class="header item">
      <i class="logo icons">
        <i class="blue sort up icon"></i>
        <i class="red sort down icon"></i>
      </i>
      MAB
    </a>
    @auth
    <a href="{{ url('/') }}" class="item">
      <i class="home icon"></i>
    </a>
    <div class="ui simple dropdown item">
      Dropdown <i class="dropdown icon"></i>
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
      </div>
    </div>
    @endauth
  </div>
</div>
