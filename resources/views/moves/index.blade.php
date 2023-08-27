@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<!-- DATA 
Path: {{ Request::path() }}
-->
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
        <span class="ui sub header">
          @if (isset($ups))
            {{ $ups }} <i class="ui blue up arrow icon"></i> 
          @endif
          &emsp;
          @if (isset($downs))
            {{ $downs }} <i class="ui red down arrow icon"></i> 
          @endif
        </span>

        <div class="ui right floated small buttons">
        @role('Estudiante')
          <a href="{{ route('moves.new',['type' => 'up']) }}" class="ui blue icon labeled button">
            <i class="ui sort up icon"></i>
            Altas
          </a>
          <a href="{{ route('moves.new',['type' => 'down']) }}" class="ui red icon labeled button">
            <i class="ui sort down icon"></i>
            Bajas
          </a>
        @endrole
        @hasanyrole(['Jefe','Admin','Coordinador'])
        @if(isset($search) and $search == true)
        <form action="{{ route('moves.listAttended') }}" method="GET" class="ui horizontal form">
          <div class="ui icon input">
            <input type="text" name="search" placeholder="Buscar..." autocomplete="off">
            <i class="search icon"></i>
          </div>
        </form>
        @endif
        @include('components.list-all')
        @if (isset($user) and !$user->is_enrolled)
          <a href="{{ route('users.singleActivate', ['key'=> $user->username]) }}" class="ui green icon labeled button">
            <i class="ui sort down icon"></i>
            Inscribir
          </a>
        @endif
        @endhasanyrole
        </div>

        <div class="tablet only computer only large screen only widescreen only sixteen wide column">
          <table class="ui celled striped compact table">
            <thead>
              <tr>
                <th class="ui center aligned two wide">
                  @role('Estudiante')
                  #
                  @else
                    @if(isset($ups))
                    <a href="?sort=student">No. Control</a>
                    @else
                    No. Control
                    @endif
                  @endrole
                </th>
                <th class="ui center aligned">Solicitud</th>
                <th class="ui center aligned one wide">Semestre</th>
                @if (isset($ups))
                  <th class="ui center aligned one wide"><a href="?sort=group">Grupo</a></th>
                  <th class="ui center aligned two wide"><a href="?sort=type">Tipo</a></th>
                  @hasanyrole(['Admin','Jefe'])
                  <th class="ui center aligned one wide">Paralelo</th>
                  @endhasanyrole
                  <th class="ui center aligned two wide"><a href="?sort=status">Estatus</a></th>
                @else
                  <th class="ui center aligned one wide">Grupo</th>
                  <th class="ui center aligned two wide">Tipo</th>
                  @hasanyrole(['Admin','Jefe'])
                  <th class="ui center aligned one wide">Paralelo</th>
                  @endhasanyrole
                  <th class="ui center aligned two wide">Estatus</th>
                @endif
                @can('edit_moves')
                <th class="ui center aligned two wide">
                  <i class="ui cog icon"></i>
                </th>
                @endcan
              </tr>
            </thead>
            <tbody>
              @forelse ($result as $key => $item)
              <tr>
                <td class="ui center aligned">
                @role('Estudiante')
                {{ $key + 1 }}
                @else
                {{ $item->user->username }}
                @endrole
                </td>
                <td>{{ $item->type }} DE {{ $item->group->subject->short_name }} ({{ $item->group->full_key }})</td>
                <td class="ui center aligned">
                  <small>{{ $item->type }}</small> <i class="ui {{ $item->type == 'ALTA' ? 'blue arrow up' : 'red arrow down' }} icon"></i>
                </td>
                <td class="ui center aligned">
                  @if ($item->is_parallel)
                  <a class="ui blue circular label">P</a>
                  @else
                  <i class="ui grey minus icon"></i>
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
                <td colspan="8">
                  <div class="ui placeholder segment">
                    <div class="ui icon header">
                      <i class="inbox icon"></i>
                      @role('Estudiante')
                      Aún no has solicitado movimientos
                      @else
                      No hay movimientos solicitados
                      @endrole
                    </div>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
            <tfoot class="full-width">
              <tr>
                <th colspan="8">
                  @if (!ends_with(Request::path(), "/all"))
                    @include('pagination.custom', ['paginator' => $result])
                  @endif
                </th>
              </tr>
            </tfoot>
          </table>
        </div>

        <div class="mobile only sixteen wide column">
          @forelse ($result as $item)
          <div class="ui card">
            <div class="content">
              <div class="header">{{ $item->group->subject->short_name }} ({{ $item->group->full_key }})</div>
              <div class="meta">
                <span class="right floated">
                  {{ $item->user->username }}
                </span>
                <span class="category"><small>{{ $item->type }}</small> <i class="ui {{ $item->type == 'ALTA' ? 'blue arrow up' : 'red arrow down' }} icon"></i></span>
              </div>
            </div>
            <div class="extra content">
              <div class="left floated">
                @if ($item->is_parallel)
                  <a class="ui blue label">PARALELO</a>
                @endif
              </div>
              <div class="right floated">
                @include('shared._move_status', ['status' => $item->status])
              </div>
            </div>
            @can('edit_moves')
            @role('Estudiante')
            @include('moves.student_actions', ['id' => $item->id, 'move' => $item])
            @endrole
            @hasanyrole(['Coordinador','Jefe','Admin'])
            @include('moves.coordinator_actions', ['id' => $item->id])
            @endhasanyrole
            @endcan
          </div>

          @empty
          <div class="segment">No hay movimientos solicitados</div>
          @endforelse
          @if (!ends_with(Request::path(), "/all"))
            @include('pagination.custom', ['paginator' => $result])
          @endif
        </div>
        <div class="ui row sixteen wide column">
          @if (isset($url))
            @include('components.back', ['route' => $url])
          @else
            @include('components.back')
          @endif
        </div>
      </article>
    </section>
  </div>
</div>
@endsection
