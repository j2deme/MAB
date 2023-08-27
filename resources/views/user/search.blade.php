@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Buscar estudiantes
          </h2>
        </header>
        <form action="{{ route('users.search') }}" class="ui equal width form @hasError" method="GET">
          {{-- @csrf --}}
          <div class="field">
            <div class="ui action input">
              <input type="text" id="q" name="q" value="{{ $q }}" autofocus autocomplete="off" />
              <button type="submit" class="ui blue labeled icon submit button">
                <i class="search icon"></i>
                Buscar
              </button>
            </div>
          </div>
          @include('components.errors-message')
        </form>

        @if (isset($users) and $users->count() > 0)
        <div class="ui divider"></div>
        <table class="ui celled striped compact table">
          <thead>
            <tr>
              <th class="ui center aligned">Nombre</th>
              <th class="ui center aligned three wide">Usuario</th>
              <th class="ui center aligned two wide">Carrera</th>
              <th class="ui center aligned one wide">Activo</th>
              <th class="ui center aligned one wide">Inscrito</th>
              @can('edit_users')
              <th class="ui center aligned two wide">
                <i class="ui cog icon"></i>
              </th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $item)
            <tr>
              <td>{{ $item->full_name }}</td>
              <td class="ui center aligned">
                <a href="{{ route('auth.logas', ['user' => $item->id]) }}" class="ui icon" data-tooltip="Iniciar como..." data-position="top center">
                  <i class="ui key icon"></i>
                </a>
                &nbsp;
                <a href="{{ route('users.show', $item) }}">{{ $item->username }}</a>
              </td>
              <td class="ui center aligned">
                {{ (!is_null($item->career)) ? $item->career->key : '-'}}</td>
              <td class="ui center aligned">
                <a href="{{ route('users.toggle', $item->id) }}">
                  <i class="ui {{ $item->is_suspended ? 'red toggle off' : 'green toggle on' }} icon"></i>
                </a>
              </td>
              <td class="ui center aligned">
                <i class="ui {{ $item->is_enrolled ? 'green check' : 'red x' }} icon"></i>
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
            @endforeach
          </tbody>
        </table>
        @else
          @if (!empty($q))
          <h3>Sin resultados</h3>
          @endif
        @endif

        @include('components.back', ['route' => route('users.index')])
      </article>
    </section>
  </div>
</div>
@endsection
