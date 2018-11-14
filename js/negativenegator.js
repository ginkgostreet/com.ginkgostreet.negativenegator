CRM.$(function($) {

  $('.no-negative').blur(

    function(evt) {
      var priceField = $(evt.target);
      var price = parseFloat(priceField.val().replace(',', '').replace('$', ''));

      if (Number.isFinite(price) && price < 0) {

        // only display the error message once
        if ($(priceField.prop('parentNode')).find('.crm-error.no-negative').length == 0) {
          var space = $('<span>')
            .text(' ')
            .insertAfter(priceField);
          $('<span>')
            .addClass('crm-error no-negative')
            .text(priceField.attr('data-no-negative') + ' cannot be negative.')
            .insertAfter(space);
        }
      }
      else {
        $(priceField.prop('parentNode')).find('.crm-error.no-negative').remove();
      }
    }

  );

});
