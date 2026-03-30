"use strict"

$("input[name='coupon']").on('keypress', function (e) {
  let code = e.which;
  if (code == 13) {
    e.preventDefault();
    applyCoupon();
  }
});

function showForm(val) {

  $(".form-container").removeClass('d-block');
  $(".form-container").addClass('d-none');
  $(".form-container input").attr('disabled', true);

  $("#" + val).removeClass('d-none');
  $("#" + val).addClass('d-block');
  $("#" + val + " input").attr('disabled', false);
}


function showOfflineGateways() {
  let gateways = $("input[name='serving_method']:checked").data('gateways');

  $(".offline").removeClass('d-block');
  $(".offline").addClass('d-none');
  $(".offline input").attr('disabled', true);

  for (let i = 0; i < gateways.length; i++) {
    $("#offline" + gateways[i]).removeClass('d-none');
    $("#offline" + gateways[i]).addClass('d-block');
    $("#offline" + gateways[i] + " input").attr('disabled', false);
  }
}

function showDetails(tabid) {

  if (tabid == 'stripe') {
    $(".gateway-details").removeClass("d-flex");
    $(".gateway-details").removeClass("d-block");
    $(".gateway-details").addClass("d-none");

    if ($("#tab-" + tabid).length > 0) {
      $("#tab-" + tabid).addClass("d-block");
    }
  } else if (tabid == 'stripe') {
    $(".gateway-details").removeClass("d-flex");
    $(".gateway-details").removeClass("d-block");
    $(".gateway-details").addClass("d-none");

    if ($("#tab-" + tabid).length > 0) {
      $("#tab-" + tabid).removeClass("d-none");
    }
  } else {
    $(".gateway-details").removeClass("d-flex");
    $(".gateway-details").addClass("d-none");

    $(".gateway-details input").attr('disabled', true);

    if ($("#tab-" + tabid).length > 0) {
      $("#tab-" + tabid).addClass("d-flex");

      $("#tab-" + tabid + " input").removeAttr("disabled");
    }
  }

  if (tabid == 'stripe') {
    $(".gateway-details").removeClass("d-flex");
    $(".gateway-details").removeClass("d-block");
    $(".gateway-details").addClass("d-none");

    if ($("#tab-" + tabid).length > 0) {
      $("#tab-" + tabid).addClass("d-block");
    }
  } else {

    $(".gateway-details").removeClass("d-flex");
    $(".gateway-details").addClass("d-none");
    $("#tab-stripe").removeClass("d-block");

    $(".gateway-details input").attr('disabled', true);

    if ($("#tab-" + tabid).length > 0) {
      $("#tab-" + tabid).addClass("d-flex");

      $("#tab-" + tabid + " input").removeAttr("disabled");
    }
  }

}

function toggleBillingAddress() {
  let val = $("input[name='same_as_shipping']").is(':checked');
  if (!val) {
    $("#billingAddress").show();
  } else {
    $("#billingAddress").hide();
  }
}

function calcTotal() {
  let $servingIn = $("input[name='serving_method']:checked");
  let $shippingIn = $("input[name='shipping_charge']:checked");

  let subTotal = parseFloat($("#subtotal").attr('data'));
  let total = subTotal;
  let scharge = 0;
  let tax = $("#tax").data('tax');

  if ($servingIn.val() == 'home_delivery') {

    if (postalCode == 0 && $shippingIn.length > 0) {
      scharge = $shippingIn.attr('data');
    } else if (postalCode == 1) {
      scharge = $("select[name='postal_code']").children('option:selected').attr('data') ? $(
        "select[name='postal_code']").children('option:selected').attr('data') : 0;
    }
  }

  $(".shipping").text(scharge);
  total += parseFloat(scharge) + parseFloat(tax);
  total = total.toFixed(2);
  $(".grandTotal").attr('data', total);
  $(".grandTotal").text(total);
}

$(document).ready(function () {

  showOfflineGateways();


  let val = $("input[name='serving_method']:checked").val();
  showForm(val);


  calcTotal();


  toggleBillingAddress();




  $(".input-check").first().attr('checked', true);

  let tabId = $(".input-check:checked").data('tabid');

  $('#payment').attr('action', $(".input-check:checked").data('action'));
  showDetails(tabId);


  $(".delivery-datepicker").each(function () {
    let $this = $(this);
    $this.datepicker({
      beforeShowDay: function (date) {
        let now = new Date();
        now.setHours(0, 0, 0, 0);

        if (date < now) {
          return [false, 'na_dates'];
        } else {
          return [true, ''];
        }
      },
      onSelect: function (date, instance) {
        $this.parents('.field-input').addClass('cross-show');
        loadTimeFrames(date);
      }
    });
  });


});


$(".field-input.cross i.fa-times-circle").on('click', function () {
  $(this).parents('.field-input').find('input').val('');
  $(this).parents('.field-input').removeClass('cross-show');
  $("#deliveryTime").html(`<option value="" selected disabled>${time_frame}</option>`);
  $("#deliveryTime").attr('disabled', true);
})



$("input[name='serving_method']").on('change', function () {
  let val = $(this).val();

  showOfflineGateways();

  showForm(val);
  calcTotal();
})


$(document).on('change', "select[name='postal_code']", function () {

  calcTotal();
});


$(document).on('change', "input[name='shipping_charge']", function () {

  calcTotal();
});


$("input[name='same_as_shipping']").on('change', function () {
  toggleBillingAddress();
});


$(document).on('change', '.input-check', function () {

  let tabId = $(this).data('tabid');
  $('#payment').attr('action', $(this).data('action'));
  $('#paymentGatewaysForm').attr('action', $(".input-check:checked").data('action'));

  showDetails(tabId);

});

if (stripe_key != '') {
  var stripe = Stripe(stripe_key);

  var elements = stripe.elements();
  var cardElement = elements.create('card', {
    style: {
      base: {
        iconColor: '#454545',
        color: '#454545',
        fontWeight: '500',
        lineHeight: '50px',
        fontSmoothing: 'antialiased',
        backgroundColor: '#f2f2f2',
        ':-webkit-autofill': {
          color: '#454545',
        },
        '::placeholder': {
          color: '#454545',
        },
      }
    },
  });


  cardElement.mount('#stripe-element');
} else {
  $('#stripe-element').append(`<p style="margin-left:9px;" class="text-danger">Stripe credentials are not set yet </p>`)
}

function stripeTokenHandler(token) {

  var form = document.getElementById('payment');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);


  form.submit();
}

function stripeMethod() {
  stripe.createToken(cardElement).then(function (result) {
    if (result.error) {

      var errorElement = document.getElementById('stripe-errors');
      errorElement.textContent = result.error.message;
    } else {

      stripeTokenHandler(result.token);
    }
  })
}

$("#placeOrderBtn").on('click', function (e) {
  let val = document.querySelector('input[name="gateway"]:checked')?.value;
  if (val == "authorize.net") {
    sendPaymentDataToAnet();
  } else if (val == 'stripe') {
    if (stripe_key != '') {
      stripeMethod();
    } else {

      document.getElementById('payment').submit()
    }
  } else {
    document.getElementById('payment').submit()
  }
});

function sendPaymentDataToAnet() {

  var authData = {};
  authData.clientKey = clientKey;
  authData.apiLoginID = apiLoginID;

  var cardData = {};
  cardData.cardNumber = document.getElementById("anetCardNumber").value;
  cardData.month = document.getElementById("anetExpMonth").value;
  cardData.year = document.getElementById("anetExpYear").value;
  cardData.cardCode = document.getElementById("anetCardCode").value;


  var secureData = {};
  secureData.authData = authData;
  secureData.cardData = cardData;
  Accept.dispatchData(secureData, responseHandler);
}

function responseHandler(response) {
  if (response.messages.resultCode === "Error") {
    var i = 0;
    let errorLists = ``;
    while (i < response.messages.message.length) {
      errorLists += `<li class="text-danger">${response.messages.message[i].text}</li>`;

      i = i + 1;
    }
    $("#anetErrors").show();
    $("#anetErrors").html(errorLists);
  } else {
    paymentFormUpdate(response.opaqueData);
  }
}

function paymentFormUpdate(opaqueData) {
  document.getElementById("opaqueDataDescriptor").value = opaqueData.dataDescriptor;
  document.getElementById("opaqueDataValue").value = opaqueData.dataValue;
  document.getElementById("payment").submit();
}


