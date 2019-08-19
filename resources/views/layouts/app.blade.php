<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="language" content="ES">
  <meta name="application-name" content="MAB">
  <!-- Theme Color for Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#2185D0">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="google" content="notranslate">
  <meta name="author" content="Jaime Jesús Delgado Meraz, jesus.delgado@tecvalles.mx">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MAB</title>
  @js('jquery.min.js')
  @css('semantic.css')
  @css('responsive-ui.css')
  @css('app.css')
  @yield('css')
</head>

<body class="ui grid container">
  <div class="row">
    <div class="column padding-reset">
      @yield('content')
    </div>
  </div>
  @js('semantic.min.js')
  <script>
    var config = {
        routes: [
          {
            root: "{{ route('root') }}"
          }
        ]
      };
  </script>
  @js('app.js')
  @include('flash::message')
  @stack('scripts')
</body>

</html>
