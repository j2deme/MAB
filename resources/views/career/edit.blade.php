@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Actualizar carrera
          </h2>
        </header>
        <form action="{{ route('careers.update', $career) }}" class="ui equal width form @hasError" method="POST">
          @csrf
          @method('PUT')
          <div class="ui two fields">
            <div class="field">
              <label for="acronym">Siglas</label>
              <input type="text" id="acronym" name="acronym" value="{{ $career->acronym }}" autofocus>
            </div>
            <div class="field">
              <label for="internal_key">Clave Sistema</label>
              <input type="number" id="internal_key" name="internal_key" value="{{ $career->internal_key }}">
              <div class="ui pointing label">
                Clave numérica en la plataforma Mindbox
              </div>
            </div>
          </div>
          <div class="field">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ $career->name }}" placeholder="Ingeniería en...">
          </div>

          @include('components.back', ['route' => route('careers.index')])
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

@endpush