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
  }); // close the navMenu when add activity model opens

  (0, jquery_1["default"])('body').on('click', '#header-add-activity-manually', function () {
    (0, jquery_1["default"])('#nav-list').removeClass('nav-active');
    (0, jquery_1["default"])('#hamburger').removeClass('active');
    (0, jquery_1["default"])('body').removeClass('overflow-hidden');
    (0, jquery_1["default"])('#menu-overlay').removeClass('menu-overlay');
    (0, jquery_1["default"])('#activity-menu-overlay').removeClass('menu-overlay');
  }); // close the navMenu by clicking outside

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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LFFBQVEsV0FBWixFQUFzQixJQUF0QixFQUE0Qm9CLElBQTVCLENBQWlDLFVBQWpDLEVBQTZDLFVBQTdDO0lBQ0EsQ0FBQyxHQUFHcEIsUUFBUSxXQUFaLEVBQXNCLElBQXRCLEVBQTRCcUIsT0FBNUIsQ0FBb0MsTUFBcEMsRUFBNENDLE9BQTVDLENBQW9ELFFBQXBEO0VBQ0gsQ0FIRDtBQUlIIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL3NjcmlwdC50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnZhciBqcXVlcnlfMiA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbigwLCBqcXVlcnlfMi5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJyNoYW1idXJnZXInLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykudG9nZ2xlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykudG9nZ2xlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS50b2dnbGVDbGFzcygnb3ZlcmZsb3ctaGlkZGVuJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI21lbnUtb3ZlcmxheScpLnRvZ2dsZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykudG9nZ2xlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgIH0pO1xuICAgIC8vIGNsb3NlIHRoZSBuYXZNZW51IHdoZW4gYWRkIGFjdGl2aXR5IG1vZGVsIG9wZW5zXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJyNoZWFkZXItYWRkLWFjdGl2aXR5LW1hbnVhbGx5JywgZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNuYXYtbGlzdCcpLnJlbW92ZUNsYXNzKCduYXYtYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykucmVtb3ZlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNtZW51LW92ZXJsYXknKS5yZW1vdmVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICB9KTtcbiAgICAvLyBjbG9zZSB0aGUgbmF2TWVudSBieSBjbGlja2luZyBvdXRzaWRlXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgaWYgKGUudGFyZ2V0LmNsYXNzTGlzdFswXSA9PSAnbWVudS1vdmVybGF5Jykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS5yZW1vdmVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykucmVtb3ZlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICB9XG4gICAgfSk7XG4gICAgdmFyIHNpZGViYXJCbG9jayA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1ibG9jaycpO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShkb2N1bWVudCkub24oJ2NsaWNrJywgJy5oZWxwLWJ1dHRvbicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgc2lkZWJhckJsb2NrLnJlbW92ZUNsYXNzKCdoaWRkZW4nKTtcbiAgICAgICAgdmFyIHNpZGViYXJDb250ZW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnNpYmxpbmdzKCcuaGVscC1idXR0b24tY29udGVudCcpLmh0bWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2lkZWJhci1oZWxwLWJsb2NrLXRleHQnKS5odG1sKHNpZGViYXJDb250ZW50KTtcbiAgICB9KTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zaWRlYmFyLWhlbHAtY2xvc2UnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHNpZGViYXJCbG9jay5hZGRDbGFzcygnaGlkZGVuJyk7XG4gICAgfSk7XG59KTtcbi8vIHJlbW92ZSBvdmVybGF5IHBhZ2UgbG9hZGVyIGFmdGVyIGxvYWRpbmcgY29tcGxldGVzXG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkod2luZG93KS5vbignbG9hZCcsIGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgb3ZlcmxheSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm92ZXJsYXknKTtcbiAgICBvdmVybGF5LmFkZENsYXNzKCdoaWRkZW4nKTtcbn0pO1xuLyoqXG4gKiBEaXNhYmxlIHN1Ym1pdCBidXR0b24gYWZ0ZXIgc2luZ2xlICBjbGlja1xuICovXG52YXIgc3VibWl0QnRuID0gJ2Zvcm0gYnV0dG9uW3R5cGU9XCJzdWJtaXRcIl0nLCBzdWJtaXRCdG5FbGVtZW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHN1Ym1pdEJ0bik7XG5pZiAoc3VibWl0QnRuRWxlbWVudC5sZW5ndGggPiAwKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgc3VibWl0QnRuLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuY2xvc2VzdCgnZm9ybScpLnRyaWdnZXIoJ3N1Ym1pdCcpO1xuICAgIH0pO1xufVxuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsImpxdWVyeV8xIiwicmVxdWlyZSIsImpxdWVyeV8yIiwib24iLCJ0b2dnbGVDbGFzcyIsInJlbW92ZUNsYXNzIiwiZSIsInRhcmdldCIsImNsYXNzTGlzdCIsInNpZGViYXJCbG9jayIsImRvY3VtZW50Iiwic2lkZWJhckNvbnRlbnQiLCJzaWJsaW5ncyIsImh0bWwiLCJhZGRDbGFzcyIsIndpbmRvdyIsIm92ZXJsYXkiLCJzdWJtaXRCdG4iLCJzdWJtaXRCdG5FbGVtZW50IiwibGVuZ3RoIiwiYXR0ciIsImNsb3Nlc3QiLCJ0cmlnZ2VyIl0sInNvdXJjZVJvb3QiOiIifQ==