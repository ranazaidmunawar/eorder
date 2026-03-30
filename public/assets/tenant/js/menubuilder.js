$(function ($) {

  "use strict";

  function disableWithUrl() {
    $("#withUrl input").removeClass('item-menu');
    $("#withUrl select").removeClass('item-menu');
  }

  function enableWithUrl() {
    $("#withUrl input").addClass('item-menu');
    $("#withUrl select").addClass('item-menu');
  }

  function disableWithoutUrl() {
    $("#withoutUrl input").removeClass('item-menu');
    $("#withoutUrl select").removeClass('item-menu');
  }

  function enableWithoutUrl() {
    $("#withoutUrl input").addClass('item-menu');
    $("#withoutUrl select").addClass('item-menu');
  }

  

  $('#btnOutput').on('click', function () {
    var str = editor.getString();
    let fd = new FormData();
    fd.append('str', str);
    fd.append('language_id', langId);

  $.ajax({
    url: menuRoute,
    type: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: function (data) {
      const {
        status
      } = data;
      if (status === "success") {
        bootnotify(data?.message, 'Success!', 'success');
      } else {
        bootnotify(data?.message, 'Warning!', 'warning');
      }
    }
  });
});

  $("#btnUpdate").click(function () {
    disableWithoutUrl();
    editor.update();
    enableWithoutUrl();
  });

  $('#btnAdd').click(function () {
    disableWithoutUrl();
    $("input[name='type']").val('custom');
    editor.add();
    enableWithoutUrl();
  });

  $(".addToMenus").on('click', function (e) {
    e.preventDefault();
    disableWithUrl();
    $("input[name='type']").val($(this).data('type'));
    $("#withoutUrl input[name='text']").val($(this).data('text'));
    $("#withoutUrl input[name='target']").val('_self');
    editor.add();
    enableWithUrl();
  });

  
});
