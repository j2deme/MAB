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
