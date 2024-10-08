<!DOCTYPE html>
<html>
  <head>
    <title>La página ha expirado</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
      html, body {
        height: 100%;
      }

      body {
        margin: 0;
        padding: 0;
        width: 100%;
        color: #4A4A4A;
        display: table;
        font-weight: 100;
        font-family: 'Lato';
      }

      .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
      }

      .content {
        text-align: center;
        display: inline-block;
      }

      .title {
        font-size: 72px;
        margin-bottom: 40px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">
          @if ($error)
          <strong>{{ $error }}</strong>
          @endif
        </div>
      </div>
    </div>
  </body>
</html>
