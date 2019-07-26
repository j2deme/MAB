<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MAB</title>
  @css('semantic.css')
  @css('app.css')
  @yield('css')
</head>

<body class="ui container">
  @yield('content')

  @js('jquery.min.js')
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
  @stack('scripts')
</body>

</html>
