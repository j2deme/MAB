@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">Usuarios</h2>
        </header>
        @role('Admin')
        <a href="{{ route('users.new') }}" class="ui right floated primary labeled icon button">
          <i class="ui add icon"></i> Añadir usuario
        </a>
        <a href="{{ route('users.cloneStudents') }}" class="ui right floated labeled icon button">
          <i class="ui clone outline icon"></i> Clonar estudiantes
        </a>
        @endrole
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned one wide">ID</th>
              <th class="ui center aligned">Nombre</th>
              <th class="ui center aligned three wide">Usuario</th>
              <th class="ui center aligned two wide">Rol</th>
              <th class="ui center aligned two wide">Carrera</th>
              <th class="ui center aligned one wide">Activo</th>
              @can('edit_users')
              <th class="ui center aligned two wide">
                <i class="ui cog icon"></i>
              </th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $item)
            <tr>
              <td class="ui center aligned">{{ $item->id }}</td>
              <td>{{ $item->full_name }}</td>
              <td>
                <a href="{{ route('users.show', $item) }}">{{ $item->username }}</a>
              </td>
              <td>{{ (isset($item->roles[0])) ? $item->roles[0]->name : 'NA' }}</td>
              <td class="ui center aligned">
                {{ (!is_null($item->career)) ? $item->career->key : '-'}}</td>
              <td class="ui center aligned">
                <a href="{{ route('users.toggle', $item->id) }}">
                  <i class="ui {{ $item->is_suspended ? 'red toggle off' : 'green toggle on' }} icon"></i>
                </a>
              </td>
              @can('edit_users')
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
              <td colspan="7">
                <div class="ui placeholder segment">
                  <div class="ui icon header">
                    <i class="users icon"></i>
                    No existen usuarios registrados
                  </div>
                  @role('Admin')
                  <a href="{{ route('users.new') }}" class="ui primary icon labeled button">
                    <i class="add icon"></i>
                    Añadir usuario
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
                @include('pagination.custom', ['paginator' => $users])
              </th>
            </tr>
          </tfoot>
        </table>
      </article>
    </section>
  </div>
</div>
@endsection
