@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<!-- Modal -->
<div class="ui modal" id="roleModal">
  <div class="ui middle aligned center aligned padded grid">
    <div class="column">
      <h2 class="ui primary dividing header">
        Nuevo rol
      </h2>
      <form class="ui form" action="#" method="POST">
        <div class="field">
          <label for="name">Nombre</label>
          <input type="text" id="name" name="name">
        </div>
        <button type="submit" class="ui fluid primary labeled icon submit button">
          <i class="save icon"></i>
          Guardar
        </button>
      </form>
    </div>
  </div>
</div>

<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="fourteen wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">Roles</h2>
        </header>
        @can('add_roles')
        <a href="#" class="ui right floated primary labeled icon button" data-toggle="modal" data-target="#roleModal">
          <i class="ui plus icon"></i> Nuevo rol</a>
        @endcan
        <br><br>
        <div class="ui styled fluid accordion">
          @forelse ($roles as $role)
          @if($role->name === 'Admin')
          @include('shared._permissions', [
          'title' => 'Permisos de '. $role->name,
          'options' => 'disabled' ])
          @else
          @include('shared._permissions', [
          'title' => 'Permisos de '. $role->name,
          'model' => $role ])
          @endif

          @empty
          <p>No existen roles definidos, ejecute <code>php artisan db:seed</code> para ingresar datos base de la
            aplicación.</p>
          @endforelse
        </div>
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/roles.management.js')
@endpush
