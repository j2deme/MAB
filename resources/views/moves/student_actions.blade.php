<div class="ui icon small buttons">
  {{-- <a href="{{ route('moves.edit', ['move' => $id])  }}" class="ui blue icon button">
  <i class="ui edit icon"></i>
  </a> --}}

  <form action="{{ route('moves.delete', ['move' => $id]) }}" method="post"
    onsubmit="return confirm('¿Está seguro de cancelar la solicitud?\nEsta acción no es reversible');"
    style="display:inline;">
    @csrf
    @method('delete')
    <button type="submit" class="ui red icon button">
      <i class="ui times circle icon"></i> Cancelar
    </button>
  </form>
</div>
