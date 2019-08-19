$(document).ready(function () {
  $('#roles').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: true
  });
  $('.ui.form').form({
    fields: {
      name: {
        rules: [{
          type: 'empty',
          prompt: 'Especifique el nombre o nombres'
        }]
      },
      last_name: {
        rules: [{
          type: 'empty',
          prompt: 'Especifique los apellidos'
        }]
      },
      password: {
        identifier: 'password',
        rules: [{
          type: 'empty',
          prompt: 'Especifique la contraseña'
        }]
      },
      password_confirmation: {
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
        rules: [{
            type: 'empty',
            prompt: 'Especifique el correo electrónico'
          },
          {
            type: 'email',
            prompt: 'Especifique un correo electrónico válido'
          }
        ]
      },
      username: {
        rules: [{
          type: 'empty',
          prompt: 'Especifique un nombre de usuario'
        }]
      },
    }
  });
});
