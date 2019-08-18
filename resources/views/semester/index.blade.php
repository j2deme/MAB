@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">Semestres</h2>
        </header>
        @can('add_semesters')
        <a href="{{ route('semesters.new') }}" class="ui right floated primary labeled icon button">
          <i class="ui add icon"></i> Añadir semestre
        </a>
        @endcan
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned one wide">Clave</th>
              <th class="ui center aligned">Nombre</th>
              <th class="ui center aligned three wide">Altas</th>
              <th class="ui center aligned three wide">Bajas</th>
              <th class="ui center aligned one wide">Activo</th>
              @can('edit_semesters')
              <th class="ui center aligned two wide">
                <i class="ui cog icon"></i>
              </th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @forelse ($result as $item)
            <tr>
              <td class="ui center aligned">{{ $item->key }}</td>
              <td class="ui center aligned">
                <a href="{{ route('semesters.show', $item) }}">{{ $item->long_name }}</a>
              </td>
              <td class="ui center aligned">{{ $item->up_range }}</td>
              <td class="ui center aligned">{{ $item->down_range }}</td>
              <td class="ui center aligned">
                <a href="{{ route('semesters.toggle', $item) }}">
                  <i class="ui {{ $item->is_active ? 'green check' : 'red times' }} icon"></i>
                </a>
              </td>
              @can('edit_semesters')
              <td class="ui center aligned">
                @include('shared._actions', [
                'entity' => 'semesters',
                'id' => $item->id
                ])
              </td>
              @endcan
            </tr>
            @empty
            <tr>
              <td colspan="6">
                <div class="ui placeholder segment">
                  <div class="ui icon header">
                    <i class="calendar alternate outline icon"></i>
                    No existen semestres registrados
                  </div>
                  @role('Admin')
                  <a href="{{ route('semesters.new') }}" class="ui primary icon labeled button">
                    <i class="add icon"></i>
                    Añadir semestre
                  </a>
                  @endrole
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
