$(document).ready(function () {
  /* CALENDAR INITIALIZATION */
  $("#begin_up").calendar({
    type: "date",
    endCalendar: $("#end_up"),
    text: calendarTextOptions,
    //disabledDaysOfWeek: [0, 6], // Disable weekends
    selectAdjacentDays: true,
    monthFirst: false,
    formatter: {
      date: function (date, settings) {
        if (!date) return "";
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        return year + "-" + month + "-" + day;
      },
    },
  });
  $("#end_up").calendar({
    type: "date",
    startCalendar: $("#begin_up"),
    text: calendarTextOptions,
    //disabledDaysOfWeek: [0, 6], // Disable weekends
    selectAdjacentDays: true,
    monthFirst: false,
    formatter: {
      date: function (date, settings) {
        if (!date) return "";
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        return year + "-" + month + "-" + day;
      },
    },
  });
  $("#begin_down").calendar({
    type: "date",
    endCalendar: $("#end_down"),
    text: calendarTextOptions,
    //disabledDaysOfWeek: [0, 6], // Disable weekends
    selectAdjacentDays: true,
    monthFirst: false,
    formatter: {
      date: function (date, settings) {
        if (!date) return "";
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        return year + "-" + month + "-" + day;
      },
    },
  });
  $("#end_down").calendar({
    type: "date",
    startCalendar: $("#begin_down"),
    text: calendarTextOptions,
    //disabledDaysOfWeek: [0, 6], // Disable weekends
    selectAdjacentDays: true,
    monthFirst: false,
    formatter: {
      date: function (date, settings) {
        if (!date) return "";
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        return year + "-" + month + "-" + day;
      },
    },
  });

  $(".ui.form").form({
    fields: {
      key: {
        rules: [
          {
            type: "empty",
            prompt: "Debes especificar una clave para el semestre",
          },
        ],
      },
      short_name: {
        rules: [
          {
            type: "empty",
            prompt: "Debes especificar un nombre corto para el semestre",
          },
        ],
      },
      long_name: {
        rules: [
          {
            type: "empty",
            prompt: "Debes especificar un nombre descriptivo para el semestre",
          },
        ],
      },
      begin_up: {
        rules: [
          {
            type: "empty",
            prompt:
              "Debes especificar una fecha de inicio para el período de altas",
          },
        ],
      },
      end_up: {
        rules: [
          {
            type: "empty",
            prompt:
              "Debes especificar una fecha de fin para el período de altas",
          },
        ],
      },
      begin_down: {
        rules: [
          {
            type: "empty",
            prompt:
              "Debes especificar una fecha de inicio para el período de bajas",
          },
        ],
      },
      end_down: {
        rules: [
          {
            type: "empty",
            prompt:
              "Debes especificar una fecha de fin para el período de bajas",
          },
        ],
      },
    },
  });
});
