@extends('layouts.app')

@section('css')
<style>
.ui.action.input input[type="file"] {
  display: none;
}
</style>
@endsection

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Activar estudiantes
          </h2>
        </header>
        <form action="{{ route('users.activate') }}" class="ui equal width form @hasError" method="POST" enctype="multipart/form-data">
          @csrf
          <p>El archivo de estudiantes activos, deberá tener la siguiente estructura:</p>
          <ol>
            <li>Número de control</li>
          </ol>
          <p>Se actualizarán todos los estudiantes del archivo, para identificar que ya cuentan con carga académica registrada.</p>

          <div class="field">
            <div class="ui action input">
              <input type="text" placeholder="Archivo CSV" readonly>
              <input type="file" id="file" name="file" required>
              <div class="ui blue icon button">
                <i class="attach icon"></i>
              </div>
            </div>
          </div>

          @include('components.back', ['route' => route('users.index')])
          <button type="submit" class="ui positive labeled icon submit button">
            <i class="upload icon"></i>
            Subir
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
</script>
@endpush
