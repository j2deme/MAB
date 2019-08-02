(function ($) {
  'use strict';
  $.fn.charsCounter = function () {
    return this.on('focus keyup', function () {
      let maxLength = $(this).attr('maxlength');
      let currentLength = $(this).val().length;
      let chars = maxLength - currentLength;

      if (chars >= 0 && chars <= 10) {
        $(this).next('.chars').text(chars).addClass('red text');
      } else {
        $(this).next('.chars').text(chars).removeClass('red text');
      }

      $(this).next('.chars').text(chars + "/" + maxLength);
    });
  };
})(jQuery);

$(function () {
  $('.ui.checkbox').checkbox();
  $('.message .close').on('click', function () {
    $(this).closest('.message').transition('fade');
  });
});
