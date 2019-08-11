@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Nuevo semestre
          </h2>
        </header>
        <form action="{{ route('semesters.save') }}" class="ui equal width form @hasError" method="POST">
          @csrf
          <input type="hidden" id="is_active" name="is_active" value="1">
          <div class="ui two fields">
            <div class="field">
              <label for="key">Clave</label>
              <input type="text" id="key" name="key" value="{{ old('key') }}" autofocus placeholder="20193">
            </div>
            <div class="field">
              <label for="short_name">Nombre corto</label>
              <input type="text" id="short_name" name="short_name" value="{{ old('short_name') }}"
                placeholder="Ago - Dic 2019">
            </div>
          </div>
          <div class="field">
            <label for="long_name">Nombre completo</label>
            <input type="text" id="long_name" name="long_name" value="{{ old('long_name') }}"
              placeholder="Agosto - Diciembre 2019">
          </div>
          <h4 class="ui dividing header">Período de Altas</h4>
          <div class="ui two fields">
            <div class="field">
              <label>Inicio</label>
              <div class="ui calendar" id="begin_up">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text" name="begin_up" value="{{ old('begin_up') }}" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="field">
              <label>Fin</label>
              <div class="ui calendar" id="end_up">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text" name="end_up" value="{{ old('end_up') }}" autocomplete="off">
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
                  <input type="text" name="begin_down" value="{{ old('begin_down') }}" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="field">
              <label>Fin</label>
              <div class="ui calendar" id="end_down">
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="text" name="end_down" value="{{ old('end_down') }}" autocomplete="off">
                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="ui fluid primary labeled icon submit button">
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
