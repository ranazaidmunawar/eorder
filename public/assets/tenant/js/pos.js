$(function ($) {
  "use strict";

  function loadExtraFields(val) {
    $(".extra-fields").removeClass('d-block');
    $(".extra-fields").addClass('d-none');


    $(".extra-fields").attr('disabled', true);

    $("#" + val).removeClass("d-none");
    $("#" + val).addClass("d-block");


    $("#" + val).removeAttr('disabled');
  }

  $("#printBtn").click(function () {
    var customerFrame = document.getElementById("customerReceipt");
    customerFrame.focus();
    customerFrame.contentWindow.print();

    var kitchenFrame = document.getElementById("kitchenReceipt");
    kitchenFrame.focus();
    kitchenFrame.contentWindow.print();
  });

  loadExtraFields($("select[name='serving_method']").val());

  $("select[name='serving_method']").on('change', function () {
    loadExtraFields($(this).val());
    let scharge = 0;
    setShippingCharge();
  });

  $("#calcModalBtn").on('click', function () {

    $("#calcModal").modal('show');
  });
  $(document).on("input", "input[name='search']", function () {
    let keyword = $(this).val().toLowerCase();
    if (keyword.length > 0) {
      $("#posCatItems").hide();
      $("#posItems").show();
      $(".pos-item").hide();
      $(".pos-item").each(function () {
        let title = $(this).data('title').toLowerCase();

        if (title.indexOf(keyword) > -1) {
          $(this).show();
        }
      });
    } else {
      $("#posItems").hide();
      $("#posCatItems").show();
    }
  });

  $(document).on("click", "#clearCartBtn", function () {
    $(".request-loader").addClass("show");
    $.get(cartRoute, function (data) {
      if (data == "success") {
        location.reload();
      }
    });
  });


  function loadTimeFrames(date, time) {
    if (date.length > 0) {
      $.get(
        timeFramesRoute, {
        date: date
      },
        function (data) {

          let options = `<option value="" selected disabled>Select a Time Frame</option>`;
          if (data.status == 'success') {
            $("#deliveryTime").removeAttr('disabled');
            let timeframes = data.timeframes;
            for (let i = 0; i < timeframes.length; i++) {
              options +=
                `<option value="${timeframes[i].id}" ${time == timeframes[i].id ? 'selected' : ''}>${timeframes[i].start} - ${timeframes[i].end}</option>`
            }
          } else {
            $("#deliveryTime").attr('disabled', true);
            toastr["error"](data.message);

          }
          $("#deliveryTime").html(options);
        }
      )
    }
  }

  let charge;

  function setShippingCharge() {
    $(".request-loader").addClass("show");
    let servingMethod = $("select[name='serving_method']").val();
    getServingMethod = servingMethod || "on_table";

    if (servingMethod == 'home_delivery') {

      if (postalCode == 0) {
        if ($("input[name='shipping_charge']:checked").length > 0) {
          charge = $("input[name='shipping_charge']:checked").attr('data');
          let $checkedIn = $("input[name='shipping_charge']:checked");
          if ($checkedIn.data('free_delivery_amount') && (parseFloat($("#subtotal").text()) >= parseFloat(
            $checkedIn.data('free_delivery_amount')))) {
            charge = 0;

          } else {
            charge = $checkedIn.attr('data');
          }
        } else {

          charge = 0;
        }
      } else {
        let $selectedOpt = $("select[name='postal_code']").children('option:selected');
        if ($selectedOpt.data('free_delivery_amount') && (parseFloat($("#subtotal").text()) >= parseFloat(
          $selectedOpt.data('free_delivery_amount')))) {
          charge = 0;
        } else {
          charge = $selectedOpt.attr('data');
        }
      }
    } else {

      charge = 0.00;
    }

    $.get(shippingChargeRoute, {
      shipping_charge: charge,
      serving_method: servingMethod || 'on_table'
    }, function (data) {
      $("#customerCopy").load(location.href + " #customerCopy");
      $("#divRefresh").load(location.href + " #divRefresh", function () {
        $(".request-loader").removeClass('show');
      });
    });
  }

  function checkShippingCharge(callback) {
    let servingMethod = $("select[name='serving_method']").val();

    if (servingMethod == "home_delivery") {

      if (postalCode == 0) {
        if ($("input[name='shipping_charge']:checked").length > 0) {
          charge = $("input[name='shipping_charge']:checked").attr('data');
          let $checkedIn = $("input[name='shipping_charge']:checked");
          if ($checkedIn.data('free_delivery_amount') && (parseFloat($("#subtotal").text()) >= parseFloat(
            $checkedIn.data('free_delivery_amount')))) {
            charge = 0;

          } else {
            charge = $checkedIn.attr('data');
          }
        } else {

          charge = 0;
        }
      } else {
        let $selectedOpt = $("select[name='postal_code']").children('option:selected');
        if ($selectedOpt.data('free_delivery_amount') && (parseFloat($("#subtotal").text()) >= parseFloat(
          $selectedOpt.data('free_delivery_amount')))) {
          charge = 0;
        } else {
          charge = $selectedOpt.attr('data');
        }
      }

      $.get(shippingChargeRoute, {
        shipping_charge: charge,
        serving_method: servingMethod || 'on_table'
      }, function (data) {
        $("#customerCopy").load(location.href + " #customerCopy");
        $("#divRefresh").load(location.href + " #divRefresh", function () {

          if (typeof callback === 'function') {
            callback();
          }
        });
      });
    } else {
      charge = 0.00;

      if (typeof callback === 'function') {
        callback();
      }
    }
  }

  setShippingCharge();

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


  $(".field-input.cross i.fa-times-circle").on('click', function () {
    $(this).parents('.field-input').find('input').val('');
    $(this).parents('.field-input').removeClass('cross-show');
    $("#deliveryTime").html(`<option value="" selected disabled>Select a Time Frame</option>`);
    $("#deliveryTime").attr('disabled', true);
  });

  $("input[name='shipping_charge']").on('change', function () {
    setShippingCharge();
  });

  $("select[name='postal_code']").on('change', function () {
    setShippingCharge();
  });

});

function loadCustomerName(phone) {
  const targetName = "input[name='customer_name']";
  const targetEmail = "input[name='customer_email']";
  if (phone.length > 0) {
    $(".request-loader").addClass('show');
    $(targetName).removeAttr('disabled');
    $(targetEmail).removeAttr('disabled');
    $.get("load/" + phone + "/customer-name", function (data) {
      $(".request-loader").removeClass('show');
      $(targetName).val(data.name);
      $(targetEmail).val(data.email);
    });
  } else {
    $(targetName).val('');
    $(targetEmail).val('');
  }
}
