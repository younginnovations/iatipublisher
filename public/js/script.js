/******/ (() => {
  // webpackBootstrap
  var __webpack_exports__ = {};
  /*!***********************************************!*\
  !*** ./resources/assets/js/scripts/script.js ***!
  \***********************************************/
  // Hamburger menu
  var burger = document.getElementById('hamburger');
  var nav = document.getElementById('nav-list');
  burger.addEventListener('click', function (e) {
    nav.classList.toggle('nav-active');
    burger.classList.toggle('active');
  });
  document.addEventListener('click', function (e) {
    if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
      nav.classList.remove('nav-active');
      burger.classList.remove('active');
    }
  }); // Active class

  var menuItem = document.querySelectorAll('.languages a');
  var menuLength = menuItem.length;

  var _loop = function _loop(i) {
    menuItem[i].addEventListener('click', function (e) {
      for (var j = 0; j < menuLength; j++) {
        if (menuItem[i] !== menuItem[j]) {
          menuItem[j].classList.remove('nav__active');
          menuItem[j].classList.remove('links__active');
        }
      }

      e.stopPropagation(); // e.preventDefault();

      this.classList.add('nav__active');
      this.classList.add('links__active');
    });
  };

  for (var i = 0; i < menuLength; i++) {
    _loop(i);
  }
  /******/
})();
