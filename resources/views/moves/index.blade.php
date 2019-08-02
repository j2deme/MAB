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
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned one wide">ID</th>
              <th class="ui center aligned">Solicitud</th>
              <th class="ui center aligned four wide">Tipo</th>
              <th class="ui center aligned one wide">Estatus</th>
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
              <td>{{ $item->group->subject->short_name . $item->group->name }}</td>
              <td>
                {{ $item->type }}
              </td>
              <td class="ui center aligned">
                {{ $item->status }}
              </td>
              @can('edit_moves')
              <td class="ui center aligned">
                @include('shared._actions', [
                'entity' => 'users',
                'id' => $item->id
                ])
              </td>
              @endcan
            </tr>
            @empty
            <tr>
              <td colspan="5">
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
              <th colspan="5">
                @unless(count($result) > 0)
                {{-- @include('pagination.custom', ['paginator' => $result]) --}}
                @endunless
              </th>
            </tr>
          </tfoot>
        </table>
      </article>
    </section>
  </div>
</div>
@endsection
