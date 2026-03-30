(function ($) {
    "use strict";
    $("#storage_input").addClass('d-none');
    $("#call_waiter").hide();
    $("#postal_code").hide();
    $("#staff_input").hide();
    $("#order_input").hide();
    $("#table_reservation_input").hide();
    $('input[name="is_trial"]').on('change',function () {
        const value = $(this).val();
        if (value === "1") {
           
            $('#trial_day').removeClass('d-none');
        } else {
            $('#trial_day').addClass('d-none');
        }
        $('#trial_days').val(null);
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

     $(document).on("click", "#onTable", function () {
       const target = $("#call_waiter");
       $(this).is(":checked") ? target.show() && $("#call_waiter input").attr('checked',true) : target.hide() && $("#call_waiter input").attr('checked',false);
     });
       $(document).on("click", "#home_delivery", function () {
         const target = $("#postal_code");
         $(this).is(":checked")
           ? target.show() && $("#postal_code input").attr("checked", true)
           : target.hide() && $("#postal_code input").attr("checked", false);
       });
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
 
})(jQuery);
