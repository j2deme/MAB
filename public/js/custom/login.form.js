$(document).ready(function () {
  $('.ui.form').form({
    fields: {
      username: {
        identifier: 'username',
        rules: [{
            type: 'empty',
            prompt: 'Ingresa tu usuario / no. de control'
          }
        ]
      },
      password: {
        identifier: 'password',
        rules: [{
          type: 'empty',
          prompt: 'Ingresa tu contraseña'
        }]
      }
    }
  });
});
