@if (is_null(Auth::user()->career))
<div class="ui warning icon message">
  <i class="ui exclamation triangle icon"></i>
  <div class="content">
    <div class="header">Hola {{ Auth::user()->name }}</div>
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
    <div class="header">Hola {{ Auth::user()->name }}</div>
    <div class="ui warning message">
      <div class="header">
        Atención
      </div>
      Antes de realizar tus solicitudes, verifica tu horario en el sistema, recuerda que todo cambio que solicites es bajo tu responsabilidad.
    </div>
    <ul class="list">
      <li>En este módulo podrás registrar tus solicitudes de altas y bajas, para una atención más ágil, es importante que sepas que cada movimiento
        <span class="ui red text"><strong> se registra y procesa de manera individual</strong></span>.</li>
      <li>Una vez que registres tus solicitudes, podrás conocer su estatus en todo momento a través de la opción <strong>Solicitudes</strong></li>
      <li>Considera que
        dependiendo de la complejidad de tu solicitud, puede tomar más tiempo del que esperas.</li>
      <li>El tiempo de atención de cada solicitud inicia una vez que cambia su estatus a "En Revisión", no desde que se captura.</li>
      <li>Todas las solicitudes serán atendidas tomando en cuenta el cupo máximo autorizado para cada grupo.</li>
      <li>Recuerda que si solicitas una materia en otra carrera (paralelo), será atendida hasta haber resuelto todas las solicitudes de esa carrera y estará sujeta a compatibilidad del programa de estudios.</li>
      <li>Al realizar tus solicitudes, se da por entendido que leíste y aceptas las presentes consideraciones.</li>
    </ul>
  </div>
</div>
<div class="ui three column stackable grid cards">
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
  <div class="column">
    <a class="ui fluid card" href="{{ route('moves.switchGroup') }}">
      <div class="content">
        <div class="header">Cambio de Grupo</div>
        <div class="description">
          Solicita un cambio del bloque base completo de materias
        </div>
      </div>
      <div class="ui bottom attached purple icon button">
        <i class="ui sync alternate big icon"></i>
      </div>
    </a>
  </div>
</div>
@endif
