"use strict";
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function applyCoupon() {
        let fd = new FormData();
        let coupon = $("input[name='coupon']").val();
        fd.append('coupon', coupon);
        fd.append('package_id', packageId);

        $.ajax({
            url: couponRoute,
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data === 'success') {
                    $("#couponReload").load(location.href + " #couponReload", function () {
                        $('select').niceSelect();
                    });
                    toastr['success']("Coupon applied successfully!");
                } else {
                    toastr['warning'](data);
                }
            }
        })
    }

    $("input[name='coupon']").on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            applyCoupon();
        }
    });

    $(".coupon-apply").on('click', function () {
        applyCoupon();
    });

    $(document).on('change', "#payment-gateway", function () {
        let offline = ogateways;
        let data = [];
        offline.map(({ name }) => {
            data.push(name);
        });
        let paymentMethod = $("#payment-gateway").val();
        $("input[name='payment_method']").val(paymentMethod);


        $(".gateway-details input").attr('disabled', true);

        if (paymentMethod == 'Stripe') {
            $("#tab-stripe").removeClass('d-none');
            $("#tab-stripe input").removeAttr('disabled');
            $('.iyzico-element').addClass('d-none');
        } else if (paymentMethod == 'Iyzico') {
            $('.iyzico-element').removeClass('d-none');
            $('#tab-stripe').addClass('d-none');
        } else {
            $("#tab-stripe").addClass('d-none');
            $('.iyzico-element').addClass('d-none');
        }


        if (paymentMethod == 'Authorize.net') {
            $("#tab-anet").removeClass('d-none');
            $("#tab-anet input").removeAttr('disabled');
        } else {
            $("#tab-anet").addClass('d-none');
        }

        if (data.indexOf(paymentMethod) !== -1) {
            let formData = new FormData();
            formData.append('name', paymentMethod);
            $.ajax({
                url: oinstructions,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function (data) {
                    let instruction = $("#instructions");
                    let instructions =
                        `<div class="gateway-desc">${data.instructions}</div>`;
                    if (data.description != null) {
                        var description =
                            `<div class="gateway-desc"><p>${data.description}</p></div>`;
                    } else {
                        var description = `<div></div>`;
                    }
                    let receipt = `<div class="form-element mb-2">
                                      <label>Receipt<span>*</span></label><br>
                                      <input type="file" name="receipt" value="" class="file-input" required>
                                      <p class="mb-0 text-warning">** Receipt image must be .jpg / .jpeg / .png</p>
                                   </div>`;
                    if (data.is_receipt == 1) {
                        $("#is_receipt").val(1);
                        let finalInstruction = instructions + description + receipt;
                        instruction.html(finalInstruction);
                    } else {
                        $("#is_receipt").val(0);
                        let finalInstruction = instructions + description;
                        instruction.html(finalInstruction);
                    }
                    $('#instructions').fadeIn();
                },
                error: function (data) { }
            })
        } else {
            $('#instructions').fadeOut();
        }
    });
});
