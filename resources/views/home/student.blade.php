@if (is_null(Auth::user()->career))
<div class="ui warning icon message">
  <i class="ui exclamation triangle icon"></i>
  <div class="content">
    <div class="header">Bienvenido {{ Auth::user()->name }}</div>
    <p>
      Para poder continuar con las solicitudes de cambios, es necesario que especifiques que carrera cursas.
    </p>
    <p>En caso de seleccionar la carrera incorrecta, no se mostrarán las grupos disponibles para solicitar movimientos.
    </p>
    <form action="{{ route ('users.selfUpdate', Auth::user()) }}" class="ui form" method="post">
      @csrf
      @method('PUT')
      <div class="field">
        <label for="career_id">Carrera</label>
        <select name="career_id" id="career_id" class="ui dropdown">
          @foreach ($careers as $key => $value)
          <option value="{{ $key }}">{{ $value }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="ui fluid primary labeled icon submit button">
        <i class="save icon"></i>
        Guardar
      </button>
    </form>
  </div>
</div>
@else
<div class="ui message">
  <div class="content">
    <div class="header">Bienvenido {{ Auth::user()->name }}</div>
    <ul class="list">
      <li>En este módulo podrás registrar tus solicitudes de altas y bajas, cada movimiento se registra y
        procesa de
        manera individual, para una atención más ágil.</li>
      <li>Una vez que registres tus solicitudes, podrás conocer su estatus en todo momento. Considera que
        dependiendo de la complejidad de tu solicitud, puede tomar más tiempo del que esperas.</li>
    </ul>
  </div>
</div>
<div class="ui two column stackable grid cards">
  <div class="column">
    <a class="ui fluid card" href="{{ route('moves.new',['type' => 'up']) }}">
      <div class="content">
        <div class="header">Alta de materias</div>
        <div class="description">
          Solicita ampliación de tu carga académica
        </div>
      </div>
      <div class="ui bottom attached blue icon button">
        <i class="ui sort up big icon"></i>
      </div>
    </a>
  </div>
  <div class="column">
    <a class="ui fluid card" href="{{ route('moves.new',['type' => 'down']) }}">
      <div class="content">
        <div class="header">Baja de materias</div>
        <div class="description">
          Solicita reducción de tu carga académica
        </div>
      </div>
      <div class="ui bottom attached red icon button">
        <i class="ui sort down big icon"></i>
      </div>
    </a>
  </div>
</div>
@endif
