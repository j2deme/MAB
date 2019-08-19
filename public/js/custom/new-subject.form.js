$(document).ready(function () {
  $('.ui.dropdown').dropdown();

  $('.ui.form').form({
    fields: {
      key: {
        rules: [{
          type: 'empty',
          prompt: 'Debes especificar una clave para la materia'
        }]
      },
      short_name: {
        rules: [{
          type: 'empty',
          prompt: 'Debes especificar un nombre corto para la materia'
        }]
      },
      long_name: {
        rules: [{
          type: 'empty',
          prompt: 'Debes especificar un nombre descriptivo para la materia'
        }]
      },
      semester: {
        rules: [{
          type: 'empty',
          prompt: 'Debes especificar el semestre donde se impartirá la materia'
        }]
      },
      career_id: {
        rules: [{
          type: 'empty',
          prompt: 'Debes especificar la carrera donde se impartirá la materia'
        }]
      },
      ht: {
        rules: [{
          type: 'empty',
          prompt: 'Debes especificar las horas teóricas de la materia'
        }]
      },
      hp: {
        rules: [{
          type: 'empty',
          prompt: 'Debes especificar las horas prácticas de la materia'
        }]
      },
      cr: {
        rules: [{
          type: 'empty',
          prompt: 'Debes especificar la cantidad de créditos de la materia'
        }]
      }
    }
  });
});
