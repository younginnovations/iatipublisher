"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/webportal-script"],{

/***/ "./resources/assets/js/scripts/webportal-script.ts":
/*!*********************************************************!*\
  !*** ./resources/assets/js/scripts/webportal-script.ts ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, exports, __webpack_require__) {



var __importDefault = this && this.__importDefault || function (mod) {
  return mod && mod.__esModule ? mod : {
    "default": mod
  };
};

Object.defineProperty(exports, "__esModule", ({
  value: true
}));

var jquery_1 = __importDefault(__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"));

var jquery_2 = __importDefault(__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"));

(0, jquery_2["default"])(function () {
  (0, jquery_1["default"])('body').on('click', '#hamburger', function () {
    (0, jquery_1["default"])('#nav-list').toggleClass('nav-active');
    (0, jquery_1["default"])('#hamburger').toggleClass('active');
    (0, jquery_1["default"])('body').toggleClass('overflow-hidden');
    (0, jquery_1["default"])('#menu-overlay').toggleClass('menu-overlay');
    (0, jquery_1["default"])('#activity-menu-overlay').toggleClass('menu-overlay');
  });
  (0, jquery_1["default"])('body').on('click', '#hamburger-cross', function () {
    (0, jquery_1["default"])('#nav-list').removeClass('nav-active');
    (0, jquery_1["default"])('#hamburger').removeClass('active');
    (0, jquery_1["default"])('body').removeClass('overflow-hidden');
    (0, jquery_1["default"])('#menu-overlay').removeClass('menu-overlay');
    (0, jquery_1["default"])('#activity-menu-overlay').removeClass('menu-overlay');
  }); // close the navMenu by clicking outside

  (0, jquery_1["default"])('body').on('click', function (e) {
    if (e.target.classList[0] === 'menu-overlay') {
      (0, jquery_1["default"])('#nav-list').removeClass('nav-active');
      (0, jquery_1["default"])('#hamburger').removeClass('active');
      (0, jquery_1["default"])('body').removeClass('overflow-hidden');
      (0, jquery_1["default"])('#menu-overlay').removeClass('menu-overlay');
      (0, jquery_1["default"])('#activity-menu-overlay').removeClass('menu-overlay');
    }
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/assets/js/scripts/webportal-script.ts")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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cy9hc3NldHMvanMvc2NyaXB0cy93ZWJwb3J0YWwtc2NyaXB0LnRzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xudmFyIGpxdWVyeV8yID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xuKDAsIGpxdWVyeV8yLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnI2hhbWJ1cmdlcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS50b2dnbGVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNoYW1idXJnZXInKS50b2dnbGVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnRvZ2dsZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykudG9nZ2xlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eS1tZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJyNoYW1idXJnZXItY3Jvc3MnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykucmVtb3ZlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5yZW1vdmVDbGFzcygnb3ZlcmZsb3ctaGlkZGVuJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI21lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgIH0pO1xuICAgIC8vIGNsb3NlIHRoZSBuYXZNZW51IGJ5IGNsaWNraW5nIG91dHNpZGVcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICBpZiAoZS50YXJnZXQuY2xhc3NMaXN0WzBdID09PSAnbWVudS1vdmVybGF5Jykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS5yZW1vdmVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykucmVtb3ZlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTtcbiJdLCJuYW1lcyI6WyJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJleHBvcnRzIiwidmFsdWUiLCJqcXVlcnlfMSIsInJlcXVpcmUiLCJqcXVlcnlfMiIsIm9uIiwidG9nZ2xlQ2xhc3MiLCJyZW1vdmVDbGFzcyIsImUiLCJ0YXJnZXQiLCJjbGFzc0xpc3QiXSwic291cmNlUm9vdCI6IiJ9