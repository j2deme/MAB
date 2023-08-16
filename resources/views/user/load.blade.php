@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Cargar estudiantes
          </h2>
        </header>
        <form action="{{ route('users.load') }}" class="ui equal width form @hasError" method="POST">
          @csrf
          <p>Los registros deben tener la siguiente estructura por fila. Regularmente, al copiar desde una hoja de cálculo, las celdas de una misma fila, se separan por 1 tabulador.</p>
          <ol>
            <li>Número de control</li>
            <li>Nombre(s)</li>
            <li>Primer Apellido</li>
            <li>Segundo Apellido </li>
            <li>NIP</li>
            <li>Carrera (Clave numérica de la carrera)</li>
          </ol>

          <div class="field">      
            <label for="estudiantes">Estudiantes</label>
            <textarea id="estudiantes" name="estudiantes"></textarea>
          </div>
          
          <div class="ui small primary progress" id="charNum">
            <div class="bar">
              <div class="progress"></div>
            </div>
            <div class="label">Límite de procesamiento</div>
          </div>

          @include('components.back', ['route' => route('users.index')])
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

$('#estudiantes').keyup(function() {
  var text_length = $('#estudiantes').val().length;
  var text_remaining = text_max - text_length;

  $progress.progress({
    percent: Math.ceil((text_length / text_max) * 100)
  });
});
</script>
@endpush
