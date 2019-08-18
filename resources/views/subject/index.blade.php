@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">Materias</h2>
        </header>
        @can('add_subjects')
        <div class="ui right floated buttons">
          <a href="{{ route('subjects.new') }}" class="ui primary labeled icon button">
            <i class="ui add icon"></i> Añadir materia
          </a>
          <a href="{{ route('subjects.batch') }}" class="ui icon button">
            <i class="upload icon"></i>
          </a>
        </div>
        @endcan
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned one wide">Clave</th>
              <th class="ui center aligned">Nombre</th>
              <th class="ui center aligned two wide">Carrera</th>
              <th class="ui center aligned one wide">Semestre</th>
              <th class="ui center aligned one wide">SATCA</th>
              <th class="ui center aligned one wide">Activa</th>
              @can('edit_subjects')
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
              <td>
                <a href="{{ route('subjects.show', $item) }}">{{ $item->long_name }}</a>
              </td>
              <td class="ui center aligned">{{ $item->career->key }}</td>
              <td class="ui center aligned">{{ $item->semester }}</td>
              <td class="ui center aligned">{{ $item->satca }}</td>
              <td class="ui center aligned">
                <a href="{{ route('subjects.toggle', $item) }}">
                  <i class="ui {{ $item->is_active ? 'green check' : 'red times' }} icon"></i>
                </a>
              </td>
              @can('edit_subjects')
              <td class="ui center aligned">
                @include('shared._actions', [
                'entity' => 'subjects',
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
                    <i class="ui project diagram icon"></i>
                    No existen materias registradas
                  </div>
                  @role('Admin')
                  <a href="{{ route('subjects.new') }}" class="ui primary icon labeled button">
                    <i class="add icon"></i>
                    Añadir materia
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
