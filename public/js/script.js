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
  console.log(';inside'); // $('#hamburger-cross').on('click', function () {
  //   console.log('abc');
  //   // $('#elementToRemoveClass').removeClass('example-class');
  // });

  (0, jquery_1["default"])('body').on('click', '#hamburger', function () {
    (0, jquery_1["default"])('#nav-list').toggleClass('nav-active');
    (0, jquery_1["default"])('#hamburger').toggleClass('active');
    (0, jquery_1["default"])('body').toggleClass('overflow-hidden');
    (0, jquery_1["default"])('#menu-overlay').toggleClass('menu-overlay');
    (0, jquery_1["default"])('#activity-menu-overlay').toggleClass('menu-overlay');
  }); // close the navMenu by clicking outside

  (0, jquery_1["default"])('body').on('click', function (e) {
    console.log('outside click');

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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LFdBQVosRUFBc0IscUJBQXRCLEVBQTZDSyxFQUE3QyxDQUFnRCxPQUFoRCxFQUF5RCxZQUFZO0lBQ2pFTSxZQUFZLENBQUNLLFFBQWIsQ0FBc0IsUUFBdEI7RUFDSCxDQUZEO0FBR0gsQ0FqQ0QsR0FrQ0E7O0FBQ0EsQ0FBQyxHQUFHaEIsUUFBUSxXQUFaLEVBQXNCaUIsTUFBdEIsRUFBOEJaLEVBQTlCLENBQWlDLE1BQWpDLEVBQXlDLFlBQVk7RUFDakQsSUFBSWEsT0FBTyxHQUFHLENBQUMsR0FBR2xCLFFBQVEsV0FBWixFQUFzQixVQUF0QixDQUFkO0VBQ0FrQixPQUFPLENBQUNGLFFBQVIsQ0FBaUIsUUFBakI7QUFDSCxDQUhEO0FBSUE7QUFDQTtBQUNBOztBQUNBLElBQUlHLFNBQVMsR0FBRyw0QkFBaEI7QUFBQSxJQUE4Q0MsZ0JBQWdCLEdBQUcsQ0FBQyxHQUFHcEIsUUFBUSxXQUFaLEVBQXNCbUIsU0FBdEIsQ0FBakU7O0FBQ0EsSUFBSUMsZ0JBQWdCLENBQUNDLE1BQWpCLEdBQTBCLENBQTlCLEVBQWlDO0VBQzdCLENBQUMsR0FBR3JCLFFBQVEsV0FBWixFQUFzQixNQUF0QixFQUE4QkssRUFBOUIsQ0FBaUMsT0FBakMsRUFBMENjLFNBQTFDLEVBQXFELFlBQVk7SUFDN0QsQ0FBQyxHQUFHbkIsUUFBUSxXQUFaLEVBQXNCLElBQXRCLEVBQTRCc0IsSUFBNUIsQ0FBaUMsVUFBakMsRUFBNkMsVUFBN0M7SUFDQSxDQUFDLEdBQUd0QixRQUFRLFdBQVosRUFBc0IsSUFBdEIsRUFBNEJ1QixPQUE1QixDQUFvQyxNQUFwQyxFQUE0Q0MsT0FBNUMsQ0FBb0QsUUFBcEQ7RUFDSCxDQUhEO0FBSUgiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3NjcmlwdHMvc2NyaXB0LnRzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xudmFyIGpxdWVyeV8yID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xuKDAsIGpxdWVyeV8yLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICBjb25zb2xlLmxvZygnO2luc2lkZScpO1xuICAgIC8vICQoJyNoYW1idXJnZXItY3Jvc3MnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG4gICAgLy8gICBjb25zb2xlLmxvZygnYWJjJyk7XG4gICAgLy8gICAvLyAkKCcjZWxlbWVudFRvUmVtb3ZlQ2xhc3MnKS5yZW1vdmVDbGFzcygnZXhhbXBsZS1jbGFzcycpO1xuICAgIC8vIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcjaGFtYnVyZ2VyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNuYXYtbGlzdCcpLnRvZ2dsZUNsYXNzKCduYXYtYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykudG9nZ2xlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNtZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnRvZ2dsZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICB9KTtcbiAgICAvLyBjbG9zZSB0aGUgbmF2TWVudSBieSBjbGlja2luZyBvdXRzaWRlXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgY29uc29sZS5sb2coJ291dHNpZGUgY2xpY2snKTtcbiAgICAgICAgaWYgKGUudGFyZ2V0LmNsYXNzTGlzdFswXSA9PSAnbWVudS1vdmVybGF5Jykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS5yZW1vdmVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykucmVtb3ZlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICB9XG4gICAgfSk7XG4gICAgdmFyIHNpZGViYXJCbG9jayA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1ibG9jaycpO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KShkb2N1bWVudCkub24oJ2NsaWNrJywgJy5oZWxwLWJ1dHRvbicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgc2lkZWJhckJsb2NrLnJlbW92ZUNsYXNzKCdoaWRkZW4nKTtcbiAgICAgICAgdmFyIHNpZGViYXJDb250ZW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLnNpYmxpbmdzKCcuaGVscC1idXR0b24tY29udGVudCcpLmh0bWwoKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2lkZWJhci1oZWxwLWJsb2NrLXRleHQnKS5odG1sKHNpZGViYXJDb250ZW50KTtcbiAgICB9KTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zaWRlYmFyLWhlbHAtY2xvc2UnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHNpZGViYXJCbG9jay5hZGRDbGFzcygnaGlkZGVuJyk7XG4gICAgfSk7XG59KTtcbi8vIHJlbW92ZSBvdmVybGF5IHBhZ2UgbG9hZGVyIGFmdGVyIGxvYWRpbmcgY29tcGxldGVzXG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkod2luZG93KS5vbignbG9hZCcsIGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgb3ZlcmxheSA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLm92ZXJsYXknKTtcbiAgICBvdmVybGF5LmFkZENsYXNzKCdoaWRkZW4nKTtcbn0pO1xuLyoqXG4gKiBEaXNhYmxlIHN1Ym1pdCBidXR0b24gYWZ0ZXIgc2luZ2xlICBjbGlja1xuICovXG52YXIgc3VibWl0QnRuID0gJ2Zvcm0gYnV0dG9uW3R5cGU9XCJzdWJtaXRcIl0nLCBzdWJtaXRCdG5FbGVtZW50ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHN1Ym1pdEJ0bik7XG5pZiAoc3VibWl0QnRuRWxlbWVudC5sZW5ndGggPiAwKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgc3VibWl0QnRuLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5hdHRyKCdkaXNhYmxlZCcsICdkaXNhYmxlZCcpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuY2xvc2VzdCgnZm9ybScpLnRyaWdnZXIoJ3N1Ym1pdCcpO1xuICAgIH0pO1xufVxuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsImpxdWVyeV8xIiwicmVxdWlyZSIsImpxdWVyeV8yIiwiY29uc29sZSIsImxvZyIsIm9uIiwidG9nZ2xlQ2xhc3MiLCJlIiwidGFyZ2V0IiwiY2xhc3NMaXN0IiwicmVtb3ZlQ2xhc3MiLCJzaWRlYmFyQmxvY2siLCJkb2N1bWVudCIsInNpZGViYXJDb250ZW50Iiwic2libGluZ3MiLCJodG1sIiwiYWRkQ2xhc3MiLCJ3aW5kb3ciLCJvdmVybGF5Iiwic3VibWl0QnRuIiwic3VibWl0QnRuRWxlbWVudCIsImxlbmd0aCIsImF0dHIiLCJjbG9zZXN0IiwidHJpZ2dlciJdLCJzb3VyY2VSb290IjoiIn0=