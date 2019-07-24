@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui main text container">
  <div class="ui middle aligned centered grid">
    <div class="twelve wide mobile eight wide computer column">
      <h2 class="ui primary center aligned header">
        <div class="content">
          Inicio de sesión
        </div>
      </h2>
      <form class="ui form" method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="ui segment">
          <div class="field">
            <div class="ui left icon input">
              <i class="at icon"></i>
              <input type="text" name="email" placeholder="Correo electrónico" autocomplete="email" autofocus>
            </div>
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input type="password" name="password" placeholder="Contraseña" autocomplete="current-password">
            </div>
          </div>
          <div class="inline field">
            <div class="ui checkbox">
              <input type="checkbox" id="remember" name="remember">
              <label>Recuérdame</label>
            </div>
          </div>
          <div class="ui fluid primary labeled icon submit button">
            <i class="sign in icon"></i>
            Entrar
          </div>
        </div>

        <div class="ui error message">
          {{ $errors->first() }}
        </div>

      </form>

      <div class="ui message">
        <div class="ui center aligned grid">
          ¿No tienes cuenta? <a href="{{ url('/register') }}">Regístrate</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/custom/login.form.js') }}"></script>
@endpush
