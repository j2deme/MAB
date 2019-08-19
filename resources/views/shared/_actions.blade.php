<div class="ui icon small buttons">
  @can('edit_'.$entity)
  <a href="{{ route($entity.'.edit', [str_singular($entity) => $id])  }}" class="ui blue icon button"
    data-content="Editar registro">
    <i class="ui edit icon"></i>
  </a>
  @endcan

  @can('delete_'.$entity)
  <form action="{{ route($entity.'.delete', [str_singular($entity) => $id]) }}" method="post"
    onsubmit="return confirm('¿Está seguro de eliminar el registro?\nEsta acción no es reversible');"
    style="display:inline;">
    @csrf
    @method('delete')
    <button type="submit" class="ui red icon button" data-content="Eliminar registro">
      <i class="ui trash alternate icon"></i>
    </button>
  </form>
  @endcan
</div>
