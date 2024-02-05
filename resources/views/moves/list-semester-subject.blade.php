@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Solicitudes por materia
          </h2>
        </header>

        @foreach ($groupedBySemester as $key => $semester)
        <article>
          <header>
            <h2 class="ui header">Semestre {{ $key }}</h2>
          </header>
          <div class="ui six cards">
            @foreach ($semester as $key => $subject)
            @if(starts_with($key, 'ISI'))
            @php ($color = 'blue')
            @elseif(starts_with($key, 'IGE') or starts_with($key, 'GIO'))
            @php ($color = 'teal')
            @elseif(starts_with($key, 'IIA'))
            @php ($color = 'green')
            @elseif(starts_with($key, 'II'))
            @php ($color = 'red')
            @elseif(starts_with($key, 'IAGR'))
            @php ($color = 'orange')
            @elseif(starts_with($key, 'IAMB'))
            @php ($color = 'olive')
            @else
            @php ($color = 'black')
            @endif
            <a href="{{ route('moves.bySubject', $key) }}" class="ui {{ $color }} card">
              <div class="content">
                <div class="header">
                  <h5>{{ $key }}</h5>
                </div>
                <div class="description">
                  {{ $subjects[$key] }}
                </div>
              </div>
              <div class="extra content">
                <i class="stream icon"></i>
                {{ $semester[$key]->count() }} solicitud{{ ($semester[$key]->count() > 1) ? 'es' : null }}
              </div>
            </a>
            @endforeach
          </div>
        </article>
        <br><br>
        @endforeach
        @include('components.back', ['route' => route('home.index')])
      </article>
    </section>
  </div>
</div>
@endsection