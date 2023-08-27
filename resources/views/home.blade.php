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
    <aside class="four wide computer column">
      <section class="ui segment">
        <header>
          <h2 class="ui secondary dividing header">Estadísticas</h2>
        </header>
        <div class="ui center aligned grid">
          <div class="row">
            <div class="ui stackable horizontal statistics">
              <div class="ui statistic">
                <div class="value">{{ number_format($ups) }}</div>
                <div class="label">Altas</div>
              </div>
              <div class="ui statistic">
                <div class="value">{{ number_format($downs) }}</div>
                <div class="label">Bajas</div>
              </div>
              <div class="ui statistic">
                <div class="value">{{ number_format($attended) }}</div>
                <div class="label">Atendidas</div>
              </div>
              @hasanyrole(['Jefe','Admin'])
              <div class="ui statistic">
                <div class="value">{{ App\Semester::last()->groups->count() }}</div>
                <div class="blue label">Grupos</div>
              </div>
              @endhasanyrole
            </div>
          </div>
        </div>
        @hasanyrole(['Jefe','Admin','Coordinador'])
        <header>
          <h2 class="ui secondary dividing header">Avance</h2>
        </header>
        @php ($total = $ups + $downs)
        <div class="ui indicating progress">
          <div class="bar">
            <div class="progress"></div>   
          </div>
        </div>
        @endhasanyrole
      </section>
    </aside>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    $('.ui.dropdown').dropdown();

    $('.ui.progress').progress(
      {
        percent: {{ $attended / $total * 100 }},
      }
    );
  });
</script>
@endpush
