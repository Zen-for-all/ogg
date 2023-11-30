$(document).ready(function(){
  /* show/hide blocks & buttons in edit_ld section */
  $('.edit_ld_btn').click(function(){
    if (!$(this).hasClass('edit_ld_btn_active')) {
      // restart styles
      $('.edit_ld_btn span:nth-child(1)').addClass('show').removeClass('hide');
      $('.edit_ld_btn span:nth-child(2)').addClass('hide').removeClass('show');
      $('.ld_info').addClass('show').removeClass('hide');
      $('.edit_ld_form').removeClass('show').addClass('hide');
      $('.delete_ld').addClass('show').removeClass('hide');
    }

    $(this).toggleClass('edit_ld_btn_active');
    $(this).find('span').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.ld_info').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.edit_ld_form').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.delete_ld').toggleClass('show').toggleClass('hide');
  });

  /* show/hide blocks & buttons in edit_location section */
  $('.edit_location_btn').click(function(){
    if (!$(this).hasClass('edit_location_btn_active')) {
      // restart styles
      $('.edit_location_btn span:nth-child(1)').addClass('show').removeClass('hide');
      $('.edit_location_btn span:nth-child(2)').addClass('hide').removeClass('show');
      $('.location_info').addClass('show').removeClass('hide');
      $('.edit_location_form').removeClass('show').addClass('hide');
      $('.delete_location').addClass('show').removeClass('hide');
    }

    $(this).toggleClass('edit_location_btn_active');
    $(this).find('span').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.location_info').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.edit_location_form').toggleClass('show').toggleClass('hide');
    $(this).parent().find('.delete_location').toggleClass('show').toggleClass('hide');
  });
});