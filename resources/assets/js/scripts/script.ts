import $ from 'jquery';
import 'select2';

$(document).ready(() => {
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

window.onpopstate = function (event) {
  console.log('here', document.location);
  event.preventDefault();

  // console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
};
