"use strict";

WebFont.load({
    google: { "families": ["Lato:300,400,700,900"] },
    custom: { "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: [mainurl + '/assets/admin/css/fonts.min.css'] },
    active: function () {
        sessionStorage.fonts = true;
    }
});

/*****************************************************
 ==========Demo code ==========
 ******************************************************/
if (demo_mode == 'active') {
    $.ajaxSetup({
        beforeSend: function (jqXHR, settings, event) {
            if (settings.type == 'POST' && settings.url.indexOf('user/qr-code/generate') == -1 || settings.type == 'PUT') {
                if ($(".request-loader").length > 0) {
                    $(".request-loader").removeClass('show');
                }
                if ($(".modal").length > 0) {
                    $(".modal").modal('hide');
                }
                if ($("button[disabled='disabled']").length > 0) {
                    $("button[disabled='disabled']").removeAttr('disabled');
                }
                bootnotify('This is demo version. You cannot change anything here!', 'Demo Version', 'warning')
                jqXHR.abort(event);
            }
        },
        complete: function () {
            // hide progress spinner
        }
    });
}
/*****************************************************
==========Demo code end==========
******************************************************/

/*****************************************************
 ==========Bootstrap Notify start==========
 ******************************************************/
function bootnotify(message, title, type) {
    var content = {};

    content.message = message;
    content.title = title;
    content.icon = 'fa fa-bell';

    $.notify(content, {
        type: type,
        placement: {
            from: 'top',
            align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        allow_dismiss: true,
        delay: 4000
    });
}
/*****************************************************
 ==========Bootstrap Notify end==========
 ******************************************************/

$(function ($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* ***************************************************************
    ==========disabling default behave of form submits start==========
    *****************************************************************/
    $("#ajaxEditForm").attr('onsubmit', 'return false');
    $("#ajaxForm").attr('onsubmit', 'return false');
    /* *************************************************************
    ==========disabling default behave of form submits end==========
    ***************************************************************/

    // Sidebar Search

    $(".sidebar-search").on('input', function () {
        let term = $(this).val().toLowerCase();

        if (term.length > 0) {
            $(".sidebar ul li.nav-item").each(function (i) {
                let menuName = $(this).find("p").text().toLowerCase();
                let $mainMenu = $(this);

                // if any main menu is matched
                if (menuName.indexOf(term) > -1) {
                    $mainMenu.removeClass('d-none');
                    $mainMenu.addClass('d-block');
                } else {
                    let matched = 0;
                    let count = 0;
                    // search sub-items of the current main menu (which is not matched)
                    $mainMenu.find('span.sub-item').each(function (i) {
                        // if any sub-item is matched  of the current main menu, set the flag
                        if ($(this).text().toLowerCase().indexOf(term) > -1) {
                            count++;
                            matched = 1;
                        }
                    });


                    // if any sub-item is matched  of the current main menu (which is not matched)
                    if (matched == 1) {
                        $mainMenu.removeClass('d-none');
                        $mainMenu.addClass('d-block');
                    } else {
                        $mainMenu.removeClass('d-block');
                        $mainMenu.addClass('d-none');
                    }
                }
            });
        } else {
            $(".sidebar ul li.nav-item").addClass('d-block');
        }
    });


    /* ***************************************************
    ==========fontawesome icon picker start==========
    ******************************************************/
    // fontawesome icon picker start
    $('.icp-dd').iconpicker();
    // fontawesome icon picker end
    $('.icp').on('iconpickerSelected', function (event) {
        $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
    });
    /* ***************************************************
    ==========fontawesome icon picker upload end==========
    ******************************************************/


    /* ***************************************************
    ==========Summernote initialization start==========
    ******************************************************/
    $(".summernote").each(function (i) {

        // Get the ID of the Summernote element
        var summernoteID = $(this).attr("id");

        // Get the 'data-langg' attribute value to determine RTL or LTR.
        var langDirection = $('#' + summernoteID).data("langg");
       
        tinymce.init({
            selector: '.summernote',
            plugins: 'autolink charmap emoticons image link lists media searchreplace table visualblocks wordcount directionality',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | ltr rtl',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            promotion: false,
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ]
        });


    });

    $(document).on('click', ".note-video-btn", function () {
        let i = $(this).index();
        if ($(".summernote").eq(i).parents(".modal").length > 0) {
            setTimeout(() => {
                $("body").addClass('modal-open');
            }, 500);
        }
    });


    /* ***************************************************
    ==========Summernote initialization end==========
    ******************************************************/

    $('.icp-dd').iconpicker();
    $('.icp').on('iconpickerSelected', function (event) {
        $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
    });


    /* ***************************************************
    ==========Summernote initialization end==========
    ******************************************************/



    /* ***************************************************
    ==========Bootstrap Notify start==========
    ******************************************************/
    function bootnotify(message, title, type) {
        var content = {};

        content.message = message;
        content.title = title;
        content.icon = 'fa fa-bell';

        $.notify(content, {
            type: type,
            placement: {
                from: 'top',
                align: 'right'
            },
            showProgressbar: true,
            time: 1000,
            allow_dismiss: true,
            delay: 4000,
        });
    }
    /* ***************************************************
    ==========Bootstrap Notify end==========
    ******************************************************/



    /* ***************************************************
    ==========Form Submit with AJAX Request Start==========
    ******************************************************/
    $("#submitBtn").on('click', function (e) {
        $(e.target).attr('disabled', true);

        $(".request-loader").addClass("show");

        let ajaxForm = document.getElementById('ajaxForm');
        let fd = new FormData(ajaxForm);
        let url = $("#ajaxForm").attr('action');
        let method = $("#ajaxForm").attr('method');

        $('.form-control').each(function (i) {
            let index = i;

            let $toInput = $('.form-control').eq(index);

            if ($(this).hasClass('summernote')) {
                let tmcId = $toInput.attr('id');
                let content = tinyMCE.get(tmcId).getContent();
                fd.delete($(this).attr('name'));
                fd.append($(this).attr('name'), content);
            }
        });

        $.ajax({
            url: url,
            method: method,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
            
                $(e.target).attr('disabled', false);
                $(".request-loader").removeClass("show");

                $(".em").each(function () {
                    $(this).html('');
                })
                if (data == "success") {
                    location.reload();
                }

                if (data == "banStaff") {

                    var content = {};
                    content.message = 'We regret to inform you that your account has been deactivated.';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    location.reload();
                }

                if (data == "downgrade") {
                    $('.modal').modal('hide');
                    "use strict";
                    var content = {};
                    content.message = 'Your feature limit is reached or over';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    $("#limitModal").modal('show');
                }


                // if error occurs
                else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        if (x == 'error') {
                            continue;
                        }
                        document.getElementById('err' + x).innerHTML = data[x][0];
                    }
                } else if (data?.errors?.error) {
                    const errors = data?.errors;
                    Object.keys(errors).map(function (key) {
                        if (key !== 'error')
                            document.getElementById('err' + key).innerHTML = errors[key][0];
                    });
                }
            },
            error: function (error) {
                $(".em").each(function () {
                    $(this).html('');
                })

                for (let x in error.responseJSON.errors) {
                    document.getElementById('err' + x).innerHTML = error.responseJSON.errors[x][0];
                }
                $(".request-loader").removeClass("show");

                if (error.status == 422) {

                    $(e.target).attr('disabled', false);
                    if (error?.responseJSON?.exception) {
                        $('.modal').modal('hide');
                        bootnotify(error?.responseJSON?.exception, "Warning", "warning");
                    }
                    $('.errorIcon').addClass('d-none')
                }
                else {
                   
                    $(e.target).attr('disabled', false);
                    if (error?.responseJSON?.exception) {
                        $('.modal').modal('hide');
                        bootnotify(error?.responseJSON?.exception, "Warning", "warning");
                    }
                    $('.errorIcon').addClass('d-none')
                }

            }
        });
    });

    // blog form
    $('#blogForm').on('submit', function (e) {
        $('.request-loader').addClass('show');
        e.preventDefault();

        let action = $(this).attr('action');
        let fd = new FormData($(this)[0]);
        $('.form-control').each(function (i) {
            let index = i;

            let $toInput = $('.form-control').eq(index);

            if ($(this).hasClass('summernote')) {
                let tmcId = $toInput.attr('id');
                let content = tinyMCE.get(tmcId).getContent();
                fd.delete($(this).attr('name'));
                fd.append($(this).attr('name'), content);
            }
        });

        $.ajax({
            url: action,
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');
                if (data === 'success') {
                    location.reload();
                }

                if (data == "downgrade") {
                    $('.modal').modal('hide');
                    "use strict";
                    var content = {};
                    content.message = 'Your feature limit is reached or over';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    $("#limitModal").modal('show');
                }

                if (data == "banStaff") {

                    var content = {};
                    content.message = 'We regret to inform you that your account has been deactivated.';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    location.reload();
                }
            },
            error: function (error) {
                let errors = ``;
                for (let x in error.responseJSON.errors) {
                    errors += `<li>
                                <p class="text-danger mb-0">${error.responseJSON.errors[x][0]}</p>
                              </li>`;
                }

                if (error.status == 500) {


                    if (error?.responseJSON?.exception) {
                        errors += `<li>
                                  <p class="text-danger mb-0">${error?.responseJSON?.exception}</p>
                              </li>`;
                    }

                    $('.navbar-header').load(location.href + '.navbar-header');
                    setTimeout(() => {
                        $('#limitModal').modal('show');
                    }, 2000)

                    $('.errorIcon').removeClass('d-none')

                    $('#blogErrors ul').html(errors);
                    $('#blogErrors').show();

                    $('.request-loader').removeClass('show');

                    $('html, body').animate({
                        scrollTop: $('#blogErrors').offset().top - 100
                    }, 1000);
                } else {
                    if (error?.responseJSON?.exception) {
                        errors += `<li>
                                  <p class="text-danger mb-0">${error?.responseJSON?.exception}</p>
                              </li>`;
                    }

                    $('#blogErrors ul').html(errors);
                    $('#blogErrors').show();

                    $('.request-loader').removeClass('show');

                    $('html, body').animate({
                        scrollTop: $('#blogErrors').offset().top - 100
                    }, 1000);
                }
            }
        });
    });

    // pageForm form
    $('#pageForm').on('submit', function (e) {
        $('.request-loader').addClass('show');
        e.preventDefault();

        let action = $(this).attr('action');
        let fd = new FormData($(this)[0]);
        $('.form-control').each(function (i) {
            let index = i;

            let $toInput = $('.form-control').eq(index);

            if ($(this).hasClass('summernote')) {
                let tmcId = $toInput.attr('id');
                let content = tinyMCE.get(tmcId).getContent();
                fd.delete($(this).attr('name'));
                fd.append($(this).attr('name'), content);
            }
        });

        $.ajax({
            url: action,
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                if (data == 'success') {
                    location.reload();
                }

                if (data == "downgrade") {
                    $('.modal').modal('hide');
                    "use strict";
                    var content = {};
                    content.message = 'Your feature limit is reached or over';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    $("#limitModal").modal('show');
                }

                if (data == "banStaff") {

                    var content = {};
                    content.message = 'We regret to inform you that your account has been deactivated.';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    location.reload();
                }
            },
            error: function (error) {
                let errors = ``;

                for (let x in error.responseJSON.errors) {
                    errors += `<li>
                <p class="text-danger mb-0">${error.responseJSON.errors[x][0]}</p>
              </li>`;
                }

                $('#pageErrors ul').html(errors);
                $('#pageErrors').show();

                $('.request-loader').removeClass('show');

                $('html, body').animate({
                    scrollTop: $('#pageErrors').offset().top - 100
                }, 1000);
            }
        });
    });

    // Form Submit with AJAX Request Start
    $("#submitBtn3").on('click', function (e) {
        $(e.target).attr('disabled', true);

        $(".request-loader").addClass("show");

        let ajaxForm = document.getElementById('ajaxForm');
        let fd = new FormData(ajaxForm);
        let url = $("#ajaxForm").attr('action');
        let method = $("#ajaxForm").attr('method');


        //if summernote has then get summernote content
        $('.form-control').each(function (i) {
            if ($(this).hasClass('summernote')) {
                let content = tinyMCE.activeEditor.getContent();

                fd.delete($(this).attr('name'));
                fd.append($(this).attr('name'), content);
            }
        });

        $.ajax({
            url: url,
            method: method,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $(e.target).attr('disabled', false);
                $(".request-loader").removeClass("show");

                $(".em").each(function () {
                    $(this).html('');
                })
                if (data == "success") {
                    location.reload();
                }

                if (data == "banStaff") {

                    var content = {};
                    content.message = 'We regret to inform you that your account has been deactivated.';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    location.reload();
                }

                if (data == "downgrade") {
                    $('.modal').modal('hide');
                    "use strict";
                    var content = {};
                    content.message = 'Your feature limit is reached or over';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    $("#limitModal").modal('show');
                }

                // if error occurs
                else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        if (x == 'error') {
                            continue;
                        }
                        document.getElementById('err' + x).innerHTML = data[x][0];
                    }
                } else if (data?.errors?.error) {
                    const errors = data?.errors;
                    Object.keys(errors).map(function (key) {
                        if (key !== 'error')
                            document.getElementById('err' + key).innerHTML = errors[key][0];
                    });
                }
            },
            error: function (error) {
                $(".em").each(function () {
                    $(this).html('');
                })

                for (let x in error.responseJSON.errors) {
                    document.getElementById('err' + x).innerHTML = error.responseJSON.errors[x][0];
                }
                $(".request-loader").removeClass("show");

                if (error.status == 422) {

                    $(e.target).attr('disabled', false);
                    if (error?.responseJSON?.exception) {
                        $('.modal').modal('hide');
                        bootnotify(error?.responseJSON?.exception, "Warning", "warning");
                    }
                    $('.errorIcon').addClass('d-none')
                }
                else {
                   
                    $(e.target).attr('disabled', false);
                    if (error?.responseJSON?.exception) {
                        $('.modal').modal('hide');
                        bootnotify(error?.responseJSON?.exception, "Warning", "warning");
                    }
                    $('.errorIcon').addClass('d-none')
                }

            }
        });
    });

    $("#permissionBtn").on('click', function () {
        $("#permissionsForm").trigger("submit");
    });
    /* ***************************************************
    ==========Form Submit with AJAX Request End==========
    ******************************************************/

    /* ***************************************************
    ==========datatables start==========
    ******************************************************/
    $('#basic-datatables').DataTable({
        responsive: true,
        ordering: false,
    });
    /* ***************************************************
    ==========datatables end==========
    ******************************************************/


    /* ***************************************************
    ==========Form Prepopulate After Clicking Edit Button Start==========
    ******************************************************/
    $(".editbtn").on('click', function () {
        let datas = $(this).data();
      
        delete datas['toggle'];
        for (let x in datas) {
            if ($("#in" + x).hasClass('summernote')) {
                tinyMCE.activeEditor.setContent(datas[x])
            } else if ($("#in" + x).hasClass('image')) {
                $("#in" + x).attr('src', datas[x]);
            } else if ($("#in" + x).data('role') == 'tagsinput') {
                if (datas[x].length > 0) {
                    let arr = datas[x].split(" ");
                    for (let i = 0; i < arr.length; i++) {
                        $("#in" + x).tagsinput('add', arr[i]);
                    }
                } else {
                    $("#in" + x).tagsinput('removeAll');
                }
            } else if ($("#in_" + x).hasClass('select2')) {
                $("#in_" + x).val(datas[x]);
                $("#in_" + x).trigger('change');
            }
            else if ($("input[name='" + x + "']").attr('type') == 'radio') {
                $("input[name='" + x + "']").each(function (i) {
                    if ($(this).val() == datas[x]) {
                        $(this).prop('checked', true);
                    }
                });
            }
            else {
                $("#in" + x).val(datas[x]);
                if ($('#in_image').length > 0) {
                    $('#in_image').attr('src', datas['image']);
                }
                if ($('#in_icon').length > 0) {
                    $('#in_icon').attr('class', datas['icon']);
                }
            }
        }
        if ('edit' in datas && datas.edit === 'editAdvertisement') {
            if (datas.ad_type === 'banner') {
                if (!$('#edit-slot-input').hasClass('d-none')) {
                    $('#edit-slot-input').addClass('d-none');
                }

                $('#edit-image-input').removeClass('d-none');
                $('#edit-url-input').removeClass('d-none');
            } else {
                if (!$('#edit-image-input').hasClass('d-none') && !$('#edit-url-input').hasClass('d-none')) {
                    $('#edit-image-input').addClass('d-none');
                    $('#edit-url-input').addClass('d-none');
                }

                $('#edit-slot-input').removeClass('d-none');
            }
        }

        // focus & blur color picker inputs
        setTimeout(() => {
            $(".jscolor").each(function () {
                $(this).focus();
                $(this).blur();
            });
        }, 300);

    });

    /* ***************************************************
    ==========Form Prepopulate After Clicking Edit Button End==========
    ******************************************************/


    /* ***************************************************
    ==========Form Update with AJAX Request Start==========
    ******************************************************/
    $("#updateBtn").on('click', function (e) {
        $(".request-loader").addClass("show");
        if ($(".edit-iconpicker-component").length > 0) {
            $("#editInputIcon").val($(".edit-iconpicker-component").find('i').attr('class'));
        }
        let ajaxEditForm = document.getElementById('ajaxEditForm');
        let fd = new FormData(ajaxEditForm);
        let url = $("#ajaxEditForm").attr('action');
        let method = $("#ajaxEditForm").attr('method');

        //if summernote has then get summernote content
        $('.form-control').each(function (i) {
            let index = i;

            let $toInput = $('.form-control').eq(index);

            if ($(this).hasClass('summernote')) {
                let tmcId = $toInput.attr('id');
                let content = tinyMCE.get(tmcId).getContent();

                fd.delete($(this).attr('name'));
                fd.append($(this).attr('name'), content);
            }
        });

        $.ajax({
            url: url,
            method: method,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $(".request-loader").removeClass("show");
                $(".em").each(function () {
                    $(this).html('');
                })
                if (data == "success") {
                    location.reload();
                }

                if (data == "banStaff") {

                    var content = {};
                    content.message = 'We regret to inform you that your account has been deactivated.';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    location.reload();
                }

                if (data == "downgrade") {
                    $('.modal').modal('hide');
                    "use strict";
                    var content = {};
                    content.message = 'Your feature limit is reached or over';
                    content.title = "Warning";
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    $("#limitModal").modal('show');
                }

              

                // if error occurs
                else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        if (x == 'error') {
                            continue;
                        }
                        document.getElementById('eerr' + x).innerHTML = data[x][0];
                    }
                }
            },
            error: function (error) {
                $(".em").each(function () {
                    $(this).html('');
                })
                for (let x in error.responseJSON.errors) {
                    document.getElementById('editErr_' + x).innerHTML = error.responseJSON.errors[x][0];
                }
                $(".request-loader").removeClass("show");
                $(e.target).attr('disabled', false);

                if (error?.responseJSON?.exception) {
                    bootnotify(error?.responseJSON?.exception, "Warning", "warning");
                }

            }
        });
    });

    $(".update-btn").each(function () {
        $(this).on('click', function (e) {
            let $this = $(this);

            $(".request-loader").addClass("show");

            let formId = $(this).data('form_id');
            let ajaxEditForm = document.getElementById(formId);
            let fd = new FormData(ajaxEditForm);
            let url = $("#" + formId).attr('action');
            let method = $("#" + formId).attr('method');

            if ($("#" + formId + " .summernote").length > 0) {
                $("#" + formId + " .summernote").each(function (i) {
                    let content = $(this).summernote('code');
                    fd.delete($(this).attr('name'));
                    fd.append($(this).attr('name'), content);
                })
            }


            $.ajax({
                url: url,
                method: method,
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    let parentCount = $this.parents('.modal').length;
                    let parentId;
                    // if the form is in modal
                    if (parentCount > 0) {
                        parentId = $this.parents('.modal').attr('id');
                    }
                    // if the form is not in modal
                    else {
                        parentId = formId;
                    }
                    $(".request-loader").removeClass("show");

                    $("#" + parentId).children(".em").each(function () {
                        $(this).html('');
                    })

                    if (data == "success") {
                        location.reload();
                    }

                    // if error occurs
                    else if (typeof data.error != 'undefined') {
                        for (let x in data) {
                            if (x == 'error') {
                                continue;
                            }
                            $("#" + parentId + " .eerr" + x).html(data[x][0]);
                        }
                    }
                }
            });
        });
    });
    /* ***************************************************
    ==========Form Update with AJAX Request End==========
    ******************************************************/



    /* ***************************************************
    ==========Delete Using AJAX Request Start==========
    ******************************************************/
    $('.deletebtn').on('click', function (e) {
        e.preventDefault();
        $(".request-loader").addClass("show");

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Yes, delete it!',
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
    /* ***************************************************
    ==========Delete Using AJAX Request End==========
    ******************************************************/


    /* ***************************************************
    ==========Close Ticket Using AJAX Request Start==========
    ******************************************************/
    $('.close-ticket').on('click', function (e) {
        e.preventDefault();
        $(".request-loader").addClass("show");
        swal({
            title: 'Are you sure?',
            text: "You want to close this ticket!",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Yes, close it!',
                    className: 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                swal.close();
                $(".request-loader").removeClass("show");
            } else {
                swal.close();
                $(".request-loader").removeClass("show");
            }
        });
    });
    /* ***************************************************
    ==========Delete Using AJAX Request End==========
    ******************************************************/


    /* ***************************************************
    ==========Delete Using AJAX Request Start==========
    ******************************************************/
    $(document).on('change', '.bulk-check', function () {
        let val = $(this).data('val');
        let checked = $(this).prop('checked');

        // if selected checkbox is 'all' then check all the checkboxes
        if (val == 'all') {
            if (checked) {
                $(".bulk-check").each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                $(".bulk-check").each(function () {
                    $(this).prop('checked', false);
                });
            }
        }


        // if any checkbox is checked then flag = 1, otherwise flag = 0
        let flag = 0;
        $(".bulk-check").each(function () {
            let status = $(this).prop('checked');
            if (status) {
                flag = 1;
            }
        });

        // if any checkbox is checked then show the delete button
        if (flag == 1) {
            $(".bulk-delete").addClass('d-inline-block');
            $(".bulk-delete").removeClass('d-none');
        }
        // if no checkbox is checked then hide the delete button
        else {
            $(".bulk-delete").removeClass('d-inline-block');
            $(".bulk-delete").addClass('d-none');
        }
    });

    $('.bulk-delete').on('click', function () {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Yes, delete it!',
                    className: 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $(".request-loader").addClass('show');
                let href = $(this).data('href');
                let ids = [];

                // take ids of checked one's
                $(".bulk-check:checked").each(function () {
                    if ($(this).data('val') != 'all') {
                        ids.push($(this).data('val'));
                    }
                });

                let fd = new FormData();
                for (let i = 0; i < ids.length; i++) {
                    fd.append('ids[]', ids[i]);
                }

                $.ajax({
                    url: href,
                    method: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $(".request-loader").removeClass('show');
                        if (data == "success") {
                            location.reload();
                        }
                    }
                });
            } else {
                swal.close();
            }
        });

    });
    /* ***************************************************
    ==========Delete Using AJAX Request End==========
    ******************************************************/

    /* ***************************************************
  ==========bootstrap datepicker start==========
  ******************************************************/
    $('.datepicker').datepicker({
        autoclose: true
    });
    /* ***************************************************
    ==========bootstrap datepicker end==========
    ******************************************************/



    //  image (id) preview js/
    $(document).on('change', '#image', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.showImage img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    })
    //  background image (id) preview js/
    $(document).on('change', '#backgroundImage', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.showBackgroundImage img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    })
    //  image (class) preview js/
    $(document).on('change', '.image', function (event) {
        let $this = $(this);
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $this.prev('.showImage').children('img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    });

    // datepicker & timepicker
    $("input.pickupdatepicker").datepicker({
        minDate: 0,
 
    });
    $('input.timepicker').timepicker();

    // select2
    $('.select2').select2();

    $("#langBtn").on('click', function () {
        $("#langForm").trigger("submit");
    });


    var pusher = new Pusher(pusherAppKey, {
        cluster: pusherCluster,
    });

    var waiterCallChannel = pusher.subscribe('waiter-called-channel');
    waiterCallChannel.bind('waiter-called-event', function (data) {
        waiterCallAudio.play();

        // show notification
        var content = {};

        content.message = '<strong class="text-danger">Table - ' + data.table + '</strong> is calling for a waiter.';
        content.title = 'Call for a waiter!';
        content.icon = 'fa fa-bell';

        $.notify(content, {
            type: 'secondary',
            placement: {
                from: 'top',
                align: 'right'
            },
            delay: 0,
        });
    });
});


/* ******************** *******************************
==========Form Submit with AJAX Request Start==========
******************************************************/
$("#submitFeatureSectionBtn").on('click', function (e) {
    $(e.target).attr('disabled', true);
    $(".request-loader").addClass("show");
    let ajaxForm = document.getElementById('featureSectionForm');
    let fd = new FormData(ajaxForm);
    let url = $("#featureSectionForm").attr('action');
    let method = $("#featureSectionForm").attr('method');

    $.ajax({
        url: url,
        method: method,
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
            $(e.target).attr('disabled', false);
            $(".request-loader").removeClass("show");

            $(".em").each(function () {
                $(this).html('');
            })

            if (data == "success") {
                location.reload();
            }
            // if error occurs
            else if (typeof data.error != 'undefined') {
                for (let x in data) {
                    if (x == 'error') {
                        continue;
                    }
                    document.getElementById('err' + x).innerHTML = data[x][0];
                }
            } else if (data?.errors?.error) {
                const errors = data?.errors;
                Object.keys(errors).map(function (key) {
                    if (key !== 'error')
                        document.getElementById('err' + key).innerHTML = errors[key][0];
                });
            }
        },
        error: function (error) {
            $(".em").each(function () {
                $(this).html('');
            })
            for (let x in error.responseJSON.errors) {
                document.getElementById('err' + x).innerHTML = error.responseJSON.errors[x][0];
            }
            $(".request-loader").removeClass("show");
            $(e.target).attr('disabled', false);
            if (error?.responseJSON?.exception) {
                bootnotify(error?.responseJSON?.exception, "Warning", "warning");
            }
        }
    });
});
