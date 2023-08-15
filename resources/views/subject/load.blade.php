@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Cargar materias
          </h2>
        </header>
        <form action="{{ route('subjects.load') }}" class="ui equal width form @hasError" method="POST">
          @csrf
          <p>Los registros deben tener la siguiente estructura por fila. Regularmente, al copiar desde una hoja de cálculo, las celdas de una misma fila, se separan por 1 tabulador.</p>
          <ol>
            <li>Clave Interna de la Asignatura</li>
            <li>Nombre Corto, en mayúsculas</li>
            <li>Nombre Completo, en mayúsculas</li>
            <li>Carrera (Clave numérica de la carrera)</li>
            <li>Semestre en que se imparte</li>
            <li>Horas Teóricas</li>
            <li>Horas Prácticas</li>
            <li>Créditos</li>
          </ol>

          <div class="field">      
            <label for="materias">Materias</label>
            <textarea id="materias" name="materias"></textarea>
          </div>
          
          <div class="ui small primary progress" id="charNum">
            <div class="bar">
              <div class="progress"></div>
            </div>
            <div class="label">Límite de procesamiento</div>
          </div>

          @include('components.back', ['route' => route('subjects.index')])
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
$("input:text").click(function() {
  $(this).parent().find("input:file").click();
});

$('input:file', '.ui.action.input')
  .on('change', function(e) {
    var name = e.target.files[0].name;
    $('input:text', $(e.target).parent()).val(name);
  });

var text_max = 524000; // 524,288 bytes = 512 KB
var $progress      = $('#charNum');
$progress.progress({
  percent: 0
});

$('#materias').keyup(function() {
  var text_length = $('#materias').val().length;
  var text_remaining = text_max - text_length;

  $progress.progress({
    percent: Math.ceil((text_length / text_max) * 100)
  });
});
</script>
@endpush
