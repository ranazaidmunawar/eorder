"use strict";

WebFont.load({
  google: {"families": ["Lato:300,400,700,900"]},
  custom: {"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: [mainurl + '/assets/admin/css/fonts.min.css']},
  active: function() {
    sessionStorage.fonts = true;
  }
});

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

  $(".sidebar-search").on('input', function() {
    let term = $(this).val().toLowerCase();
    
    if (term.length > 0) {
      $(".sidebar ul li.nav-item").each(function(i) {
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
          $mainMenu.find('span.sub-item').each(function(i) {
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
  ==========bootstrap datepicker start==========
  ******************************************************/
  $('.datepicker').datepicker({
    autoclose: true
  });
  /* ***************************************************
  ==========bootstrap datepicker end==========
  ******************************************************/



  /* ***************************************************
  ==========fontawesome icon picker start==========
  ******************************************************/
  // fontawesome icon picker start
  $('.icp-dd').iconpicker();
  // fontawesome icon picker end
  $('.icp').on('iconpickerSelected', function(event){
    $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
  });
  /* ***************************************************
  ==========fontawesome icon picker upload end==========
  ******************************************************/


  /* ***************************************************
  ==========Summernote initialization start==========
  ******************************************************/
  $(".summernote").each(function (i) {
    let height;
    let summernote = $(this);
    if ($(this).data('height')) {
      height = $(this).data('height');
    } else {
      height = 200;
    }
    $('.summernote').eq(i).summernote({
      height,
      dialogsInBody: true,
      dialogsFade: false,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['height', ['height']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']],
      ],
      popover: {
        image: [
          ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
          ['float', ['floatLeft', 'floatRight', 'floatNone']],
          ['remove', ['removeMedia']]
        ],
        link: [
          ['link', ['linkDialogShow', 'unlink']]
        ],
        table: [
          ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
          ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
        ],
        air: [
          ['color', ['color']],
          ['font', ['bold', 'underline', 'clear']],
          ['para', ['ul', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture']]
        ]
      },
      callbacks: {
        onImageUpload: function (files) {
          $(".request-loader").addClass('show');
          let fd = new FormData();
          fd.append('image', files[0]);
          $.ajax({
            url: imgupload,
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
              summernote.summernote('insertImage', data);
              $(".request-loader").removeClass('show');
            }
          });
        }
      }
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
  $('.icp').on('iconpickerSelected', function(event){
    $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
  });


  /* ***************************************************
  ==========Summernote initialization end==========
  ******************************************************/



  /* ***************************************************
  ==========Bootstrap Notify start==========
  ******************************************************/
  function bootnotify(message, title, type){
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

    if ($("#ajaxForm .summernote").length > 0) {
      $("#ajaxForm .summernote").each(function (i) {
        let content = $(this).summernote('isEmpty') ? '' : $(this).summernote('code');
        fd.delete($(this).attr('name'));
        fd.append($(this).attr('name'), content);
      });
    }

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
        if (data == "success"){
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
        }else if(data?.errors?.error){
          const errors = data?.errors;
          Object.keys(errors).map(function(key) {
            if(key !== 'error')
            document.getElementById('err' + key).innerHTML = errors[key][0];
          });
        }
      },
      error: function (error){
        $(".em").each(function () {
          $(this).html('');
        })
        for (let x in error.responseJSON.errors) {
          document.getElementById('err' + x).innerHTML = error.responseJSON.errors[x][0];
        }
        $(".request-loader").removeClass("show");
        $(e.target).attr('disabled', false);
        if(error?.responseJSON?.exception) {
          bootnotify(error?.responseJSON?.exception, "Warning", "warning");
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
    ordering: false
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
        $("#in" + x).summernote('code', datas[x]);
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

    if ($("#ajaxEditForm .summernote").length > 0) {
      $("#ajaxEditForm .summernote").each(function (i) {
        let content = $(this).summernote('isEmpty') ? '' : $(this).summernote('code');
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
            document.getElementById('eerr' + x).innerHTML = data[x][0];
          }
        }
      },
      error: function (error){
        $(".em").each(function () {
          $(this).html('');
        })
        for (let x in error.responseJSON.errors) {
          document.getElementById('editErr_' + x).innerHTML = error.responseJSON.errors[x][0];
        }
        $(".request-loader").removeClass("show");
        $(e.target).attr('disabled', false);
        if(error?.responseJSON?.exception) {
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
  $("input.datepicker").datepicker();
  $('input.timepicker').timepicker();

  // select2
  $('.select2').select2();

  $("#langBtn").on('click', function () {
    $("#langForm").trigger("submit");
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

      if (data == "success"){
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
      }else if(data?.errors?.error){
        const errors = data?.errors;
        Object.keys(errors).map(function(key) {
          if(key !== 'error')
            document.getElementById('err' + key).innerHTML = errors[key][0];
        });
      }
    },
    error: function (error){
      $(".em").each(function () {
        $(this).html('');
      })
      for (let x in error.responseJSON.errors) {
        document.getElementById('err' + x).innerHTML = error.responseJSON.errors[x][0];
      }
      $(".request-loader").removeClass("show");
      $(e.target).attr('disabled', false);
      if(error?.responseJSON?.exception) {
        bootnotify(error?.responseJSON?.exception, "Warning", "warning");
      }
    }
  });
});
