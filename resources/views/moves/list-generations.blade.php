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

        @hasanyrole(['Admin', 'Jefe'])
        <div class="ui sixteen wide column">
          <span class="ui blue label">SISTEMAS</span>
          <span class="ui red label">INDUSTRIAL</span>
          <span class="ui teal label">GESTIÓN EMP.</span>
          <span class="ui green label">ALIMENTARIAS</span>
          <span class="ui olive label">AMBIENTAL</span>
          <span class="ui orange label">AGRONOMÍA</span>
        </div>
        @endhasanyrole
        <div class="ui hidden divider"></div>
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
          <div class="ui six doubling cards">
            @foreach ($generation as $key => $move)
            @if(starts_with($move->user->career->key, 'ISC'))
            @php ($color = 'blue')
            @elseif(starts_with($move->user->career->key, 'IGE'))
            @php ($color = 'teal')
            @elseif(starts_with($move->user->career->key, 'IIA'))
            @php ($color = 'green')
            @elseif(starts_with($move->user->career->key, 'IAMB'))
            @php ($color = 'olive')
            @elseif(starts_with($move->user->career->key, 'II'))
            @php ($color = 'red')
            @elseif(starts_with($move->user->career->key, 'IAGRO'))
            @php ($color = 'orange')
            @else
            @php ($color = 'black')
            @endif
            <a href="{{ route('moves.byStudent', $move->user->username) }}" class="ui {{ $color }} card">
              <div class="ui content {{ (!$move->user->is_enrolled) ? "$color inverted" : null }} segment">
                @if (!$move->user->is_enrolled)
                  <i class="ui right floated star icon"></i>
                @endif
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
        <div class="ui hidden divider"></div>
        @endforeach
        @include('components.back', ['route' => route('home.index')])
      </article>
    </section>
  </div>
</div>
@endsection
