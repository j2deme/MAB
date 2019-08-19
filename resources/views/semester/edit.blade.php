@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Editar semestre {{ $semester->short_name }}
          </h2>
        </header>
        <form action="{{ route('semesters.update', $semester) }}" class="ui equal width form @hasError" method="POST">
          @csrf
          @method('PUT')
          <div class="ui two fields">
            <div class="field">
              <label for="key">Clave</label>
              <input type="text" id="key" name="key" value="{{ $semester->key }}" autofocus
                placeholder="{{ $semester->key }}">
            </div>
            <div class="field">
              <label for="short_name">Nombre corto</label>
              <input type="text" id="short_name" name="short_name" value="{{ $semester->short_name }}"
                placeholder="{{ $semester->short_name }}">
            </div>
          </div>
          <div class="field">
            <label for="long_name">Nombre completo</label>
            <input type="text" id="long_name" name="long_name" value="{{ $semester->long_name }}"
              placeholder="{{ $semester->long_name }}">
          </div>
          <h4 class="ui dividing header">Período de Altas</h4>
          <div class="ui two fields">
            <div class="field">
              <label>Inicio</label>
              <div class="ui calendar" id="begin_up">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text" name="begin_up" value="{{ $semester->begin_up }}" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="field">
              <label>Fin</label>
              <div class="ui calendar" id="end_up">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text" name="end_up" value="{{ $semester->end_up }}" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <h4 class="ui dividing header">Período de Bajas</h4>
          <div class="ui two fields">
            <div class="field">
              <label>Inicio</label>
              <div class="ui calendar" id="begin_down">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text" name="begin_down" value="{{ $semester->begin_down }}" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="field">
              <label>Fin</label>
              <div class="ui calendar" id="end_down">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text" name="end_down" value="{{ $semester->end_down }}" autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          @include('components.back', ['route' => route('semesters.index')])
          <button type="submit" class="ui green labeled icon submit button">
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
@js('custom/new-semester.form.js')
@endpush
