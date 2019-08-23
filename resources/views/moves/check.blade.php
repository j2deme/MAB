@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="twelve wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Revisar solicitud
          </h2>
        </header>

        <form action="{{ route('moves.update',['move'=>$move]) }}" class="ui form" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="url" id="url" value="{{ url()->previous() }}">
          <input type="hidden" id="move_id" name="move_id" value="{{ $move->id }}">
          <div class="field">
            <table class="ui celled compact table">
              <thead>
                <tr>
                  <th class="ui center aligned one wide">No. Control</th>
                  <th class="ui center aligned">Nombre</th>
                  <th class="ui center aligned two wide">Carrera</th>
                  <th class="ui center aligned two wide">
                    <i class="ui eye icon"></i>
                  </th>
                  <th class="ui center aligned four wide">Solicitud</th>
                  <th class="ui center aligned one wide">Paralelo</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="ui center aligned">{{ $move->user->username }}</td>
                  <td class="ui center aligned">{{ $move->user->full_name }}</td>
                  <td class="ui center aligned">{{ $move->user->career->key }}</td>
                  <td class="ui center aligned">
                    <a href="http://192.99.204.36/SEGRET/caso/{{ $move->user->username }}" target="_blank">Avance</a>
                  </td>
                  <td class="ui center aligned">{{ $move->type }} DE {{ $move->group->subject->short_name }}
                    ({{ $move->group->full_key }})</td>
                  <td class="ui center aligned">
                    @if ($move->type == 'BAJA')
                    <i class="ui large grey minus icon"></i>
                    @else
                    <i class="ui large {{ $move->is_parallel ? 'green check' : 'red times' }} icon"></i>
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
            <table class="ui celled compact table">
              <thead>
                <tr>
                  <th class="ui center aligned">Motivo</th>
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
          </div>
          <div class="field">
            <label for="answer">Respuesta rápida</label>
            <select id="answer" name="answer" class="ui search selection dropdown">
              <option value="">Elija una respuesta predefinida</option>
              @foreach ($answers as $item)
              <option value="{{ $item }}">{{ $item }}</option>
              @endforeach
            </select>
          </div>
          <div class="field">
            <label for="extra">Añade información extra para respuesta (Opcional)</label>
            <textarea name="extra" id="extra" rows="5" maxlength="150"></textarea>
            <span class="ui chars"></span>
          </div>
          <div class="ui warning visible icon message">
            <i class="exclamation triangle icon"></i>
            <div class="content">
              <div class="ui big header">
                ATENCIÓN COORDINADOR
              </div>
              <h2>Verifique que el movimiento se puede realizar en el SII, antes de presionar "ACEPTAR".</h2>
            </div>
          </div>
          @include('components.back')
          <button type="submit" class="ui red labeled icon submit button" id="denyBtn" name="denyBtn" value="0">
            <i class="times icon"></i> Rechazar
          </button>
          <button type="submit" class="ui green labeled icon submit button" id="acceptBtn" name="acceptBtn" value="1">
            <i class="check icon"></i> Aceptar
          </button>

          @include('components.errors-message')

        </form>
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/check-move.form.js')
@endpush
