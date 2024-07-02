@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="twelve wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Solicitud
          </h2>
        </header>
        <div class="tablet only computer only large screen only widescreen only sixteen wide column">
          <table class="ui celled compact table">
            <thead>
              <tr>
                @hasanyrole(['Coordinador','Jefe','Admin'])
                <th class="ui center aligned one wide">No. Control</th>
                <th class="ui center aligned">Nombre</th>
                <th class="ui center aligned two wide">Carrera</th>
                @endhasanyrole
                <th class="ui center aligned four wide">Materia</th>
                <th class="ui center aligned one wide">Solicitud</th>
                <th class="ui center aligned one wide">Estatus</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                @hasanyrole(['Coordinador','Jefe','Admin'])
                <td class="ui center aligned">{{ $move->user->username }}</td>
                <td class="ui center aligned">{{ $move->user->full_name }}</td>
                <td class="ui center aligned">{{ $move->user->career->acronym }}</td>
                @endhasanyrole
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
                <th class="ui center aligned">Información Adicional</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ui center aligned">{{ $move->justification['main'] }}</td>
                <td class="ui left aligned">{{ $move->justification['extra'] }}</td>
              </tr>
            </tbody>
          </table>
          @if (isset($move->answer['main']))
          <table class="ui celled compact table">
            <thead>
              <tr>
                <th class="ui center aligned five wide">Respuesta</th>
                <th class="ui center aligned">Información Adicional</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="ui center aligned">{{ $move->answer['main'] }}</td>
                <td class="ui left aligned">{{ $move->answer['extra'] }}</td>
              </tr>
            </tbody>
          </table>
          @endif
        </div>

        <div class="mobile only sixteen wide column">
          <div class="ui horizontal card">
            <div class="content">
              <div class="header">{{ $move->group->subject->short_name }} ({{ $move->group->full_key }})</div>
              <div class="meta">
                <span class="right floated">
                  {{ $move->user->username }}
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
        @include('components.back')
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/check-move.form.js')
@endpush