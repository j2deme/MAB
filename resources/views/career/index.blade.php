@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">Carreras</h2>
        </header>
        @can('add_careers')
        <a href="{{ route('semesters.new') }}" class="ui right floated primary labeled icon button">
          <i class="ui add icon"></i> Añadir semestre
        </a>
        @endcan
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned one wide">ID</th>
              <th class="ui center aligned two wide">Clave</th>
              <th class="ui center aligned">Nombre</th>
              @can('edit_careers')
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
              <td class="ui center aligned">{{ $item->key }}</td>
              <td>
                <a href="{{ route('careers.show', $item) }}">{{ $item->name }}</a>
              </td>
              @can('edit_careers')
              <td class="ui center aligned">
                @include('shared._actions', [
                'entity' => 'careers',
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
                    <i class="inbox icon"></i>
                    No existen carreras registradas
                  </div>
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
