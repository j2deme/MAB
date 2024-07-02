<p>Puedes solicitar un máximo de {{ $max_ups }} movimientos de alta.</p>
<div class="ui five stackable cards">
  @for ($i = 0; $i < max($max_ups, count($moves)); $i++) <div class="ui fluid card">
    @if (isset($moves[$i]))
    <div class="content">
      <div class="header">
        <h5>{{ $moves[$i]->group->subject->short_name }}</h5>
      </div>
      <div class="meta">
        <div class="right floated">
          @if ($moves[$i]->is_parallel)
          <span class="ui blue small label">P</span>
          @endif
        </div>
      </div>
    </div>
    <div class="extra content">
      <span class="left floated">
        @if ($moves[$i]->is_parallel)
        <span class="ui blue small label">P</span>
        @endif
      </span>
      <span class="right floated">
        <span class="ui small black label">
          {{ $moves[$i]->group->full_key }}
        </span>
      </span>
    </div>
    @else
    <div class="content">
      <div class="center aligned header">
        {{ $i + 1 }}
      </div>
      <div class="center aligned description">
        Disponible
      </div>
    </div>
    @endif
</div>
@endfor
</div>
<br>
@if (count($moves) < $max_ups) <form action="{{ route('moves.save') }}"
  class="ui form {{ (!$ups_open) ? 'closed' : null }}" method="POST" id="moveForm">
  @csrf
  <input type="hidden" id="type" name="type" value="{{ $type }}">
  @php
  function careerLabel($career){
  $career = str_replace('-MIX', ' MIXTA', strtoupper($career));
  $career = str_replace('IIA', ' ING. IND. ALIMENTARIAS', $career);
  $career = str_replace('II', ' ING. INDUSTRIAL', $career);
  $career = str_replace('IGE', ' ING. GESTIÓN EMPRESARIAL', $career);
  $career = str_replace('ISC', ' ING. SISTEMAS COMPUTACIONALES', $career);
  $career = str_replace('IAMB', ' ING. AMBIENTAL', $career);
  $career = str_replace('IAGRO', ' ING. EN AGRONOMÍA', $career);

  return $career;
  }
  @endphp
  <div class="field">
    <span class="ui primary circular label">1</span>
    <label for="group_id">Elige el grupo que estas solicitando (sólo se muestran los disponibles)</label>
    <select id="group_id" name="group_id" class="ui search selection dropdown">
      <option value="">---</option>
      @foreach ($groups as $item)
      <option value="{{ $item->id }}">{{ $item->subject->long_name }} ({{ $item->key }} - {{
        careerLabel($item->subject->career->acronym) }})</option>
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
    <textarea name="motivation" id="motivation" rows="5" maxlength="250"></textarea>
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