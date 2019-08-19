@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Nuevo usuario
          </h2>
        </header>
        <form action="{{ route('users.new') }}" class="ui equal width form @hasError" method="POST">
          @csrf
          <div class="fields">
            <div class="field">
              <label>Nombre</label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" autofocus autocomplete="off" />
            </div>
            <div class="field">
              <label for="last_name">Apellidos</label>
              <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                autocomplete="family-name" />
            </div>
          </div>
          <div class="fields">
            <div class="field">
              <label for="password">Contraseña</label>
              <input type="password" id="password" name="password" autocomplete="new-password">
            </div>
            <div class="field">
              <label for="password_confirmation">Confirmación contraseña</label>
              <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="off">
            </div>
          </div>
          <div class="fields">
            <div class="field">
              <label for="username">Usuario</label>
              <input type="text" id="username" name="username" value="{{ old('username') }}" />
            </div>
            <div class="field">
              <label for="email">Correo electrónico</label>
              <input type="text" id="email" name="email" value="{{ old('email') }}" autocomplete="email" />
            </div>
          </div>

          @include('components.back', ['route' => route('users.index')])
          <button type="submit" class="ui positive labeled icon submit button">
            <i class="save icon"></i>
            Guardar
          </button>

          @include('components.errors-message')

        </form>
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/new-user.form.js')
@endpush
