(function ($) {
    "use strict";
    if (trialVal == 1){
        $('#trial_day').removeClass('d-none');
    }else{
        $('#trial_day').addClass('d-none');
    }
    if(permission.includes("Storage Limit")){
        $("#storage_input").show();
    }else{
        $("#storage_input").hide();
    }
    if(permission.includes("Staffs")){
        $("#staff_input").show();
    }else{
        $("#staff_input").hide();
    }
    if(permission.includes("Table Reservation")){
        $("#table_reservation_input").show();
    }else{
        $("#table_reservation_input").hide();
    }
    if(permission.includes("Online Order")){
        $("#order_input").show();
    }else{
        $("#order_input").hide();
    }

     if (permission.includes("Home Delivery")) {
       $("#postalCodeEdit").show();
     } else {
       $("#postalCodeEdit").hide();
     }

     if (permission.includes("On Table")) {
       $("#callWaiter").show();
     } else {
       $("#callWaiter").hide();
     }
  
    $('input[name="is_trial"]').on('change',function(){
        const value = $(this).val();
        if (value === "1") {
            $('#trial_day').removeClass('d-none');
        } else {
            $('#trial_day').addClass('d-none');
        }
        $('#trial_days_2').val(null);
        $('#trial_days_1').val(null);
    });
    $(document).on('click','#storage',function(){
        const target = $("#storage_input");
        $(this).is(':checked') ? target.show() :  target.hide();
    });
    $('.awsBtn').on('click', function () {
        $('#storage_input').addClass('d-none')
        $('#storage').prop('checked', false);
    })
    $('#storage').on('click', function () {

        if ($(this).is(':checked')) {
            $('#storage_input').removeClass('d-none')
            $('.awsInput').prop('checked', false);
        }
    })
    $(document).on('click','#staffs',function(){
        const target = $("#staff_input");
        $(this).is(':checked') ? target.show() :  target.hide();
    });
    $(document).on('click','#table-reservations',function(){
        const target = $("#table_reservation_input");
        $(this).is(':checked') ? target.show() :  target.hide();
    });
    $(document).on('click','#orders',function(){
        const target = $("#order_input");
        $(this).is(':checked') ? target.show() :  target.hide();
    });

      $(document).on("click", "#home_deliveryEdit", function () {
        const target = $("#postalCodeEdit");
        $(this).is(":checked") ? target.show() : target.hide() && $("#postalCodeEdit input").val('');
      });

        $(document).on("click", "#onTable", function () {
          const target = $("#callWaiter");
          $(this).is(":checked") ? target.show()  : target.hide() && $("#callWaiter input").val('');
        });
  
})(jQuery); 
