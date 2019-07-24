$(document).ready(function () {
  $('.ui.form').form({
    fields: {
      email: {
        identifier: 'email',
        rules: [{
            type: 'empty',
            prompt: 'Ingresa tu correo electrónico'
          },
          {
            type: 'email',
            prompt: 'Ingresa un correo electrónico válido'
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
