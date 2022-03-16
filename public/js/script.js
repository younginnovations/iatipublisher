/******/ (() => {
  // webpackBootstrap
  var __webpack_exports__ = {};
  /*!***********************************************!*\
  !*** ./resources/assets/js/scripts/script.js ***!
  \***********************************************/
  // Hamburger Menu
  var navSlide = function navSlide() {
    var nav = document.querySelector('.nav__list');
    var burger = document.querySelector('.hamburger');
    burger.addEventListener('click', function () {
      nav.classList.toggle('nav-active');
      burger.classList.toggle('active');
    });
  };

  navSlide(); // Active

  var currentLocation = location.href;
  var menuItem = document.querySelectorAll('.languages a');
  var menuLength = menuItem.length;

  var _loop = function _loop(i) {
    menuItem[i].addEventListener('click', function (e) {
      for (var j = 0; j < menuLength; j++) {
        if (menuItem[i] !== menuItem[j]) {
          menuItem[j].classList.remove('nav__active');
        }
      } // console.log(this);

      e.preventDefault();
      this.classList.add('nav__active');
    });
  };

  for (var i = 0; i < menuLength; i++) {
    _loop(i);
  } // const dropdown = document.querySelector('.dropdown__content')
  // dropdown.addEventListener ('click', ()=>{
  //   dropdown.style.display = "block"
  // })
  // for (let k = 0; k<menuLength; k++) {
  //     if (menuItem[k].href === currentLocation) {
  //         menuItem[k].className = "links__active"
  //     }
  // }
  /******/
})();
