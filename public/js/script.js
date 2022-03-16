/******/ (() => {
  // webpackBootstrap
  var __webpack_exports__ = {};
  /*!***********************************************!*\
  !*** ./resources/assets/js/scripts/script.js ***!
  \***********************************************/
  var navSlide = function navSlide() {
    var nav = document.querySelector('.nav__list');
    var burger = document.querySelector('.hamburger');
    burger.addEventListener('click', function () {
      nav.classList.toggle('nav-active');
      burger.classList.toggle('active');
    });
  };

  navSlide();
  /******/
})();
