<div class="ui icon buttons">
  <a href="{{ route('moves.show', ['move' => $id])  }}" class="ui tertiary blue icon button" data-content="Revisar solicitud">
    <i class="ui eye icon"></i>
  </a>
  <a href="{{ route('moves.edit', ['move' => $id])  }}" class="ui tertiary green icon button" data-content="Atender solicitud">
    <i class="ui edit icon"></i>
  </a>
</div>
