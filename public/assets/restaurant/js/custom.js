"use strict"
$(function () {

  $.getScript(datepickerpath)
    .done(function () {

      $("input.datepicker").datepicker({
        minDate: 0,
        dayNames: $.datepicker.regional[userCurrentLang].dayNames,
        monthNames: $.datepicker.regional[userCurrentLang].monthNames,

      });
    })
    .fail(function () {

    });

});



$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $("input.datepicker").datepicker();
  $('input.timepicker').timepicker();

  let $foodItems;

  function initSubcatIsotope() {
    setTimeout(function () {
      $foodItems = $('.food-menu-items').isotope({
        itemSelector: '.single-menu-item',
        layoutMode: 'vertical'
      });
    }, 100);
  }

  initSubcatIsotope();
  $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    initSubcatIsotope();
    setTimeout(function () {
      let id = $(e.target).attr('href');
      $(id + " button.is-checked").trigger('click');
    }, 200);
  });

  $('.filters-button-group').on('click', 'button', function () {
    const filterValue = $(this).attr('data-filter');
    $foodItems.isotope({
      filter: filterValue
    });
  });

  $('.button-group').each(function (i, buttonGroup) {
    const $buttonGroup = $(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $(this).addClass('is-checked');
    });
  });
});

$(document).on('click', '.qty-add', function () {
  $(".cart-sidebar-loader-container").addClass('show');
  let $this = $(this);
  let key = $(this).data('key');
  let $input = $this.prev('input');
  $input.val(parseInt($input.val()) + 1);
  let qty = $input.val();

  changeQty(key, qty);
});

$(document).on('click', '.qty-sub', function () {
  $(".cart-sidebar-loader-container").addClass('show');
  let $this = $(this);
  let key = $(this).data('key');
  let $input = $this.next('input');
  if ($input.val() <= 1) {
    toastr["error"]("Quantity must be minimum 1");
    $(".cart-sidebar-loader-container").removeClass('show');
    return;
  }
  $input.val(parseInt($input.val()) - 1);
  let qty = $input.val();
  changeQty(key, qty);
});

function changeQty(key, qty) {
  let fd = new FormData();
  fd.append('qty', qty);
  fd.append('key', key);
  $.ajax({
    url: qrQtyChangeRoute,
    type: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: function (data) {
      $("#cartQuantity").load(location.href + " #cartQuantity");
      $("#refreshDiv").load(location.href + " #refreshDiv", function () {
        $(".cart-sidebar-loader-container").removeClass('show');
        setTimeout(function () { }, 100);
        toastr['success'](data.message);
      });
    }
  })
}

$(document).on('click', '.cart-item .close', function () {
  $(".cart-sidebar-loader-container").addClass('show');
  let $this = $(this);
  let key = $this.data('key');
  let fd = new FormData();
  fd.append('key', key);

  $.ajax({
    url: qrRemoveRoute,
    type: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: function (data) {

      $("#cartQuantity").load(location.href + " #cartQuantity");
      $("#refreshDiv").load(location.href + " #refreshDiv", function () {
        $(".cart-sidebar-loader-container").removeClass('show');
        setTimeout(function () { }, 100);
        toastr['success'](data.message);
      })
    }
  })
})

$(document).ready(function () {

  $("#billing_country_code a").on('click', function (e) {
    e.preventDefault();
    $("input[name='billing_country_code']").val($(this).data('billing_country_code'));
    $(this).parents('.input-group').find('button.billing_country_code').text($(this).data(
      'billing_country_code'));
  });
  $("#shipping_country_code a").on('click', function (e) {
    e.preventDefault();
    $("input[name='shipping_country_code']").val($(this).data('shipping_country_code'));
    $(this).parents('.input-group').find('button.shipping_country_code').text($(this).data(
      'shipping_country_code'));
  });
});

$("input.datepicker").datepicker({
  minDate: 0
});

$(document).ready(function () {
  var $foodItems;

  function initSubcatIsotope() {
    setTimeout(function () {
      $foodItems = $('.food-menu-items').isotope({
        itemSelector: '.single-menu-item',
        layoutMode: 'vertical'
      });
    }, 100);
  }

  initSubcatIsotope();

  $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    initSubcatIsotope();
    setTimeout(function () {
      let id = $(e.target).attr('href');
      $(id + " button.is-checked").trigger('click');
    }, 200);
  });


  $('.filters-button-group').on('click', 'button', function () {
    var filterValue = $(this).attr('data-filter');
    $foodItems.isotope({
      filter: filterValue
    });
  });

  $('.button-group').each(function (i, buttonGroup) {
    var $buttonGroup = $(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $(this).addClass('is-checked');
    });
  });
})
