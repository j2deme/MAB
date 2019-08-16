$(document).ready(function () {
  $('#group_id').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: true
  });
  $('#justification').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: true
  });

  $('#motivation').charsCounter();

  $('.ui.form').form({
    fields: {
      group_id: {
        rules: [{
          type: 'empty',
          prompt: 'Debes seleccionar un grupo'
        }]
      },
      justification: {
        rules: [{
          type: 'empty',
          prompt: 'Debes seleccionar un motivo'
        }]
      },
      motivation: {
        rules: [{
          type: 'maxLength[150]',
          prompt: 'La información extra no debe exceder 150 caracteres'
        }]
      }
    }
  });
});
