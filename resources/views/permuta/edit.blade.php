@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="twelve wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Revisar solicitud de cambio de grupo
          </h2>
        </header>

        <form action="{{ route('permutas.update',['permuta'=>$permuta]) }}" class="ui form" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="url" id="url" value="{{ url()->previous() }}">
          <input type="hidden" id="permuta_id" name="permuta_id" value="{{ $permuta->id }}">
          <div class="field">
            <table class="ui celled compact table">
              <thead>
                <tr>
                  <th class="ui center aligned two wide">No. Control</th>
                  <th class="ui center aligned">Nombre</th>
                  <th class="ui center aligned two wide">Carrera</th>
                  <th class="ui center aligned four wide">Solicitud</th>
                  <th class="ui center aligned one wide">Candidato</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="ui center aligned">{{ $permuta->user->username }}</td>
                  <td class="ui center aligned">{{ $permuta->user->full_name }}</td>
                  <td class="ui center aligned">{{ $permuta->user->career->internal_key }}</td>
                  <td class="ui center aligned">Cambio de {{ $permuta->base_semester }}{{ $permuta->base_group }} a {{ $permuta->base_semester }}{{ $permuta->switch_group }}</td>
                  <td class="ui center aligned">
                    @if (empty($permuta->candidate))
                    <i class="ui large grey minus icon"></i>
                    @else
                    {{ $permuta->match->username }}
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
            <table class="ui celled compact table">
              <thead>
                <tr>
                  <th class="ui center aligned">Estatus</th>
                  <th class="ui center aligned">Extras</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="ui center aligned two wide">
                    @include('shared._permuta_status', ['status' => $permuta->status])
                  </td>
                  <td class="ui left aligned">
                    @if (!empty($permuta->candidate) and in_array($permuta->status, [1,2,3,4])
                    )
                      El estudiante {{ $permuta->match->username }} - {{ $permuta->match->full_name }}, registró una solicitud recíproca para permutar con el estudiante {{ $permuta->user->username }} - {{ $permuta->user->full_name }}.
                    @elseif(!empty($permuta->candidate) and $permuta->status == 0)
                      Se propuso al estudiante {{ $permuta->match->username }} - {{ $permuta->match->full_name }}, sin embargo, no se recibió una solicitud recíproca para permutar.
                    @else
                      No se propuso candidato para permuta.
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="field">
            <label for="answer">Respuesta rápida</label>
            <select id="answer" name="answer" class="ui search selection dropdown">
              <option value="">Elija una respuesta predefinida</option>
              {{-- @foreach ($answers as $item)
              <option value="{{ $item }}">{{ $item }}</option>
              @endforeach --}}
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
          {{-- <button type="submit" class="ui red labeled icon submit button" id="denyBtn" name="denyBtn" value="0">
            <i class="times icon"></i> Rechazar
          </button>
          <button type="submit" class="ui green labeled icon submit button" id="acceptBtn" name="acceptBtn" value="1">
            <i class="check icon"></i> Aceptar
          </button> --}}

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
