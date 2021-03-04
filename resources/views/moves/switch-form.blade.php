@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Solicitud de cambio de grupo
          </h2>
        </header>
        @if ($active_permuta)
        <div class="ui icon info message">
          <i class="inbox icon"></i>
          <div class="content">
            <div class="header">
              Solicitud registrada
            </div>
            <p>Ya cuentas con una solicitud de cambio de grupo para el semestre {{ $last_semester->long_name }}, registrada para cambiar del bloque base <strong>{{ $permuta->base_semester . $permuta->base_group }}</strong> al <strong>{{ $permuta->base_semester . $permuta->switch_group }}</strong>.</p>
            @if (!is_null($permuta->match))
              <p>Has registrado como candidato para cambiar con {{ $permuta->match->username }} - {{ $permuta->match->name }} {{ $permuta->match->last_name }}, una vez que esta persona registre su solicitud y coincida con la información que capturaste, la solicitud será preautorizada y pasará a revisión por la División de Estudios Profesionales.</p>
            @else
              <p>Tu solicitud quedará en espera hasta que otro estudiante registre un movimiento inverso a lo que solicitas o hasta el límite del periodo para adecuación de carga académica.</p>
              <p>Se te recuerda que la solicitud no es garantía de que se realice, ya que está sujeta a que exista un candidato para cambiar el grupo.</p>
            @endif
          </div>
        </div>
        @include('components.back', ['route' => route('moves.index')])
        @else
        <form action="{{ route('moves.saveSwitchGroup') }}" class="ui form" method="POST" id="switchGroupForm">
          @csrf
          <div class="ui field">
            <span class="ui primary circular label">1</span>
            <label>Elige el semestre y grupo de tu bloque base de materias</label>
            <div class="ui two fields">
              <div class="field">
                <select id="base_semester" name="base_semester" class="ui search selection dropdown">
                  <option value="">---</option>
                  @foreach (range(1,9) as $item)
                  <option value="{{ $item }}">{{ $item }}</option>
                  @endforeach
                </select>
              </div>
              <div class="field">
                <select id="base_group" name="base_group" class="ui search selection dropdown">
                  <option value="">---</option>
                  @foreach (range('A','C') as $item)
                  <option value="{{ $item }}">{{ $item }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="ui field">
            <span class="ui primary circular label">2</span>
            <label for="group">Elige el identificador del grupo al que buscas tu cambio</label>
            <select id="switch_group" name="switch_group" class="ui search selection dropdown">
              <option value="">---</option>
              @foreach (range('A','C') as $item)
              <option value="{{ $item }}">{{ $item }}</option>
              @endforeach
            </select>
          </div>
          <p>En caso de contar con algún compañero(a) que haya aceptado cambiar su lugar contigo, captura su número de control para preautorizar el cambio de grupo, te recordamos que los cambios no se reflejan inmediatamente en el SII.</p>
          <p>Si no cuentas con ningún compañero(a) que quiera realizar el cambio, puedes dejar el siguiente campo vacío, nosotros revisaremos si alguien solicito el movimiento a la inversa de lo que solicitas y los conectaremos.</p>
          <div class="fields">
            <div class="field">
              <span class="ui primary circular label">3</span>
              <label for="candidate">Captura el número de control de tu compañero(a) si cuentas con algún candidato para cambio o deja vacío</label>
              <input type="text" name="candidate" id="candidate"></input>
            </div>
          </div>
          <p>Una vez que hayas capturado tu solicitud no podrás cambiarla, revisa antes de enviarla, podrás revisar el estatus en esta misma sección.</p>
          
          @include('components.back', ['route' => route('moves.index')])
          <button type="submit" class="ui green labeled icon submit button">
            <i class="send icon"></i>
            Enviar
          </button>

          @include('components.errors-message')

          <div class="ui dimmer">
            <div class="content">
              <h2 class="ui inverted icon header">
                <i class="red ban icon"></i>
                {{-- El período de altas es del {{ $last->begin_up->format('d/m/Y') }} al {{ $last->end_up->format('d/m/Y') }} --}}
              </h2>
              <a href="{{ route('moves.index') }}" class="ui inverted labeled icon button">
                <i class="chevron left icon"></i> Regresar
              </a>
            </div>
          </div>
        </form>
        @endif
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/switch-group.form.js')
@endpush
