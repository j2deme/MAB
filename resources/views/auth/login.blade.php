@extends('layouts.app')

@section('content')
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

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
      <label for="password" class="col-md-4 control-label">Password</label>

      <div class="col-md-6">
        <input id="password" type="password" class="form-control" name="password">

        @if ($errors->has('password'))
        <span class="help-block">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input type="password" name="password" placeholder="Contraseña" autocomplete="current-password">
            </div>

    <div class="form-group">
      <div class="col-md-6 col-md-offset-4">
        <div class="checkbox">
          <label>
            <input type="checkbox" name="remember"> Remember Me
          </label>
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
  </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  $(document).ready(function() {
    $('.ui.form').form({
      fields: {
        email: {
          identifier  : 'email',
          rules: [
            {
              type   : 'empty',
              prompt : 'Ingresa tu correo electrónico'
            },
            {
              type   : 'email',
              prompt : 'Ingresa un correo electrónico válido'
            }
          ]
        },
        password: {
          identifier  : 'password',
          rules: [
            {
              type   : 'empty',
              prompt : 'Ingresa tu contraseña'
            }
          ]
        }
      }
    });
  });
</script>
@endsection
