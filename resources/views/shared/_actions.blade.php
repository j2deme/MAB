<div class="ui icon buttons">
  @can('edit_'.$entity)
  <a href="{{ route($entity.'.edit', [str_singular($entity) => $id])  }}" class="ui blue icon button">
    <i class="ui edit icon"></i>
  </a>
  @endcan

  @can('delete_'.$entity)
  <form action="{{ route($entity.'.delete', ['user' => $id]) }}" method="post"
    onsubmit="return confirm('¿Está seguro de eliminar el registro?');" style="display:inline;">
    @method('delete')
    <button type="submit" class="ui red icon button">
      <i class="ui trash icon"></i>
    </button>
  </form>
  @endcan
</div>
