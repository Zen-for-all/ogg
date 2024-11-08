$(document).ready(function(){
  /* Show/hide blocks & buttons in edit_ld section */
  $('.edit_ld_btn').click(function(){
    if (!$(this).hasClass('edit_ld_btn_active')) {
      // Restart styles for the edit_ld section
      $('.edit_ld_btn span:nth-child(1)').addClass('show').removeClass('hide'); // Show first span
      $('.edit_ld_btn span:nth-child(2)').addClass('hide').removeClass('show'); // Hide second span
      $('.ld_info').addClass('show').removeClass('hide'); // Show ld_info block
      $('.edit_ld_form').removeClass('show').addClass('hide'); // Hide edit_ld_form block
      $('.delete_ld').addClass('show').removeClass('hide'); // Show delete_ld block
    }

    // Toggle active state and visibility of elements
    $(this).toggleClass('edit_ld_btn_active'); // Toggle active class on button
    $(this).find('span').toggleClass('show').toggleClass('hide'); // Toggle show/hide classes on spans
    $(this).parent().find('.ld_info').toggleClass('show').toggleClass('hide'); // Toggle visibility of ld_info
    $(this).parent().find('.edit_ld_form').toggleClass('show').toggleClass('hide'); // Toggle visibility of edit_ld_form
    $(this).parent().find('.delete_ld').toggleClass('show').toggleClass('hide'); // Toggle visibility of delete_ld
  });

  /* Show/hide blocks & buttons in edit_location section */
  $('.edit_location_btn').click(function(){
    // Toggle the 'edit_location_btn_active' class on the closest card element
    if ($(this).closest('.card').hasClass('edit_location_btn_active')) {
      $('.card').removeClass('edit_location_btn_active'); // Remove active class from all cards
    } else {
      $('.card').removeClass('edit_location_btn_active'); // Remove active class from all cards
      $(this).closest('.card').addClass('edit_location_btn_active'); // Add active class to clicked card
    }

    // Hide any elements with the 'block_hide' class
    $('.block_hide').removeClass('show').addClass('hide');
  });

  // Show/hide elements with 'block_hide' class on button click
  $('.btn_show').click(function(){
    $('.card').removeClass('edit_location_btn_active'); // Remove active class from all cards
    $(this).parent().find('.block_hide').toggleClass('show').toggleClass('hide'); // Toggle visibility of block_hide
  });

  // Toggle visibility of the year-chart section on title click
  $('.year-chart-wrap-title').on('click', function() {
    $(this).toggleClass('year-chart-wrap-title-show'); // Toggle class to show/hide title
    $(this).next('.year-chart-wrap').toggleClass('year-chart-wrap-show'); // Toggle class to show/hide chart wrap
  });
});
