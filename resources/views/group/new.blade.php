@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Nuevo grupo
          </h2>
        </header>
        <form action="{{ route('groups.save') }}" class="ui equal width form @hasError" method="POST">
          @csrf
          <input type="hidden" id="is_available" name="is_available" value="1">
          <div class="field">
            <label for="semester_id">Período</label>
            <select name="semester_id" id="semester_id" class="ui search selection dropdown"
              value="{{ old('semester_id') }}" autofocus>
              <option value="">Elige un período</option>
              @foreach ($semesters as $key => $item)
              <option value="{{ $key }}">{{ $item }}</option>
              @endforeach
            </select>
          </div>
          <div class="two fields">
            <div class="field">
              <label for="subject_id">Materia</label>
              <select name="subject_id" id="subject_id" class="ui search selection dropdown" autocomplete="off">
                <option value="">Elige una materia</option>
                @foreach ($subjects as $item)
                <option value="{{ $item->id }}">[{{ $item->key }}] {{ $item->short_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="four wide field">
              <label for="name">Clave</label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="A" autocomplete="off">
            </div>
          </div>
          <div class="ui buttons">
            <a href="{{ route('groups.index') }}" class="ui button">Cancelar</a>
            <div class="or" data-text="o"></div>
            <button type="submit" class="ui positive right labeled icon submit button">
              <i class="save icon"></i>
              Guardar
            </button>
          </div>

          @include('components.errors-message')

        </form>
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/new-group.form.js')
@endpush
