<div class="ui icon small buttons">
  <a href="{{ route('moves.show', ['move' => $id])  }}" class="ui blue icon button" data-content="Ver solicitud">
    <i class="ui eye icon"></i>
  </a>

  @if ($move->status == 0)
  <form action="{{ route('moves.delete', ['move' => $id]) }}" method="post"
    onsubmit="return confirm('¿Está seguro de cancelar la solicitud?\nEsta acción no es reversible');"
    style="display:inline;">
    @csrf
    @method('delete')
    <button type="submit" class="ui red icon button" data-content="Cancelar solicitud">
      <i class="ui times circle icon"></i>
    </button>
  </form>
  @endif
</div>
