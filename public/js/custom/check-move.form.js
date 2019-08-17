$(document).ready(function () {
  $('#answer').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: true
  });

  $('#extra').charsCounter();

  $('.ui.form').form({
    fields: {
      answer: {
        rules: [{
          type: 'empty',
          prompt: 'Debe indicar una respuesta'
        }]
      },
      extra: {
        rules: [{
          type: 'maxLength[150]',
          prompt: 'La información extra no debe exceder 150 caracteres'
        }]
      }
    }
  });
});
