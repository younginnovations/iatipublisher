import $ from 'jquery';
// $ = require('jquery');

// export function helloWorld(): string {
//   console.log('hey');
//   return "Hello world!";
// }

// helloWorld();

$(document).ready(() => {
  $(window).resize(() => {
    // Hamburger menu
    const burger = $('#hamburger');
    const nav = $('#nav-list');

    $('body').on('click', '#hamburger', () => {
      // console.log('clicked');
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

  // Active class
  // const menuItem = $('.languages a');
  // const menuLength = menuItem.length;

  // for (let i = 0; i < menuLength; i += 1) {
  // menuItem[i].addEventListener('click', (e) => {
  // for (let j = 0; j < menuLength; j += 1) {
  // if (menuItem[i] !== menuItem[j]) {
  // menuItem[j].removeClass('nav__active');
  // menuItem[j].removeClass('links__active');
  // }
  // }
  // e.stopPropagation();
  // e.currentTarget.addClass('nav__active');
  // e.currentTarget.addClass('links__active');
  // });
  // }
});
