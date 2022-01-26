@if (!str_is("moves/by/student/*", Request::path()))
  @if (!ends_with(Request::path(), "/all"))
  <a href="{{ url(Request::path()."/all") }}" class="ui primary icon labeled button">
    <i class="ui list icon"></i>
    Lista
  </a>
  @endif
@endif