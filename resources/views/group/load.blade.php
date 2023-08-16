@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Cargar grupos
          </h2>
        </header>
        <form action="{{ route('groups.load') }}" class="ui equal width form @hasError" method="POST">
          @csrf
          <p>Los registros deben tener la siguiente estructura por fila. Regularmente, al copiar desde una hoja de cálculo, las celdas de una misma fila, se separan por 1 tabulador.</p>
          <ol>
            <li>Clave Interna de la Asignatura</li>
            <li>Identificador del grupo</li>
          </ol>
          <p>Los grupos serán cargados al semestre {{ $semester->short_name }}.</p>

          <div class="ui visible icon warning message">
            <i class="exclamation triangle icon"></i>
            <div class="content">
              <div class="header">
                Recordatorio
              </div>
              <p>Antes de crear grupos es importante que las asignaturas ya estén cargadas en el sistema.</p>
            </div>
          </div>

          <div class="field">      
            <label for="grupos">Grupos</label>
            <textarea id="grupos" name="grupos"></textarea>
          </div>
          
          <div class="ui small primary progress" id="charNum">
            <div class="bar">
              <div class="progress"></div>
            </div>
            <div class="label">Límite de procesamiento</div>
          </div>

          @include('components.back', ['route' => route('groups.index')])
          <button type="submit" class="ui positive labeled icon submit button">
            <i class="upload icon"></i>
            Cargar
          </button>

          @include('components.errors-message')

        </form>
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
<script>
var text_max = 524000; // 524,288 bytes = 512 KB
var $progress      = $('#charNum');
$progress.progress({
  percent: 0
});

$('#grupos').keyup(function() {
  var text_length = $('#grupos').val().length;
  var text_remaining = text_max - text_length;

  $progress.progress({
    percent: Math.ceil((text_length / text_max) * 100)
  });
});
</script>
@endpush
