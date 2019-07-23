@extends('layouts.app')

@section('content')
<div class="ui middle aligned center aligned grid">
  <div class="row">
    <div class="column">
      <h1 id="landing-page-header" class="ui icon header">
        <i class="large icons">
          <i class="blue sort up icon"></i>
          <i class="red sort down icon"></i>
        </i>
        <div class="content">
          MAB
          <div class="sub header">Módulo de Altas y Bajas</div>
        </div>
      </h1>
    </div>
  </div>
  <div class="row">
    <div class="column">
      <a href="{{ url('/login') }}" class="ui primary labeled icon button">
        <i class="sign in icon"></i>
        Ingresar
      </a>
      <a href="{{ url('/register') }}" class="ui secondary labeled icon button">
        <i class="id card icon"></i>
        Registro
      </a>
    </div>
  </div>
  @auth
  Sesión iniciada
  @guest
  Sesión <span class="ui red text">NO</span> iniciada
  @endauth
</div>
@endsection
