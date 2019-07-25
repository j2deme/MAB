$(document).ready(function () {
  $('.ui.form').form({
    fields: {
      name: {
        rules: [{
          type: 'empty',
          prompt: 'Ingresa tu nombre o nombres'
        }]
      },
      last_name: {
        identifier: 'last-name',
        rules: [{
          type: 'empty',
          prompt: 'Ingresa tus apellidos'
        }]
      },
      password: {
        identifier: 'password',
        rules: [{
          type: 'empty',
          prompt: 'Ingresa tu contraseña'
        }]
      },
      password_confirm: {
        identifier: 'password-confirm',
        rules: [{
            type: 'empty',
            prompt: 'Se requiere confirmación de contraseña'
          },
          {
            type: 'match[password]',
            prompt: 'Las contraseñas no coinciden'
          }
        ]
      },
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
      username: {
        identifier: 'username',
        rules: [{
            type: 'empty',
            prompt: 'Ingresa tu número de control'
          },
          {
            type: 'minLength[8]',
            prompt: 'El número de control se compone de 10 dígitos'
          }
        ]
      },
    }
  });
});
