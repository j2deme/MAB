@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="twelve wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            @if (in_array($move->status, ['0','1']))
            Atender solicitud
            @else
            Modificar respuesta de solicitud
            @endif
          </h2>
        </header>

        <div class="tablet only computer only large screen only widescreen only sixteen wide column">
          <table class="ui celled compact table">
            <thead>
              <tr>
                <th class="ui center aligned">Estudiante</th>
                <th class="ui center aligned">Carrera</th>
                <th class="ui center aligned four wide">Materia</th>
                <th class="ui center aligned two wide">Solicitud</th>
                <th class="ui center aligned">Estatus</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ui center aligned">
                  <strong>{{ $move->user->username }}</strong><br>
                  {{ $move->user->full_name }}
                </td>
                <td class="ui center aligned">{{ $move->user->career->acronym }}</td>
                <td class="ui center aligned">{{ $move->group->subject->short_name }}
                  ({{ $move->group->full_key }})</td>
                <td class="ui center aligned">
                  <strong>{{ $move->type }}</strong>&nbsp;
                  @if($move->type == "ALTA")
                  <i class="ui arrow up blue icon"></i>
                  @else
                  <i class="ui arrow down red icon"></i>
                  @endif
                  @if ($move->is_parallel)
                  <span class="ui blue label">P</span>
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
        </div>

        <div class="mobile only sixteen wide column">
          <div class="ui horizontal card">
            <div class="content">
              <div class="header">{{ $move->group->subject->short_name }} ({{ $move->group->full_key }})</div>
              <div class="meta">
                <span class="right floated">
                  {{ $move->user->username }} <small>({{ $move->user->career->acronym }})</small>
                </span>
                <span class="category"><small>{{ $move->type }}</small> <i
                    class="ui {{ $move->type == 'ALTA' ? 'blue arrow up' : 'red arrow down' }} icon"></i></span>
              </div>
              <div class="description">
                <h4>{{ $move->justification['main'] }}</h4>
                {{ $move->justification['extra'] }}
              </div>
            </div>
            <div class="extra content">
              <div class="left floated">
                @if ($move->is_parallel)
                <a class="ui blue label">PARALELO</a>
                @endif
              </div>
              <div class="right floated">
                @include('shared._move_status', ['status' => $move->status])
              </div>
            </div>
          </div>
        </div>
        <div class="ui hidden divider"></div>
        <form action="{{ route('moves.update',['move'=>$move]) }}" class="ui form" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="url" id="url" value="{{ url()->previous() }}">
          <input type="hidden" id="move_id" name="move_id" value="{{ $move->id }}">

          <div class="ui two fields">
            <div class="field">
              <label for="answer">Respuesta rápida</label>
              <select id="answer" name="answer" class="ui search selection dropdown">
                <option value="">Elija una respuesta predefinida</option>
                @foreach ($answers as $item)
                <option value="{{ $item }}" {{ (isset($move->answer['main']) and $move->answer['main'] == $item) ?
                  'selected' : '' }}
                  >{{ $item }}</option>
                @endforeach
              </select>
            </div>
            <div class="field">
              <label for="extra">Información extra para respuesta (Opcional)</label>
              <textarea name="extra" id="extra" rows="5"
                maxlength="250">{{ isset($move->answer['extra']) ? $move->answer['extra'] : null }}</textarea>
              <span class="ui chars"></span>
            </div>
          </div>

          <div class="ui warning visible icon message">
            <i class="exclamation triangle icon"></i>
            <div class="content">
              <div class="ui big header">
                <h2>Atención Coordinador</h2>
              </div>
              <p>Antes de aceptar el movimiento, asegurate de que sea posible realizarlo en plataforma.</p>
            </div>
          </div>
          <button type="submit" class="ui red labeled icon submit button" id="denyBtn" name="denyBtn" value="0">
            <i class="times icon"></i> Rechazar
          </button>
          <button type="submit" class="ui green labeled icon submit button" id="acceptBtn" name="acceptBtn" value="1">
            <i class="check icon"></i> Aceptar
          </button>

          @include('components.errors-message')

        </form>
        @include('components.back')
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/check-move.form.js')
@endpush