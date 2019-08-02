@extends('layouts.app')

@section('content')
@include('layouts.navbar')
<div class="ui stackable centered grid">
  <div class="ui stretched row">
    <section class="ten wide column">
      <article class="ui attached segment">
        <header>
          <h2 class="ui primary dividing header">
            Nueva solicitud de {{ $type == 'up' ? 'Alta' : 'Baja'  }}
          </h2>
        </header>
        @if ($type == 'up')
        @include('moves.up-form')
        @endif
      </article>
    </section>
  </div>
</div>
@endsection

@push('scripts')
@js('custom/new-move.form.js')
@endpush
