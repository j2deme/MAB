<div class="widescreen large screen computer tablet only row">
  <div class="ui top fixed menu navbar">
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
<div class="mobile only narrow row">
  <div class="ui top menu navbar">
    <a href="@auth {{route('home.index')}} @orguest {{route('root')}} @end" class="header item">
      <i class="icons">
        <i class="blue sort up icon"></i>
        <i class="red sort down icon"></i>
      </i>
      MAB
    </a>
    <div class="right menu open">
      <a href="#" class="menu item">
        <i class="ui bars icon"></i>
      </a>
    </div>
  </div>
  <div class="ui vertical navbar menu">
    @include('layouts.menu')
  </div>
</div>
