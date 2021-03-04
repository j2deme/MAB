$(document).ready(function () {
  let _form = $('#switchGroupForm');
  if (_form.hasClass('closed')) {
    _form.dimmer({
      closable: false
    }).dimmer('show');
  }
  $('#base_semester').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: true
  });
  $('#base_group').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: true
  });
  $('#switch_group').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: true
  });

  $('.ui.form').form({
    fields: {
      base_semester: {
        rules: [{
          type: 'empty',
          prompt: 'Debes seleccionar el semestre de tu bloque base'
        }]
      },
      base_group: {
        rules: [{
          type: 'empty',
          prompt: 'Debes seleccionar el grupo de tu bloque base'
        }]
      },
      switch_group: {
        rules: [{
          type: 'empty',
          prompt: 'Debes seleccionar un grupo para cambiar'
        }]
      },
    }
  });
});
