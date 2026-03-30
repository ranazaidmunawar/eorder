$(function ($) {

  "use strict";

  $(document).on('change', '#cover_image', function (event) {
    let file = event.target.files[0];
    let reader = new FileReader();
    reader.onload = function (e) {
      $('.coverImg img').attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
  })

  $(document).on('change', '#intro_main_image', function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      $('.showIntroMainImage img').attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
  })
  $(document).on('change', '#intro_signature', function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      $('.showImage img').attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
  })
  $(document).on('change', '#intro_video_image', function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      $('.intro_video_image img').attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
  })

  $(document).ready(function () {
    const today = new Date();
    $("#deadline").datepicker({
      autoclose: true,
      endDate: today,
      todayHighlight: true
    });
  });

  $(".remove-image").on('click', function (e) {
    e.preventDefault();
    $(".request-loader").addClass("show");

    let type = $(this).data('type');
    let fd = new FormData();
    fd.append('type', type);
    fd.append('language_id', langCode);
    if (typeof feature_id !== 'undefined'){
      fd.append('feature_id', feature_id);
    }
    if (typeof pcategory_id !== 'undefined') {
      fd.append('pcategory_id', pcategory_id);
    }

    $.ajax({
      url: routeUrl,
      data: fd,
      type: 'POST',
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "success") {
          window.location = currentUrl + '?language=' + langCode;
        }
      }
    })
  });

  function toggleMessage(status) {
    if (status == 1) {
      $("#message").show();
    } else {
      $("#message").hide();
    }
  }

  $(document).ready(function () {
    $('.ordertimepicker').mdtimepicker();

    toggleMessage($("select[name='order_close']").val());

    $("select[name='order_close']").on('change', function () {
      let status = $(this).val();
      toggleMessage(status);
    });
  });

  $(document).ready(function () {
    $(".addTF").on('click', function (e) {
      e.preventDefault();
      $("#createModal").modal('show');
      $("input[name='day']").val($(this).data('day'));
    })
  });

  $("#sortable").sortable({
    stop: function (event, ui) {
      $(".request-loader").addClass('show');
      let fd = new FormData();
      $(".ui-state-default.ui-sortable-handle").each(function (index) {
        fd.append('ids[]', $(this).data('id'));
        let order = parseInt(index) + 1
        fd.append('orders[]', order);
      });
      $.ajax({
        url: orderUpdateRoute,
        method: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
          $(".request-loader").removeClass('show');

        }
      })
    }
  });
  $("#sortable").disableSelection();

}); 

// Handle both top and bottom feature image uploads and remove in the feature section added by rakib

$(document).ready(function () {
  // Initialize shape image preview containers
  $('.shape-image-preview').each(function () {
    const container = $(this);
    const defaultImage = container.data('default-image');

    if (container.find('.shape-preview-img').length === 0) {
      container.append(`
        <img src="${defaultImage}" 
             alt="Default Shape Image" 
             class="img-thumbnail shape-preview-img">
      `);
    }
  });

  // Handle shape image preview upload
  $('input.shape-image-upload').on('change', function () {
    const file = this.files[0];
    const previewContainer = $(this).siblings('.shape-image-preview');
    const inputName = $(this).attr('name');
    const defaultImage = previewContainer.data('default-image');

    if (file) {
      const reader = new FileReader();

      reader.onload = function (e) {
        // Clear previous content
        previewContainer.find('.shape-preview-img').remove();
        previewContainer.find('.remove-shape-image').remove();

        // Add delete icon
        const deleteIcon = `
          <a class="remove-shape-image" 
             data-type="${inputName}" 
             data-default-image="${defaultImage}" 
             style="cursor: pointer; position: absolute; top: 5px; right: 5px; z-index: 10;">
            <i class="far fa-times-circle text-danger"></i>
          </a>
        `;
        previewContainer.prepend(deleteIcon);

        // Add the new uploaded image
        const imgPreview = `
          <img src="${e.target.result}" 
               alt="Shape Preview" 
               class="img-thumbnail shape-preview-img"
               style="display: block;">
        `;
        previewContainer.append(imgPreview);
      };

      reader.readAsDataURL(file);
    }
  });

  // Handle shape image delete
  $(document).on('click', '.remove-shape-image', function (e) {
    e.preventDefault();
    const inputName = $(this).data('type');
    const defaultImage = $(this).data('default-image');
    const previewContainer = $(this).closest('.shape-image-preview');

    // Clear the file input
    $(`input[name="${inputName}"]`).val('');

    // Remove all content
    previewContainer.empty();

    // Restore default image
    previewContainer.append(`
      <img src="${defaultImage}" 
           alt="Default Shape Image" 
           class="img-thumbnail shape-preview-img">
    `);
  });
});
