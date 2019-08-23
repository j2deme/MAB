@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Solicitudes por estudiante
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
            @if(starts_with($move->user->career->key, 'ISI'))
            @php ($color = 'blue')
            @elseif(starts_with($move->user->career->key, 'IIN'))
            @php ($color = 'red')
            @elseif(starts_with($move->user->career->key, 'IGE'))
            @php ($color = 'teal')
            @elseif(starts_with($move->user->career->key, 'IIA'))
            @php ($color = 'green')
            @elseif(starts_with($move->user->career->key, 'IAMB'))
            @php ($color = 'olive')
            @else
            @php ($color = 'black')
            @endif
            <a href="{{ route('moves.byStudent', $key) }}" class="ui {{ $color }} card">
              <div class="content">
                <div class="header">
                  <h5>{{ $move->user->username }}</h5>
                </div>
                <div class="meta">
                  <span class="category">{{ $students[$key] }}
                    solicitud{{ ($students[$key] > 1) ? 'es' : null }}</span>
                  {{-- <span class="category">Animals</span> --}}
                </div>
                <div class="description">
                  {{ $move->user->full_name }}
                </div>
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
