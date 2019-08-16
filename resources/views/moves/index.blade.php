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
            Solicitudes
            @endrole
          </h2>
        </header>
        @can('add_moves')
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
        @endcan
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned one wide">ID</th>
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
              <td class="ui center aligned">{{ $item->id }}</td>
              <td>{{ $item->type }} DE {{ $item->group->subject->short_name }} ({{ $item->group->full_key }})</td>
              <td class="ui center aligned">
                <i class="ui large {{ $item->type == 'ALTA' ? 'blue arrow up' : 'red arrow down' }} icon"></i>
              </td>
              <td class="ui center aligned">
                <i class="ui large {{ $item->is_parallel ? 'green check' : 'red times' }} icon"></i>
              </td>
              <td class="ui center aligned">
                @include('shared._move_status', ['status' => $item->status])
              </td>
              @can('edit_moves')
              <td class="ui center aligned">
                @role('Estudiante')
                @include('moves.student_actions', ['id' => $item->id])
                @endrole
                @hasanyrole(['Coordinador','Jefe'])
                @include('shared._actions', [
                'entity' => 'users',
                'id' => $item->id
                ])
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
      </article>
    </section>
  </div>
</div>
@endsection
