<div class="ui icon small buttons">
  <a href="{{ route('moves.edit', ['move' => $id])  }}" class="ui blue icon button" data-content="Atender solicitud">
    <i class="ui eye icon"></i>
  </a>

  {{-- <form action="{{ route('moves.delete', ['move' => $id]) }}" method="post"
  onsubmit="return confirm('¿Está seguro de rechazar la solicitud?\nEsta acción no es reversible');"
  style="display:inline;">
  @csrf
  @method('delete')
  <button type="submit" class="ui red icon button" data-content="Rechazar solicitud">
    <i class="ui times icon"></i>
  </button>
  </form> --}}
</div>
