@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Nueva materia
          </h2>
        </header>
        <form action="{{ route('subjects.save') }}" class="ui equal width form @hasError" method="POST">
          @csrf
          <input type="hidden" id="is_active" name="is_active" value="1">
          <div class="ui two fields">
            <div class="field">
              <label for="key">Clave</label>
              <input type="text" id="key" name="key" value="{{ old('key') }}" autofocus placeholder="ISI91">
            </div>
            <div class="field">
              <label for="short_name">Nombre corto</label>
              <input type="text" id="short_name" name="short_name" value="{{ old('short_name') }}"
                placeholder="Intelig. Art.">
            </div>
          </div>
          <div class="field">
            <label for="long_name">Nombre completo</label>
            <input type="text" id="long_name" name="long_name" value="{{ old('long_name') }}"
              placeholder="Inteligencia Artificial">
          </div>
          <div class="two fields">
            <div class="field">
              <label for="semester">Semestre</label>
              <select name="semester" id="semester" class="ui dropdown">
                <option value="">Elige un semestre</option>
                @for ($i = 1; $i <= 9; $i++) <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
              </select>
            </div>
            <div class="field">
              <label for="career_id">Carrera</label>
              <select name="career_id" id="career_id" class="ui dropdown">
                <option value="">Elige una carrera</option>
                @foreach ($careers as $key => $item)
                <option value="{{ $key }}">{{ $item }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="three fields">
            <div class="field">
              <label for="ht">Horas teóricas</label>
              <input type="number" id="ht" name="ht" placeholder="2" min="0" max="6" autocomplete="off">
            </div>
            <div class="field">
              <label for="hp">Horas prácticas</label>
              <input type="number" id="hp" name="hp" placeholder="2" min="0" max="6" autocomplete="off">
            </div>
            <div class="field">
              <label for="">Créditos</label>
              <input type="number" id="cr" name="cr" placeholder="4" min="0" max="6" autocomplete="off">
            </div>
          </div>

          @include('components.back', ['route' => route('subjects.index')])
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
@js('custom/new-subject.form.js')
@endpush
