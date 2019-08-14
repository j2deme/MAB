<div class="ui grid">
  <div class="ui computer only row">
    <div class="ui top fixed menu">
      <div class="ui container">
        <a href="@auth {{route('home.index')}} @orguest {{route('root')}} @end" class="header item">
          <i class="icons">
            <i class="blue sort up icon"></i>
            <i class="red sort down icon"></i>
          </i>
          MAB
        </a>
        @include('layouts.menu')
      </div>
    </div>
  </div>
  <div class="ui tablet mobile only row">
    <div class="ui container">
      <div class="ui secondary left floated menu">
        <a href="@auth {{route('home.index')}} @orguest {{route('root')}} @end" class="header item">
          <i class="icons">
            <i class="blue sort up icon"></i>
            <i class="red sort down icon"></i>
          </i>
          MAB
        </a>
      </div>
      <div class="ui secondary right floated menu">
        <a class="item" id="sidebarMenu">
          <i class="sidebar icon"></i> Menu
        </a>
      </div>
    </div>
  </div>
</div>
