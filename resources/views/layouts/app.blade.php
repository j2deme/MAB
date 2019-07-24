<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MAB</title>
  <link rel="stylesheet" href="{{ asset('css/semantic.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @yield('css')
</head>

<body class="ui container">
  @yield('content')

  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/semantic.min.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>

</html>
