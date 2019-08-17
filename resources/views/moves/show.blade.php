@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="twelve wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Solicitud
          </h2>
        </header>
        <table class="ui celled compact table">
          <thead>
            <tr>
              @hasanyrole(['Coordinador','Jefe','Admin'])
              <th class="ui center aligned one wide">No. Control</th>
              <th class="ui center aligned">Nombre</th>
              <th class="ui center aligned two wide">Carrera</th>
              <th class="ui center aligned two wide">
                <i class="ui eye icon"></i>
              </th>
              @endhasanyrole
              <th class="ui center aligned four wide">Solicitud</th>
              <th class="ui center aligned one wide">Paralelo</th>
              <th class="ui center aligned one wide">Estatus</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              @hasanyrole(['Coordinador','Jefe','Admin'])
              <td class="ui center aligned">{{ $move->user->username }}</td>
              <td class="ui center aligned">{{ $move->user->full_name }}</td>
              <td class="ui center aligned">{{ $move->user->career->key }}</td>
              <td class="ui center aligned">
                <a href="http://192.99.204.36/SEGRET/caso/{{ $move->user->username }}" target="_blank">Avance</a>
              </td>
              @endhasanyrole
              <td class="ui center aligned">{{ $move->type }} DE {{ $move->group->subject->short_name }}
                ({{ $move->group->full_key }})</td>
              <td class="ui center aligned">
                @if ($move->type == 'BAJA')
                <i class="ui large grey minus icon"></i>
                @else
                <i class="ui large {{ $move->is_parallel ? 'green check' : 'red times' }} icon"></i>
                @endif
              </td>
              <td class="ui center aligned">
                @include('shared._move_status', ['status' => $move->status])
              </td>
            </tr>
          </tbody>
        </table>
        <table class="ui celled compact table">
          <thead>
            <tr>
              <th class="ui center aligned five wide">Motivo</th>
              <th class="ui center aligned">Extras</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="ui center aligned">{{ $move->justification['main'] }}</td>
              <td class="ui center aligned">{{ $move->justification['extra'] }}</td>
            </tr>
          </tbody>
        </table>
        @if (isset($move->answer['main']))
        <table class="ui celled compact table">
          <thead>
            <tr>
              <th class="ui center aligned five wide">Respuesta</th>
              <th class="ui center aligned">Extras</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="ui center aligned">{{ $move->answer['main'] }}</td>
              <td class="ui center aligned">{{ $move->answer['extra'] }}</td>
            </tr>
          </tbody>
        </table>
        @endif
        @include('components.back', ['route' => route('moves.index')])
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/check-move.form.js')
@endpush
