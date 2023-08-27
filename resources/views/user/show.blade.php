@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            {{ $user->name }} {{ $user->last_name }}
          </h2>
        </header>

        <div class="ui equal width grid">
          <div class="column">
              <h3 class="header">No. de Control</h3>
              <p>{{ $user->username }}</p>
          </div>
          <div class="column">
            <div class="content">
              <h3 class="header">Carrera</h3>
              <div class="meta"></div>
              <div class="description">
                <p>{{ $user->career->name }}</p>
              </div>
              <div class="extra"></div>
            </div>
          </div>
          <div class="column">
            <div class="content">
              <h3 class="header">Inscrito</h3>
              <div class="meta"></div>
              <div class="description">
                <p>{{ ($user->is_enrolled) ? 'SI' : 'NO' }}</p>
              </div>
              <div class="extra"></div>
            </div>
          </div>
        </div>

        <div class="ui hidden divider"></div>

        <header>
          <h3 class="ui primary dividing header">
            Historial de movimientos
          </h3>
        </header>

        <table class="ui celled table">
          <thead>
            <tr>
              <th class="ui center aligned">Materia</th>
              <th class="ui center aligned">Tipo</th>
              <th class="ui center aligned">Estatus</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($log as $item)
            <tr class="center aligned">
              <td colspan="3">
                <h3 class="ui center aligned header">
                  {{ $item['semester']->short_name }}
                </h3>
              </td>
            </tr>
              @foreach ($item['moves'] as $move)
              <tr>
                <td>{{ $move->group->subject->short_name }} ({{ $move->group->key }})</td>
                <td class="center aligned">
                  <i class="ui {{ $move->type == 'ALTA' ? 'blue arrow up' : 'red arrow down' }} icon"></i>
                  @if ($move->is_parallel)
                  <span class="ui blue label">P</span>
                  @endif
                </td>
                <td class="center aligned">
                  @include('shared._move_status', ['status' => $move->status])
                </td>
              </tr>
              @endforeach
            @empty
            <tr>
              <td colspan="3">
                <div class="ui placeholder segment">
                  <div class="ui icon header">
                    <i class="inbox icon"></i>
                    No hay movimientos registrados
                  </div>
                </div>
              </td>
            @endforelse
          </tbody>
        </table>


        @include('components.back')
      </article>
    </section>
  </div>
</div>
@endsection