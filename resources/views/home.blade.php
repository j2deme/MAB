@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable grid">
  <div class="ui stretched row">
    <section class="ui sixteen wide mobile twelve wide computer column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">Dashboard</h2>
        </header>
        @role('Estudiante')
        @include('home.student')
        @endrole
      </article>
    </section>
    <aside class="four wide computer only column">
      <section class="ui segment">
        <header>
          <h2 class="ui secondary dividing header">Estadísticas</h2>
        </header>
        <div class="ui center aligned grid">
          <div class="column">
            <div class="ui stackable statistics">
              <div class="ui statistic">
                <div class="value">{{ $ups }}</div>
                <div class="blue label">Altas</div>
              </div>
              <div class="ui statistic">
                <div class="value">{{ $downs }}</div>
                <div class="label">Bajas</div>
              </div>
              <div class="ui statistic">
                <div class="value">{{ $attended }}</div>
                <div class="label">Atendidas</div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </aside>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    $('.ui.dropdown').dropdown();
  });
</script>
@endpush
