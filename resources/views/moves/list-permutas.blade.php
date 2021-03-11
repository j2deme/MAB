@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            {{ $title or "Solicitudes por estudiante" }}
          </h2>
        </header>

        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned two wide">No. Control</th>
              <th class="ui center aligned one wide">Grupo Base</th>
              <th class="ui center aligned one wide">Grupo Destino</th>
              <th class="ui center aligned one wide">Candidato</th>
              <th class="ui center aligned two wide">Estatus</th>
              @can('edit_moves')
              <th class="ui center aligned two wide">
                <i class="ui cog icon"></i>
              </th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @forelse ($permutas as $item)
            <tr>
              <td class="ui center aligned">{{ $item->user->username }}</td>
              <td class="ui center aligned">{{ $item->base_semester }} {{ $item->base_group }}</td>
              <td class="ui center aligned">{{ $item->base_semester }} {{ $item->switch_group }}</td>
              <td class="ui center aligned">{{ $item->candidate }}</td>
              <td class="ui center aligned">
                @include('shared._permuta_status', ['status' => $item->status])
              </td>
              @can('edit_moves')
              <td class="ui center aligned">
                @hasanyrole(['Jefe','Admin'])
                <div class="ui icon buttons">
                  <a href="{{ route('permutas.edit', ['permuta' => $item->id])  }}" class="ui blue icon button" data-content="Revisar permuta">
                    <i class="ui eye icon"></i>
                  </a>

                  {{-- <form action="{{ route('moves.cancel', ['move' => $item->id]) }}" method="post"
                    onsubmit="return confirm('¿Está seguro de rechazar la solicitud?\nEsta acción no es reversible');"
                    style="display:inline;">
                    @csrf
                    @method('delete')
                    <button type="submit" class="ui red icon button" data-content="Rechazar permuta">
                      <i class="ui times icon"></i>
                    </button>
                  </form> --}}
                </div>
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
                    No hay cambios de grupo solicitados
                  </div>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
          <tfoot class="full-width">
            <tr>
              <th colspan="6">
                @include('pagination.custom', ['paginator' => $permutas])
              </th>
            </tr>
          </tfoot>
        </table>

        @include('components.back', ['route' => route('home.index')])
      </article>
    </section>
  </div>
</div>
@endsection
