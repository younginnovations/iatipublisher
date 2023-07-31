import $ from 'jquery';
import jQuery from 'jquery';

jQuery(function () {
  $('body').on('click', '#hamburger', () => {
    $('#nav-list').toggleClass('nav-active');
    $('#hamburger').toggleClass('active');
    $('body').toggleClass('overflow-hidden');
    $('#menu-overlay').toggleClass('menu-overlay');
    $('#activity-menu-overlay').toggleClass('menu-overlay');
  });

  $('body').on('click', '#hamburger-cross', () => {
    $('#nav-list').removeClass('nav-active');
    $('#hamburger').removeClass('active');
    $('body').removeClass('overflow-hidden');
    $('#menu-overlay').removeClass('menu-overlay');
    $('#activity-menu-overlay').removeClass('menu-overlay');
  });

  // close the navMenu by clicking outside
  $('body').on('click', (e) => {
    if (e.target.classList[0] === 'menu-overlay') {
      $('#nav-list').removeClass('nav-active');
      $('#hamburger').removeClass('active');
      $('body').removeClass('overflow-hidden');
      $('#menu-overlay').removeClass('menu-overlay');
      $('#activity-menu-overlay').removeClass('menu-overlay');
    }
  });
});
