@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui main text container">
  <div class="ui middle aligned centered grid">
    <div class="twelve wide mobile ten wide computer column">
      <h2 class="ui primary center aligned header">
        <div class="content">
          Registro
        </div>
      </h2>
      <form class="ui equal width form" method="POST" action="{{ url('/register') }}">
        @csrf
        <div class="ui segment">
          <div class="fields">
            <div class="field">
              <label>Nombre</label>
              <input type="text" id="name" name="name" autofocus />
            </div>
            <div class="field">
              <label for="last_name">Apellidos</label>
              <input type="text" id="last_name" name="last_name" />
            </div>
          </div>
          <div class="fields">
            <div class="field">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password">
            </div>
            <div class="field">
              <label for="password_confirm">Confirmación contraseña</label>
              <input type="password" id="password_confirm" name="password_confirm">
            </div>
          </div>
          <div class="fields">
            <div class="field">
              <label for="username">Número de control</label>
              <input type="text" id="username" name="username" />
            </div>
            <div class="field">
              <label for="email">Correo electrónico</label>
              <input type="text" id="email" name="email" />
            </div>
          </div>
          <div class="ui fluid primary labeled icon submit button">
            <i class="save icon"></i>
            Registrar
          </div>
        </div>

        <div class="ui error message">
          {{ $errors->first() }}
        </div>

      </form>

      <div class="ui message">
        <div class="ui center aligned grid">
          ¿Ya tienes cuenta? <a href="{{ url('/login') }}">Inicia sesión</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/custom/register.form.js') }}"></script>
@endpush
