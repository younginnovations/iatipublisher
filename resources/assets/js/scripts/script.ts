import $ from 'jquery';
import jQuery from 'jquery';
import 'select2';

jQuery(function () {
  $('body').on('click', '#hamburger', () => {
    $('#nav-list').toggleClass('nav-active');
    $('#hamburger').toggleClass('active');
    $('body').toggleClass('overflow-hidden');
  });

  // close the navMenu by clicking outside
  $('body').on('click', (e) => {
    if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
      $('#nav-list').removeClass('nav-active');
      $('#hamburger').removeClass('active');
      $('body').removeClass('overflow-hidden');
    }
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
