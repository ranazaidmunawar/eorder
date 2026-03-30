
"use strict";

function getSubCategory(selectObject) {
  const catId = selectObject.value;
  const targetId = selectObject.id.replace('_category_id', '') + '_subcategory_id';
  const langId = targetId.match(/\d+/)[0];
  $(".request-loader").addClass("show");

  $.get(mainurl + "/user/product/" + catId + "/getSubcategory/" + langId, function (data) {
    let options = `<option value="" selected>Select Subcategory</option>`;
    for (let i = 0; i < data.length; i++) {
      options += `<option value="${data[i].id}">${data[i].name}</option>`;
    }
    $("#" + targetId).html(options);
    $(".request-loader").removeClass("show");
  });
}

var rpItemNode = '';
var option = '';


var addItem = function (key) {
  rpItemNode = '';
  let it = $(".js-repeater-item:last-child").index() + 1;

  rpItemNode += `<div class="js-repeater-item" data-item="${it}">
                        <div class="mb-3 row align-items-end">`
  for (var Itemkey in languages) {
    rpItemNode += `<div class="col-3" >
                            <label for="form" class="form-label mb-1">Variation Name (In ${languages[Itemkey].code})</label>
                            <div class=" mb-2">
                                <input type="text" required class="form-control" placeholder="" name="${languages[Itemkey].code}_variation_${it}">
                                <input type="hidden" name="variation_helper[]" value="${it}">
                            </div>
                            </div>`
  }
  rpItemNode += `<button class="btn btn-danger btn-sm js-repeater-remove mb-2 mr-2" type="button"
                                        onclick="$(this).parents('.js-repeater-item').remove()">X</button>
                                <button class="btn btn-success btn-sm js-repeater-child-add mb-2" type="button" data-it="${it}">Add Option</button>
                            <div class="repeater-child-list mt-2 col-12" id="options${it}"></div>
                        </div>
                    </div>`;
  $("#js-repeater-container").append(rpItemNode);
};

var repeater = $(".js-repeater");
var repeaterAddon = $(".js-repeater-addon");
var key = 0;
var addBtn = repeater.find('.js-repeater-add');
var items = $(".js-repeater-item");
var it = $(".js-repeater-item").index();


if (key <= 0) {

  addBtn.on("click", function () {
    key++;
    addItem(key, it);
  });
}

$(document).on('click', '.js-repeater-child-add', function () {
  option = ''
  let it = $(this).data('it');
  let cit = $(this).parent().find(".repeater-child-item:last-child").index();

  let parent = $(this).parent().find("#options" + it);

  option += `<div class="repeater-child-item mb-3" id="options${it + '' + cit}">
                <div class="row align-items-start">`
  for (var optionkey in languages) {
    option += `<div class="col-2 ">
                        <label for="form" class="form-label mb-1">Option Name (In ${languages[optionkey].code})</label>
                        <input required name="${languages[optionkey].code}_options1_${it}[]" type="text" class="form-control"
                            placeholder="">
                    </div>`
  }
  option += `<div class="col-2 ">
                        <label for="form" class="form-label mb-1">Price (${symbol})</label>
                        <input required name="options2_${it}[]" type="text" class="form-control" value="0" placeholder="0">
    
                    </div>
                   
                    <div class="col-2">
                        <button class="btn btn-danger js-repeater-child-remove btn-sm" type="button"
                            onclick="$(this).parents('.repeater-child-item').remove()">X</button>
                    </div>
                    
                </div>`;
  $(parent).append(option);
})



$(document).on('click', '.js-repeater-addon-add', function () {

  option = ''

  let it = $(".js-repeater-item-addon:last-child").index() + 1;
  let parent = $(this).parent().find("#addonDiv" + it);


  option += `<div class=" mb-3 js-repeater-item js-repeater-item-addon " id="addonDiv${it}">
                <div class="mb-3 row align-items-end">`
  for (var optionkey in languages) {
    option += `<div class="col-3 ">
                       
                        <label for="form" class="form-label mb-1">Addon Name (In ${languages[optionkey].code})</label>
                         <div class="mb-2">
                        <input required name="${languages[optionkey].code}_addonoptions1_${it}[]" type="text" class="form-control"
                            placeholder="">
                            <input type="hidden" name="addon_variation_helper[]" value="${it}">
                         </div>   
                    </div>`
  }
  option += `<div class="col-2 ">
                        <label for="form" class="form-label mb-1">Price (${symbol})</label>
                         <div class="mb-2">
                        <input required name="addonoptions2_${it}[]" type="text" class="form-control" value="0" placeholder="0">
                       </div>
                       </div>
                       
                        <div class="col-2">
                        <button class="btn btn-danger mb-2 js-repeater-child-remove btn-sm" type="button"
                            onclick="$(this).parents('.js-repeater-item-addon').remove()">X</button>
                    </div>
                   
                </div>`;
  $('#js-repeater-container-addon').append(option);
})

$('body').on('click', '.addon-remove', function () {

})



