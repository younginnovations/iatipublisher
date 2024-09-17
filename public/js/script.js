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
(0, jquery_2["default"])(function () {
  (0, jquery_1["default"])('body').on('click', '#hamburger', function () {
    (0, jquery_1["default"])('#nav-list').toggleClass('nav-active');
    (0, jquery_1["default"])('#hamburger').toggleClass('active');
    (0, jquery_1["default"])('body').toggleClass('overflow-hidden');
    (0, jquery_1["default"])('#menu-overlay').toggleClass('menu-overlay');
    (0, jquery_1["default"])('#activity-menu-overlay').toggleClass('menu-overlay');
  });
  // close the navMenu by clicking outside
  (0, jquery_1["default"])('body').on('click', function (e) {
    if (e.target.classList[0] == 'menu-overlay') {
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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cy9zY3JpcHQudHMiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG5jb25zdCBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbmNvbnN0IGpxdWVyeV8yID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xuKDAsIGpxdWVyeV8yLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnI2hhbWJ1cmdlcicsICgpID0+IHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS50b2dnbGVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNoYW1idXJnZXInKS50b2dnbGVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnRvZ2dsZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykudG9nZ2xlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eS1tZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgfSk7XG4gICAgLy8gY2xvc2UgdGhlIG5hdk1lbnUgYnkgY2xpY2tpbmcgb3V0c2lkZVxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIChlKSA9PiB7XG4gICAgICAgIGlmIChlLnRhcmdldC5jbGFzc0xpc3RbMF0gPT0gJ21lbnUtb3ZlcmxheScpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykucmVtb3ZlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnJlbW92ZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI21lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgfVxuICAgIH0pO1xuICAgIGNvbnN0IHNpZGViYXJCbG9jayA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1ibG9jaycpO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShkb2N1bWVudCkub24oJ2NsaWNrJywgJy5oZWxwLWJ1dHRvbicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgc2lkZWJhckJsb2NrLnJlbW92ZUNsYXNzKCdoaWRkZW4nKTtcbiAgICAgICAgY29uc3Qgc2lkZWJhckNvbnRlbnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuc2libGluZ3MoJy5oZWxwLWJ1dHRvbi1jb250ZW50JykuaHRtbCgpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zaWRlYmFyLWhlbHAtYmxvY2stdGV4dCcpLmh0bWwoc2lkZWJhckNvbnRlbnQpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1jbG9zZScpLm9uKCdjbGljaycsICgpID0+IHtcbiAgICAgICAgc2lkZWJhckJsb2NrLmFkZENsYXNzKCdoaWRkZW4nKTtcbiAgICB9KTtcbn0pO1xuLy8gcmVtb3ZlIG92ZXJsYXkgcGFnZSBsb2FkZXIgYWZ0ZXIgbG9hZGluZyBjb21wbGV0ZXNcbigwLCBqcXVlcnlfMS5kZWZhdWx0KSh3aW5kb3cpLm9uKCdsb2FkJywgZnVuY3Rpb24gKCkge1xuICAgIGNvbnN0IG92ZXJsYXkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5vdmVybGF5Jyk7XG4gICAgb3ZlcmxheS5hZGRDbGFzcygnaGlkZGVuJyk7XG59KTtcbi8qKlxuICogRGlzYWJsZSBzdWJtaXQgYnV0dG9uIGFmdGVyIHNpbmdsZSAgY2xpY2tcbiAqL1xuY29uc3Qgc3VibWl0QnRuID0gJ2Zvcm0gYnV0dG9uW3R5cGU9XCJzdWJtaXRcIl0nLCBzdWJtaXRCdG5FbGVtZW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHN1Ym1pdEJ0bik7XG5pZiAoc3VibWl0QnRuRWxlbWVudC5sZW5ndGggPiAwKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgc3VibWl0QnRuLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuY2xvc2VzdCgnZm9ybScpLnRyaWdnZXIoJ3N1Ym1pdCcpO1xuICAgIH0pO1xufVxuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsImpxdWVyeV8xIiwicmVxdWlyZSIsImpxdWVyeV8yIiwib24iLCJ0b2dnbGVDbGFzcyIsImUiLCJ0YXJnZXQiLCJjbGFzc0xpc3QiLCJyZW1vdmVDbGFzcyIsInNpZGViYXJCbG9jayIsImRvY3VtZW50Iiwic2lkZWJhckNvbnRlbnQiLCJzaWJsaW5ncyIsImh0bWwiLCJhZGRDbGFzcyIsIndpbmRvdyIsIm92ZXJsYXkiLCJzdWJtaXRCdG4iLCJzdWJtaXRCdG5FbGVtZW50IiwibGVuZ3RoIiwiYXR0ciIsImNsb3Nlc3QiLCJ0cmlnZ2VyIl0sInNvdXJjZVJvb3QiOiIifQ==