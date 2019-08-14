{{-- <div class="segment">
  <div class="panel-heading" role="tab" id="{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
<h4 class="panel-title">
  <a role="button" data-toggle="collapse" data-parent="#accordion"
    href="#dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
    {{ $title or 'Override Permissions' }} {!! isset($user) ? '<span class="text-danger">(' .
      $user->getDirectPermissions()->count() . ')</span>' : '' !!}
  </a>
</h4>
</div>
<div id="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}"
  class="panel-collapse collapse {{ $closed or 'in' }}" role="tabpanel"
  aria-labelledby="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
  <div class="panel-body">
    <div class="row">
      @foreach($permissions as $perm)
      <php $per_found=null; if( isset($role) ) { $per_found=$role->hasPermissionTo($perm->name);
        }

        if( isset($user)) {
        $per_found = $user->hasDirectPermission($perm->name);
        }
        ?>
        <div class="col-md-3">
          <div class="inline field">
            <div class="ui checkbox">
              <input type="checkbox" tabindex="0" class="hidden" id="permissions[]" name="{{ $perm->name }}">
              <label class="{{ str_contains($perm->name, 'delete') ? 'ui red text' : '' }}">{{ $perm->name }}</label>
            </div>
          </div>
        </div>
        @endforeach
    </div>
  </div>
</div>
</div> --}}


<div class="title">
  <i class="dropdown icon"></i>
  {{ $title or 'Override Permissions' }} <span class="ui blue text">{{ isset($model) ? '(' .
      $model->permissions()->count() . ')' : '' }}</span>
</div>
<div class="content">
  <form action="{{ route('roles.update', $role->id) }}" method="post" class="ui form">
    @csrf
    @method('PUT')
    <div class="ui grid">
      @foreach($permissions as $perm)
      <div class="ui three wide column small field">
        <?php
      $perm_found = null;
      if( isset($role) ) {
        $perm_found = $role->hasPermissionTo($perm->name);
      }
      /*if( isset($user)) {
        $perm_found = $user->hasPermissionTo($perm->name);
      }*/
      ?>
        <div class="ui checkbox">
          <input type="checkbox" tabindex="0" class="hidden" name="permissions[]" id="{{ $perm->name }}"
            value="{{ $perm->name }}" {{ ($perm_found) ? 'checked' : null }} {{ isset($options) ? $options : null }}>
          <label>
            <span class="{{ str_contains($perm->name, 'delete') ? 'ui red text' : '' }}">{{ $perm->name }}</span>
          </label>
        </div>
      </div>
      @endforeach
    </div>
    @can('edit_roles')
    <button type="submit" class="ui fluid primary labeled icon {{ isset($options) ? $options : null }} button">
      <i class="save icon"></i>
      Guardar
    </button>
    @endcan
  </form>
</div>
