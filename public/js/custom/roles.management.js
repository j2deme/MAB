$(document).ready(function () {
  $('.ui.accordion').accordion({
    exclusive: true
  });
  $('a[data-target="#roleModal"]').click(function (e) {
    e.preventDefault();
    $('#name').val('');
    $('#roleModal').modal('show');
  });
  $('#roleModal').modal({
    closable: true
  });
});
