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
  (0, jquery_1["default"])(function () {
    (0, jquery_1["default"])('html').scrollTop(0);
  });
  (0, jquery_1["default"])('body').on('click', '#hamburger', function () {
    (0, jquery_1["default"])('#nav-list').toggleClass('nav-active');
    (0, jquery_1["default"])('#hamburger').toggleClass('active');
    (0, jquery_1["default"])('body').toggleClass('overflow-hidden');
    (0, jquery_1["default"])('#menu-overlay').toggleClass('menu-overlay');
    (0, jquery_1["default"])('#activity-menu-overlay').toggleClass('menu-overlay');
  });
  // close the navMenu by clicking outside
  (0, jquery_1["default"])('body').on('click', function (e) {
    if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
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
});
// remove overlay page loader after loading completes
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUFVLENBQUM7SUFDeEQsQ0FBQyxDQUFDLEVBQUVyQixRQUFRLFdBQVEsRUFBRSxJQUFJLENBQUMsQ0FBQ3NCLE9BQU8sQ0FBQyxNQUFNLENBQUMsQ0FBQ0MsT0FBTyxDQUFDLFFBQVEsQ0FBQztFQUNqRSxDQUFDLENBQUM7QUFDTiIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9zY3JpcHQudHMiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG52YXIganF1ZXJ5XzIgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG5yZXF1aXJlKFwic2VsZWN0MlwiKTtcbigwLCBqcXVlcnlfMi5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdodG1sJykuc2Nyb2xsVG9wKDApO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcjaGFtYnVyZ2VyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNuYXYtbGlzdCcpLnRvZ2dsZUNsYXNzKCduYXYtYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykudG9nZ2xlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNtZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnRvZ2dsZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICB9KTtcbiAgICAvLyBjbG9zZSB0aGUgbmF2TWVudSBieSBjbGlja2luZyBvdXRzaWRlXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgaWYgKGUudGFyZ2V0LmlkICE9PSAnbmF2LWxpc3QnICYmIGUudGFyZ2V0LmlkICE9PSAnaGFtYnVyZ2VyJykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS5yZW1vdmVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykucmVtb3ZlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICB9XG4gICAgfSk7XG4gICAgdmFyIHNpZGViYXJCbG9jayA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1ibG9jaycpO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShkb2N1bWVudCkub24oJ2NsaWNrJywgJy5oZWxwLWJ1dHRvbicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgc2lkZWJhckJsb2NrLnJlbW92ZUNsYXNzKCdoaWRkZW4nKTtcbiAgICAgICAgdmFyIHNpZGViYXJDb250ZW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnNpYmxpbmdzKCcuaGVscC1idXR0b24tY29udGVudCcpLmh0bWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2lkZWJhci1oZWxwLWJsb2NrLXRleHQnKS5odG1sKHNpZGViYXJDb250ZW50KTtcbiAgICB9KTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zaWRlYmFyLWhlbHAtY2xvc2UnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHNpZGViYXJCbG9jay5hZGRDbGFzcygnaGlkZGVuJyk7XG4gICAgfSk7XG59KTtcbi8vIHJlbW92ZSBvdmVybGF5IHBhZ2UgbG9hZGVyIGFmdGVyIGxvYWRpbmcgY29tcGxldGVzXG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkod2luZG93KS5vbignbG9hZCcsIGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgb3ZlcmxheSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm92ZXJsYXknKTtcbiAgICBvdmVybGF5LmFkZENsYXNzKCdoaWRkZW4nKTtcbn0pO1xuLyoqXG4gKiBEaXNhYmxlIHN1Ym1pdCBidXR0b24gYWZ0ZXIgc2luZ2xlICBjbGlja1xuICovXG52YXIgc3VibWl0QnRuID0gJ2Zvcm0gYnV0dG9uW3R5cGU9XCJzdWJtaXRcIl0nLCBzdWJtaXRCdG5FbGVtZW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHN1Ym1pdEJ0bik7XG5pZiAoc3VibWl0QnRuRWxlbWVudC5sZW5ndGggPiAwKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgc3VibWl0QnRuLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuY2xvc2VzdCgnZm9ybScpLnRyaWdnZXIoJ3N1Ym1pdCcpO1xuICAgIH0pO1xufVxuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsImpxdWVyeV8xIiwicmVxdWlyZSIsImpxdWVyeV8yIiwic2Nyb2xsVG9wIiwib24iLCJ0b2dnbGVDbGFzcyIsImUiLCJ0YXJnZXQiLCJpZCIsInJlbW92ZUNsYXNzIiwic2lkZWJhckJsb2NrIiwiZG9jdW1lbnQiLCJzaWRlYmFyQ29udGVudCIsInNpYmxpbmdzIiwiaHRtbCIsImFkZENsYXNzIiwid2luZG93Iiwib3ZlcmxheSIsInN1Ym1pdEJ0biIsInN1Ym1pdEJ0bkVsZW1lbnQiLCJsZW5ndGgiLCJhdHRyIiwiY2xvc2VzdCIsInRyaWdnZXIiXSwic291cmNlUm9vdCI6IiJ9