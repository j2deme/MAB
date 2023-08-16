$(document).ready(function () {
  $("#subject_id").dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: true,
  });
  $("#semester_id").dropdown({
    ignoreDiacritics: true,
    fullTextSearch: true,
  });

  $(".ui.form").form({
    fields: {
      key: {
        rules: [
          {
            type: "empty",
            prompt: "Debes especificar una clave para el grupo",
          },
        ],
      },
      semester_id: {
        rules: [
          {
            type: "empty",
            prompt: "Debes especificar un período para el grupo",
          },
        ],
      },
      subject_id: {
        rules: [
          {
            type: "empty",
            prompt: "Debes especificar una materia para el grupo",
          },
        ],
      },
    },
  });
});
