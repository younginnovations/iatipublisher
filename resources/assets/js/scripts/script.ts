import $ from 'jquery';

$(document).ready(() => {

  $(window).resize(() => {
    $('body').on('click', '#hamburger', () => {
      $('#nav-list').toggleClass('nav-active');
      $('#hamburger').toggleClass('active');
      $('body').toggleClass('overflow-hidden');
    });

    // close the navMenu by clicking outside
    $('body').on('click', 'window', (e) => {
      if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
        $('#nav-list').removeClass('nav-active');
        $('#hamburger').removeClass('active');
        $('body').removeClass('overflow-hidden');
      }
    });
  });

});
