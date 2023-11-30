$(document).ready(function(){
  // show/hide blocks & buttons in edit_ld section
  $('.edit_ld_btn').click(function(){
    $(this).find('span').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.ld_info').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.edit_ld_form').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.delete_ld').toggleClass('show').toggleClass('hide');
  });

  // show/hide blocks & buttons in edit_location section
  $('.edit_location_btn').click(function(){
    $(this).find('span').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.location_info').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.edit_location_form').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.delete_location').toggleClass('show').toggleClass('hide');
  });
});