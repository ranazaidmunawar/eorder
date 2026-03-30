"use strict";
$(function ($) {

    // Uploaded Image Preview Start
    $('.img-input').on('change', function (event) {
        let file = event.target.files[0];
        let reader = new FileReader();

        reader.onload = function (e) {
            $('.uploaded-img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    });
    // Uploaded Image Preview End


    // Uploaded Background Image Preview Start
    $('.background-img-input').on('change', function (event) {
        let file = event.target.files[0];
        let reader = new FileReader();

        reader.onload = function (e) {
            $('.uploaded-background-img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    });
    // Uploaded Background Image Preview End


    // REMOVE ASSIGNED USER FROM VCARD START
    $('.removeUser').on('click', function(e) {
        let user = $(this).parent(".deleteform").find('.username').val();
        let vCard = $(this).parent(".deleteform").find('.vcardname').val();
        e.preventDefault();
        $(".request-loader").addClass("show");
        swal({
            title: 'Are you sure?',
            text: 'You want to remove user "' + user + '" from the vCard "' + vCard + '"!',
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Yes, remove user!',
                    className: 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $(this).parent(".deleteform").trigger('submit');
            } else {
                swal.close();
                $(".request-loader").removeClass("show");
            }
        });
    });
    // REMOVE ASSIGNED USER FROM VCARD END

    // Store Lesson's Video Using AJAX Request Start
    $('#videoSubmitBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let videoForm = $('#videoForm')[0];
        let fd = new FormData(videoForm);
        let url = $('#videoForm').attr('action');
        let type = $('#videoForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                $('.em').each(function () {
                    $(this).html('');
                });

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').each(function () {
                    $(this).html('');
                });
                for (let x in errRes.responseJSON.errors) {
                    $('#err_' + x).text(errRes.responseJSON.errors[x][0]);
                }
                $('.request-loader').removeClass('show');
            }
        });
    });
    // Store Lesson's Video Using AJAX Request End


    // Store Lesson's File Using AJAX Request Start
    $('#fileSubmitBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let fileForm = $('#fileForm')[0];
        let fd = new FormData(fileForm);
        let url = $('#fileForm').attr('action');
        let type = $('#fileForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');
                $('.em').each(function () {
                    $(this).html('');
                });

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').each(function () {
                    $(this).html('');
                });

                for (let x in errRes.responseJSON.errors) {
                    $('#err_' + x).text(errRes.responseJSON.errors[x][0]);
                }

                $('.request-loader').removeClass('show');
            }
        });
    });
    // Store Lesson's File Using AJAX Request End


    // Store Lesson's Text Using AJAX Request Start
    $('#textSubmitBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let textForm = $('#textForm')[0];
        let fd = new FormData(textForm);
        let url = $('#textForm').attr('action');
        let type = $('#textForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                $('.em').html('');

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').html('');

                $('#err_text').text(errRes.responseJSON.error['text'][0]);

                $('.request-loader').removeClass('show');
            }
        });
    });
    // Store Lesson's Text Using AJAX Request End


    // Update Lesson's Text Using AJAX Request Start
    $('#textUpdateBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');
        let textForm = $('#editTextForm')[0];
        let fd = new FormData(textForm);
        let url = $('#editTextForm').attr('action');
        let type = $('#editTextForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');
                $('.em').html('');
                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').html('');
                $('#editErr_text').text(errRes.responseJSON.error['text'][0]);
                $('.request-loader').removeClass('show');
            }
        });
    });
    // Update Lesson's Text Using AJAX Request End


    // Store Lesson's Code Using AJAX Request Start
    $('#codeSubmitBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let codeForm = $('#codeForm')[0];
        let fd = new FormData(codeForm);
        let url = $('#codeForm').attr('action');
        let type = $('#codeForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                $('.em').html('');

                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').html('');
                $('#err_code').text(errRes.responseJSON.error['code'][0]);
                $('.request-loader').removeClass('show');
            }
        });
    });
    // Store Lesson's Code Using AJAX Request End


    // Update Lesson's Code Using AJAX Request Start
    $('#codeUpdateBtn').on('click', function (event) {
        event.preventDefault();
        $('.request-loader').addClass('show');

        let codeForm = $('#editCodeForm')[0];
        let fd = new FormData(codeForm);
        let url = $('#editCodeForm').attr('action');
        let type = $('#editCodeForm').attr('method');

        $.ajax({
            url: url,
            type: type,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');
                $('.em').html('');
                if (data == 'success') {
                    location.reload();
                }
            },
            error: function (errRes) {
                $('.em').html('');
                $('#editErr_code').text(errRes.responseJSON.error['code'][0]);
                $('.request-loader').removeClass('show');
            }
        });
    });
    // Update Lesson's Code Using AJAX Request End

    /*------------------------
    Highlight Js
    -------------------------- */
    hljs.initHighlightingOnLoad();
});

function cloneInput(fromId, toId, event) {
    let $target = $(event.target);
    if ($target.is(':checked')) {
        $('#' + fromId + ' .form-control').each(function (i) {
            let index = i;
            let val = $(this).val();
            let $toInput = $('#' + toId + ' .form-control').eq(index);

            if ($(this).hasClass('summernote')) {
                $toInput.summernote('code', val);
            } else if ($(this).data('role') == 'tagsinput') {
                if (val.length > 0) {
                    let tags = val.split(',');
                    tags.forEach(tag => {
                        $toInput.tagsinput('add', tag);
                    });
                } else {
                    $toInput.tagsinput('removeAll');
                }
            } else {
                $toInput.val(val);
            }
        });
    } else {
        $('#' + toId + ' .form-control').each(function (i) {
            let $toInput = $('#' + toId + ' .form-control').eq(i);
            if ($(this).hasClass('summernote')) {
                $toInput.summernote('code', '');
            } else if ($(this).data('role') == 'tagsinput') {
                $toInput.tagsinput('removeAll');
            } else {
                $toInput.val('');
            }
        });
    }
}


