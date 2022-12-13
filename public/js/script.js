"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/script"],{

/***/ "./resources/assets/js/scripts/script.ts":
/*!***********************************************!*\
  !*** ./resources/assets/js/scripts/script.ts ***!
  \***********************************************/
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

__webpack_require__(/*! select2 */ "./node_modules/select2/dist/js/select2.js");

(0, jquery_2["default"])(function () {
  (0, jquery_1["default"])('body').on('click', '#hamburger', function () {
    (0, jquery_1["default"])('#nav-list').toggleClass('nav-active');
    (0, jquery_1["default"])('#hamburger').toggleClass('active');
    (0, jquery_1["default"])('body').toggleClass('overflow-hidden');
    (0, jquery_1["default"])('#menu-overlay').toggleClass('menu-overlay');
    (0, jquery_1["default"])('#activity-menu-overlay').toggleClass('menu-overlay');
  }); // close the navMenu by clicking outside

  (0, jquery_1["default"])('body').on('click', function (e) {
    if (!(e.target.classList.contains('activity-nav') || e.target.classList.contains('activity-nav-list') || e.target.classList[0]) && e.target.id !== 'hamburger') {
      (0, jquery_1["default"])('#nav-list').removeClass('nav-active');
      (0, jquery_1["default"])('#hamburger').removeClass('active');
      (0, jquery_1["default"])('body').removeClass('overflow-hidden');
      (0, jquery_1["default"])('#menu-overlay').removeClass('menu-overlay');
      (0, jquery_1["default"])('#activity-menu-overlay').removeClass('menu-overlay');
    }
  });
  var sidebarBlock = (0, jquery_1["default"])('.sidebar-help-block');
  (0, jquery_1["default"])(document).on('click', '.help-button', function () {
    sidebarBlock.removeClass('hidden');
    var sidebarContent = (0, jquery_1["default"])(this).siblings('.help-button-content').html();
    (0, jquery_1["default"])('.sidebar-help-block-text').html(sidebarContent);
  });
  (0, jquery_1["default"])('.sidebar-help-close').on('click', function () {
    sidebarBlock.addClass('hidden');
  });
}); // remove overlay page loader after loading completes

(0, jquery_1["default"])(window).on('load', function () {
  var overlay = (0, jquery_1["default"])('.overlay');
  overlay.addClass('hidden');
});
/**
 * Disable submit button after single  click
 */

var submitBtn = 'form button[type="submit"]',
    submitBtnElement = (0, jquery_1["default"])(submitBtn);

if (submitBtnElement.length > 0) {
  (0, jquery_1["default"])('body').on('click', submitBtn, function () {
    (0, jquery_1["default"])(this).attr('disabled', 'disabled');
    (0, jquery_1["default"])(this).closest('form').trigger('submit');
  });
}

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/assets/js/scripts/script.ts")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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InNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xudmFyIGpxdWVyeV8yID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xucmVxdWlyZShcInNlbGVjdDJcIik7XG4oMCwganF1ZXJ5XzIuZGVmYXVsdCkoZnVuY3Rpb24gKCkge1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcjaGFtYnVyZ2VyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNuYXYtbGlzdCcpLnRvZ2dsZUNsYXNzKCduYXYtYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykudG9nZ2xlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNtZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnRvZ2dsZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICB9KTtcbiAgICAvLyBjbG9zZSB0aGUgbmF2TWVudSBieSBjbGlja2luZyBvdXRzaWRlXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgaWYgKCEoZS50YXJnZXQuY2xhc3NMaXN0LmNvbnRhaW5zKCdhY3Rpdml0eS1uYXYnKSB8fFxuICAgICAgICAgICAgZS50YXJnZXQuY2xhc3NMaXN0LmNvbnRhaW5zKCdhY3Rpdml0eS1uYXYtbGlzdCcpIHx8XG4gICAgICAgICAgICBlLnRhcmdldC5jbGFzc0xpc3RbMF0pICYmXG4gICAgICAgICAgICBlLnRhcmdldC5pZCAhPT0gJ2hhbWJ1cmdlcicpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykucmVtb3ZlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnJlbW92ZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI21lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgfVxuICAgIH0pO1xuICAgIHZhciBzaWRlYmFyQmxvY2sgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zaWRlYmFyLWhlbHAtYmxvY2snKTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZG9jdW1lbnQpLm9uKCdjbGljaycsICcuaGVscC1idXR0b24nLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHNpZGViYXJCbG9jay5yZW1vdmVDbGFzcygnaGlkZGVuJyk7XG4gICAgICAgIHZhciBzaWRlYmFyQ29udGVudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5zaWJsaW5ncygnLmhlbHAtYnV0dG9uLWNvbnRlbnQnKS5odG1sKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1ibG9jay10ZXh0JykuaHRtbChzaWRlYmFyQ29udGVudCk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2lkZWJhci1oZWxwLWNsb3NlJykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAgICAgICBzaWRlYmFyQmxvY2suYWRkQ2xhc3MoJ2hpZGRlbicpO1xuICAgIH0pO1xufSk7XG4vLyByZW1vdmUgb3ZlcmxheSBwYWdlIGxvYWRlciBhZnRlciBsb2FkaW5nIGNvbXBsZXRlc1xuKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHdpbmRvdykub24oJ2xvYWQnLCBmdW5jdGlvbiAoKSB7XG4gICAgdmFyIG92ZXJsYXkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5vdmVybGF5Jyk7XG4gICAgb3ZlcmxheS5hZGRDbGFzcygnaGlkZGVuJyk7XG59KTtcbi8qKlxuICogRGlzYWJsZSBzdWJtaXQgYnV0dG9uIGFmdGVyIHNpbmdsZSAgY2xpY2tcbiAqL1xudmFyIHN1Ym1pdEJ0biA9ICdmb3JtIGJ1dHRvblt0eXBlPVwic3VibWl0XCJdJywgc3VibWl0QnRuRWxlbWVudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzdWJtaXRCdG4pO1xuaWYgKHN1Ym1pdEJ0bkVsZW1lbnQubGVuZ3RoID4gMCkge1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIHN1Ym1pdEJ0biwgZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLmNsb3Nlc3QoJ2Zvcm0nKS50cmlnZ2VyKCdzdWJtaXQnKTtcbiAgICB9KTtcbn1cbiJdLCJuYW1lcyI6WyJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJleHBvcnRzIiwidmFsdWUiLCJqcXVlcnlfMSIsInJlcXVpcmUiLCJqcXVlcnlfMiIsIm9uIiwidG9nZ2xlQ2xhc3MiLCJlIiwidGFyZ2V0IiwiY2xhc3NMaXN0IiwiY29udGFpbnMiLCJpZCIsInJlbW92ZUNsYXNzIiwic2lkZWJhckJsb2NrIiwiZG9jdW1lbnQiLCJzaWRlYmFyQ29udGVudCIsInNpYmxpbmdzIiwiaHRtbCIsImFkZENsYXNzIiwid2luZG93Iiwib3ZlcmxheSIsInN1Ym1pdEJ0biIsInN1Ym1pdEJ0bkVsZW1lbnQiLCJsZW5ndGgiLCJhdHRyIiwiY2xvc2VzdCIsInRyaWdnZXIiXSwic291cmNlUm9vdCI6IiJ9