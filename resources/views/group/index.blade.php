@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">Grupos</h2>
        </header>
        @can('add_groups')
        <div class="ui right floated buttons">
          <a href="{{ route('groups.new') }}" class="ui primary labeled icon button">
            <i class="ui add icon"></i> Añadir grupo
          </a>
          <a href="{{ route('groups.batch') }}" class="ui icon button">
            <i class="upload icon"></i>
          </a>
        </div>
        @endcan
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned two wide">Clave</th>
              <th class="ui center aligned">Nombre</th>
              <th class="ui center aligned two wide">Carrera</th>
              <th class="ui center aligned one wide">Semestre</th>
              <th class="ui center aligned one wide">Disponible</th>
              <th class="ui center aligned two wide">Período</th>
              @can('edit_groups')
              <th class="ui center aligned two wide">
                <i class="ui cog icon"></i>
              </th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @forelse ($result as $item)
            <tr>
              <td class="ui center aligned">{{ $item->full_key }}</td>
              <td>
                <a href="{{ route('groups.show', $item) }}">{{ $item->subject->short_name }}</a>
              </td>
              <td class="ui center aligned">{{ $item->subject->career->key }}</td>
              <td class="ui center aligned">{{ $item->subject->semester }}</td>
              <td class="ui center aligned">
                <i class="ui {{ $item->is_available ? 'green check' : 'red times' }} icon"></i>
              </td>
              <td class="ui center aligned">{{ $item->semester->short_name }}</td>
              @can('edit_groups')
              <td class="ui center aligned">
                @include('shared._actions', [
                'entity' => 'groups',
                'id' => $item->id
                ])
              </td>
              @endcan
            </tr>
            @empty
            <tr>
              <td colspan="7">
                <div class="ui placeholder segment">
                  <div class="ui icon header">
                    <i class="ui shapes icon"></i>
                    No existen grupos registrados
                  </div>
                  @role('Admin')
                  <a href="{{ route('groups.new') }}" class="ui primary icon labeled button">
                    <i class="add icon"></i>
                    Añadir grupo
                  </a>
                  @endrole
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
          <tfoot class="full-width">
            <tr>
              <th colspan="7">
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
