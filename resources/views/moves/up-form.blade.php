@php
$statuses = [
'0' => ['teal', 'REGISTRADA'], // Registrada
'1' => ['yellow', 'REVISIÓN'], // En revisión
'2' => ['orange', 'RECHAZADA'], // Rechazada por coordinador
'3' => ['green', 'ACEPTADA'], // Aceptada por coordinador
'4' => ['green', 'ACEPTADA'], // Aceptada por jefe / admin
'5' => ['red', 'RECHAZADA'] // Rechazada por jefe / admin
];
@endphp
<p>Puedes solicitar un máximo de {{ $max_ups }} movimientos de alta.</p>
<div class="ui five stackable cards">
  @for ($i = 0; $i < max($max_ups, count($moves)); $i++)
  <div class="ui fluid {{ (isset($moves[$i])) ? $statuses[$moves[$i]->status][0] : null }} card">
    <div class="content">
    @if (isset($moves[$i]))
      <div class="content">
        <div class="header">
          <span>{{ $moves[$i]->group->subject->short_name }}</span>
        </div>
        <div class="meta">
          <div class="left floated">
            @if ($moves[$i]->is_parallel)
              <span class="ui blue small circular label">P</span>
            @endif
          </div>
          <span class="right floated">
            <span class="ui mini label">
              {{ $moves[$i]->group->full_key }}
            </span>
          </span>
        </div>
      </div>
    @else
      <div class="center aligned header">
        {{ $i + 1 }}
      </div>
      <div class="center aligned description">
        Disponible
      </div>
    @endif
    </div>
  </div>
  @endfor
</div>
<br>
@if (count($moves) < $max_ups)
<form action="{{ route('moves.save') }}" class="ui form {{ (!$ups_open) ? 'closed' : null }}" method="POST"
  id="moveForm">
  @csrf
  <input type="hidden" id="type" name="type" value="{{ $type }}">
  <div class="field">
    <span class="ui primary circular label">1</span>
    <label for="group_id">Elige el grupo que estas solicitando (sólo se muestran los disponibles)</label>
    <select id="group_id" name="group_id" class="ui search selection dropdown">
      <option value="">---</option>
      @foreach ($groups as $item)
      <option value="{{ $item->id }}">[{{ $item->full_key }}] {{ $item->subject->long_name }}</option>
      @endforeach
    </select>
  </div>
  <div class="field">
    <span class="ui primary circular label">2</span>
    <label for="justification">Elige el motivo que más se acerque al tuyo</label>
    <select id="justification" name="justification" class="ui search selection dropdown">
      <option value="">---</option>
      @foreach ($justifications['up'] as $item)
      <option value="{{ $item }}">{{ $item }}</option>
      @endforeach
    </select>
  </div>
  <div class="field">
    <span class="ui primary circular label">3</span>
    <label for="motivation">Añade más información sobre el motivo seleccionado</label>
    <textarea name="motivation" id="motivation" rows="5" maxlength="150"></textarea>
    <span class="ui chars"></span>
  </div>
  @include('components.back', ['route' => route('moves.index')])
  @if ($ups_open)
  <button type="submit" class="ui green labeled icon submit button">
    <i class="send icon"></i>
    Enviar
  </button>
  @endif

  @include('components.errors-message')

  <div class="ui dimmer">
    <div class="content">
      <h2 class="ui inverted icon header">
        <i class="red ban icon"></i>
        El período de altas es del {{ $last->begin_up->format('d/m/Y') }} al {{ $last->end_up->format('d/m/Y') }}
      </h2>
      <a href="{{ route('moves.index') }}" class="ui inverted labeled icon button">
        <i class="chevron left icon"></i> Regresar
      </a>
    </div>
  </div>
</form>
@else
@include('components.back', ['route' => route('moves.index')])
@endif
