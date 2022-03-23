/******/ (() => {
  // webpackBootstrap
  var __webpack_exports__ = {};
  /*!***********************************************!*\
  !*** ./resources/assets/js/scripts/script.js ***!
  \***********************************************/
  // Hamburger menu
  var burger = document.getElementById('hamburger');
  var nav = document.getElementById('nav-list');
  burger.addEventListener('click', function () {
    nav.classList.toggle('nav-active');
    burger.classList.toggle('active');
    document.body.classList.toggle('overflow-hidden');
  }); // close the navMenu by clicking outside

  document.addEventListener('click', function (e) {
    if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
      nav.classList.remove('nav-active');
      burger.classList.remove('active');
      document.body.classList.remove('overflow-hidden');
    }
  }); // Active class

  var menuItem = document.querySelectorAll('.languages a');
  var menuLength = menuItem.length;

  var _loop = function _loop(i) {
    menuItem[i].addEventListener('click', function (e) {
      for (var j = 0; j < menuLength; j += 1) {
        if (menuItem[i] !== menuItem[j]) {
          menuItem[j].classList.remove('nav__active');
          menuItem[j].classList.remove('links__active');
        }
      }

      e.stopPropagation();
      e.currentTarget.classList.add('nav__active');
      e.currentTarget.classList.add('links__active');
    });
  };

  for (var i = 0; i < menuLength; i += 1) {
    _loop(i);
  }
  /******/
})();
