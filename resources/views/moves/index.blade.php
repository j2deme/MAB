@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            @role('Estudiante')
            Mis solicitudes
            @else
            Solicitudes {{ $subject->short_name or null }}{{ $subject->full_key or null }}{{ $extra or null }}
            @endrole
          </h2>
        </header>
        @role('Estudiante')
        <div class="ui right floated small buttons">
          <a href="{{ route('moves.new',['type' => 'up']) }}" class="ui blue icon labeled button">
            <i class="ui sort up icon"></i>
            Altas
          </a>
          <a href="{{ route('moves.new',['type' => 'down']) }}" class="ui red icon labeled button">
            <i class="ui sort down icon"></i>
            Bajas
          </a>
        </div>
        @endrole
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned two wide">No. Control</th>
              <th class="ui center aligned">Solicitud</th>
              <th class="ui center aligned one wide">Tipo</th>
              <th class="ui center aligned one wide">Paralelo</th>
              <th class="ui center aligned two wide">Estatus</th>
              @can('edit_moves')
              <th class="ui center aligned two wide">
                <i class="ui cog icon"></i>
              </th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @forelse ($result as $item)
            <tr>
              <td class="ui center aligned">{{ $item->user->username }}</td>
              <td>{{ $item->type }} DE {{ $item->group->subject->short_name }} ({{ $item->group->full_key }})</td>
              <td class="ui center aligned">
                <i class="ui {{ $item->type == 'ALTA' ? 'blue arrow up' : 'red arrow down' }} icon"></i>
              </td>
              <td class="ui center aligned">
                @if ($item->type == 'BAJA')
                <i class="ui grey minus icon"></i>
                @else
                <i class="ui {{ $item->is_parallel ? 'green check' : 'red times' }} icon"></i>
                @endif
              </td>
              <td class="ui center aligned">
                @include('shared._move_status', ['status' => $item->status])
              </td>
              @can('edit_moves')
              <td class="ui center aligned">
                @role('Estudiante')
                @include('moves.student_actions', ['id' => $item->id, 'move' => $item])
                @endrole
                @hasanyrole(['Coordinador','Jefe','Admin'])
                @include('moves.coordinator_actions', ['id' => $item->id])
                @endhasanyrole
              </td>
              @endcan
            </tr>
            @empty
            <tr>
              <td colspan="6">
                <div class="ui placeholder segment">
                  <div class="ui icon header">
                    <i class="inbox icon"></i>
                    @role('Estudiante')
                    Aún no has solicitado movimientos
                    @else
                    No hay movimientos solicitados
                    @endrole
                  </div>
                  @if (!is_null(Auth::user()->career))
                  @role('Estudiante')
                  <div class="inline">
                    <a href="{{ route('moves.new',['type' => 'up']) }}" class="ui blue icon labeled button">
                      <i class="ui sort up icon"></i>
                      Altas
                    </a>
                    <a href="{{ route('moves.new',['type' => 'down']) }}" class="ui red icon labeled button">
                      <i class="ui sort down icon"></i>
                      Bajas
                    </a>
                  </div>
                  @endrole
                  @endif
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
          <tfoot class="full-width">
            <tr>
              <th colspan="6">
                @include('pagination.custom', ['paginator' => $result])
              </th>
            </tr>
          </tfoot>
        </table>
        @if (isset($url))
        @include('components.back', ['route' => $url])
        @else
        @include('components.back')
        @endif
      </article>
    </section>
  </div>
</div>
@endsection
