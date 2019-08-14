<form action="{{ route('moves.save') }}" class="ui form" method="POST">
  @csrf
  <input type="hidden" id="type" name="type" value="{{ $type }}">
  <div class="field">
    <label for="group">Elige el grupo que estas solicitando (sólo se muestran los disponibles)</label>
    <select id="group" name="group" class="ui search selection dropdown">
      <option value="">---</option>
      @foreach ($groups as $item)
      <option value="{{ $item->id }}">[{{ $item->name }}] {{ $item->subject->long_name }}</option>
      @endforeach
    </select>
  </div>
  <div class="field">
    <label for="justification">Elige el motivo que más se acerque al tuyo</label>
    <select id="justification" name="justification" class="ui search selection dropdown">
      <option value="">---</option>
      @foreach ($justifications['up'] as $item)
      <option value="{{ $item }}">{{ $item }}</option>
      @endforeach
    </select>
  </div>
  <div class="field">
    <label for="motivation">Añade más información sobre el motivo seleccionado</label>
    <textarea name="motivation" id="motivation" rows="5" maxlength="150"></textarea>
    <span class="ui chars"></span>
  </div>
  <button type="submit" class="ui fluid primary labeled icon submit button">
    <i class="send icon"></i>
    Enviar
  </button>

  @include('components.errors-message')

</form>
