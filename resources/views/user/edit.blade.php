@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Editar usuario {{ $user->username }}
          </h2>
        </header>
        <form action="{{ route('users.update', $user) }}" class="ui equal width form @hasError" method="POST">
          @csrf
          @method('PUT')
          <div class="fields">
            <div class="field">
              <label>Nombre</label>
              <input type="text" id="name" name="name" value="{{ $user->name }}" autofocus autocomplete="off" />
            </div>
            <div class="field">
              <label for="last_name">Apellidos</label>
              <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}"
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
              <input type="text" id="username" name="username" value="{{ $user->username }}" />
            </div>
            <div class="field">
              <label for="email">Correo electrónico</label>
              <input type="text" id="email" name="email" value="{{ $user->email }}" autocomplete="email" />
            </div>
          </div>
          <div class="two fields">
            <div class="field">
              <label for="roles">Rol</label>
              <select name="roles" id="roles" class="ui search selection dropdown">
                <option value="">Elige un rol</option>
                @foreach ($roles as $key => $item)
                <option value="{{ $key }}"
                  {{ (!is_null($user->roles->first()) and $user->roles->first()->id == $key) ? 'selected' : null }}>
                  {{ $item }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="field">
              <label for="career_id">Carrera</label>
              <select name="career_id" id="career_id" class="ui search selection dropdown">
                <option value="">Elige una carrera</option>
                @foreach ($careers as $key => $item)
                <option value="{{ $key }}"
                  {{ (!is_null($user->career) and $user->career->id == $key) ? 'selected' : null }}>{{ $item }}
                </option>
                @endforeach
              </select>
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
