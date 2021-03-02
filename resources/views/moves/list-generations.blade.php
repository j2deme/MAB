@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            {{ $title or "Solicitudes por estudiante" }}
          </h2>
        </header>

        @foreach ($generations as $key => $generation)
        <article>
          <header>
            <h2 class="ui header">
              Generación {{ $key }}
              <div class="content">
                <div class="sub header">({{ count($generation) }})</div>
              </div>
            </h2>
          </header>
          <div class="ui six cards">
            @foreach ($generation as $key => $move)
            @if(starts_with($move->user->career->internal_key, 'ISC'))
            @php ($color = 'blue')
            @elseif(starts_with($move->user->career->internal_key, 'II'))
            @php ($color = 'red')
            @elseif(starts_with($move->user->career->internal_key, 'IGE'))
            @php ($color = 'teal')
            @elseif(starts_with($move->user->career->internal_key, 'IIA'))
            @php ($color = 'green')
            @elseif(starts_with($move->user->career->internal_key, 'IAMB'))
            @php ($color = 'olive')
            @elseif(starts_with($move->user->career->internal_key, 'IAGRO'))
            @php ($color = 'orange')
            @else
            @php ($color = 'black')
            @endif
            <a href="{{ route('moves.byStudent', $key) }}"
              class="ui {{ $color }} {{ ($move->user->is_suspended) ? 'inverted' : null }} card">
              <div class="content">
                <div class="header">
                  <h5>{{ $move->user->username }}</h5>
                </div>
                <div class="description">
                  {{ $move->user->full_name }}
                </div>
              </div>
              <div class="extra content">
                <i class="stream icon"></i>
                {{ $students[$key] }} solicitud{{ ($students[$key] > 1) ? 'es' : null }}
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
