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
  }); // close the navMenu by clicking outside

  (0, jquery_1["default"])('body').on('click', function (e) {
    if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
      (0, jquery_1["default"])('#nav-list').removeClass('nav-active');
      (0, jquery_1["default"])('#hamburger').removeClass('active');
      (0, jquery_1["default"])('body').removeClass('overflow-hidden');
    }
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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cy9qcy9zY3JpcHRzL3NjcmlwdC50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnZhciBqcXVlcnlfMiA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnJlcXVpcmUoXCJzZWxlY3QyXCIpO1xuKDAsIGpxdWVyeV8yLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnI2hhbWJ1cmdlcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS50b2dnbGVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNoYW1idXJnZXInKS50b2dnbGVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnRvZ2dsZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICB9KTtcbiAgICAvLyBjbG9zZSB0aGUgbmF2TWVudSBieSBjbGlja2luZyBvdXRzaWRlXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgaWYgKGUudGFyZ2V0LmlkICE9PSAnbmF2LWxpc3QnICYmIGUudGFyZ2V0LmlkICE9PSAnaGFtYnVyZ2VyJykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS5yZW1vdmVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykucmVtb3ZlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTtcbi8vIHJlbW92ZSBvdmVybGF5IHBhZ2UgbG9hZGVyIGFmdGVyIGxvYWRpbmcgY29tcGxldGVzXG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkod2luZG93KS5vbignbG9hZCcsIGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgb3ZlcmxheSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm92ZXJsYXknKTtcbiAgICBvdmVybGF5LmFkZENsYXNzKCdoaWRkZW4nKTtcbn0pO1xuLyoqXG4gKiBEaXNhYmxlIHN1Ym1pdCBidXR0b24gYWZ0ZXIgc2luZ2xlICBjbGlja1xuICovXG52YXIgc3VibWl0QnRuID0gJ2Zvcm0gYnV0dG9uW3R5cGU9XCJzdWJtaXRcIl0nLCBzdWJtaXRCdG5FbGVtZW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHN1Ym1pdEJ0bik7XG5pZiAoc3VibWl0QnRuRWxlbWVudC5sZW5ndGggPiAwKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgc3VibWl0QnRuLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuY2xvc2VzdCgnZm9ybScpLnRyaWdnZXIoJ3N1Ym1pdCcpO1xuICAgIH0pO1xufVxuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsImpxdWVyeV8xIiwicmVxdWlyZSIsImpxdWVyeV8yIiwib24iLCJ0b2dnbGVDbGFzcyIsImUiLCJ0YXJnZXQiLCJpZCIsInJlbW92ZUNsYXNzIiwid2luZG93Iiwib3ZlcmxheSIsImFkZENsYXNzIiwic3VibWl0QnRuIiwic3VibWl0QnRuRWxlbWVudCIsImxlbmd0aCIsImF0dHIiLCJjbG9zZXN0IiwidHJpZ2dlciJdLCJzb3VyY2VSb290IjoiIn0=