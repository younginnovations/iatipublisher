import $ from 'jquery';
import jQuery from 'jquery';

jQuery(function () {
  console.log(';inside');
  // $('#hamburger-cross').on('click', function () {
  //   console.log('abc');
  //   // $('#elementToRemoveClass').removeClass('example-class');
  // });

  $('body').on('click', '#hamburger', () => {
    $('#nav-list').toggleClass('nav-active');
    $('#hamburger').toggleClass('active');
    $('body').toggleClass('overflow-hidden');
    $('#menu-overlay').toggleClass('menu-overlay');
    $('#activity-menu-overlay').toggleClass('menu-overlay');
  });

  // close the navMenu by clicking outside
  $('body').on('click', (e) => {
    console.log('outside click');
    if (e.target.classList[0] == 'menu-overlay') {
      $('#nav-list').removeClass('nav-active');
      $('#hamburger').removeClass('active');
      $('body').removeClass('overflow-hidden');
      $('#menu-overlay').removeClass('menu-overlay');
      $('#activity-menu-overlay').removeClass('menu-overlay');
    }
  });

  const sidebarBlock = $('.sidebar-help-block');
  $(document).on('click', '.help-button', function () {
    sidebarBlock.removeClass('hidden');
    const sidebarContent = $(this).siblings('.help-button-content').html();
    $('.sidebar-help-block-text').html(sidebarContent);
  });

  $('.sidebar-help-close').on('click', () => {
    sidebarBlock.addClass('hidden');
  });
});

// remove overlay page loader after loading completes
$(window).on('load', function () {
  const overlay = $('.overlay');
  overlay.addClass('hidden');
});

/**
 * Disable submit button after single  click
 */
const submitBtn = 'form button[type="submit"]',
  submitBtnElement = $(submitBtn);

if (submitBtnElement.length > 0) {
  $('body').on('click', submitBtn, function () {
    $(this).attr('disabled', 'disabled');
    $(this).closest('form').trigger('submit');
  });
}
