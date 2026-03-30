"use strict";

$(document).ready(function () {
  $('#stripe-element').addClass('d-none');
})




/**
 * show or hide stripe gateway input fields,
 * also show or hide offline gateway informations according to checked payment gateway
 */
$('select[name="payment_method"]').on('change', function () {
  let value = $(this).val();
  let dataType = parseInt(value);

  if (isNaN(dataType)) {
    // hide offline gateway informations
    if ($('.offline-gateway-info').hasClass('d-block')) {
      $('.offline-gateway-info').removeClass('d-block');
    }

    $('.offline-gateway-info').addClass('d-none');

    // show or hide stripe card inputs
    if (value == 'Stripe') {
      $('#stripe-element').removeClass('d-none');
    } else {
      $('#stripe-element').addClass('d-none');
    }
  } else {
    // hide stripe gateway card inputs
    if (!$('#stripe-element').hasClass('d-none')) {
      $('#stripe-element').addClass('d-none');
      $('#stripe-element').removeClass('d-block');
    }

    // hide offline gateway informations
    if ($('.offline-gateway-info').hasClass('d-block')) {
      $('.offline-gateway-info').removeClass('d-block');
    }

    $('.offline-gateway-info').addClass('d-none');

    // show particular offline gateway informations
    $('#offline-gateway-' + value).removeClass('d-none');
  }
});



