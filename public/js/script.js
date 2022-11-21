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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QyxDQUFnRCxPQUFoRCxFQUF5RCxZQUFZO0lBQ2pFTSxZQUFZLENBQUNLLFFBQWIsQ0FBc0IsUUFBdEI7RUFDSCxDQUZEO0FBR0gsQ0EzQkQsR0E0QkE7O0FBQ0EsQ0FBQyxHQUFHZCxRQUFRLFdBQVosRUFBc0JlLE1BQXRCLEVBQThCWixFQUE5QixDQUFpQyxNQUFqQyxFQUF5QyxZQUFZO0VBQ2pELElBQUlhLE9BQU8sR0FBRyxDQUFDLEdBQUdoQixRQUFRLFdBQVosRUFBc0IsVUFBdEIsQ0FBZDtFQUNBZ0IsT0FBTyxDQUFDRixRQUFSLENBQWlCLFFBQWpCO0FBQ0gsQ0FIRDtBQUlBO0FBQ0E7QUFDQTs7QUFDQSxJQUFJRyxTQUFTLEdBQUcsNEJBQWhCO0FBQUEsSUFBOENDLGdCQUFnQixHQUFHLENBQUMsR0FBR2xCLFFBQVEsV0FBWixFQUFzQmlCLFNBQXRCLENBQWpFOztBQUNBLElBQUlDLGdCQUFnQixDQUFDQyxNQUFqQixHQUEwQixDQUE5QixFQUFpQztFQUM3QixDQUFDLEdBQUduQixRQUFRLFdBQVosRUFBc0IsTUFBdEIsRUFBOEJHLEVBQTlCLENBQWlDLE9BQWpDLEVBQTBDYyxTQUExQyxFQUFxRCxZQUFZO0lBQzdELENBQUMsR0FBR2pCLFFBQVEsV0FBWixFQUFzQixJQUF0QixFQUE0Qm9CLElBQTVCLENBQWlDLFVBQWpDLEVBQTZDLFVBQTdDO0lBQ0EsQ0FBQyxHQUFHcEIsUUFBUSxXQUFaLEVBQXNCLElBQXRCLEVBQTRCcUIsT0FBNUIsQ0FBb0MsTUFBcEMsRUFBNENDLE9BQTVDLENBQW9ELFFBQXBEO0VBQ0gsQ0FIRDtBQUlIIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL3NjcmlwdC50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnZhciBqcXVlcnlfMiA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnJlcXVpcmUoXCJzZWxlY3QyXCIpO1xuKDAsIGpxdWVyeV8yLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnI2hhbWJ1cmdlcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS50b2dnbGVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNoYW1idXJnZXInKS50b2dnbGVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnRvZ2dsZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykudG9nZ2xlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eS1tZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgfSk7XG4gICAgLy8gY2xvc2UgdGhlIG5hdk1lbnUgYnkgY2xpY2tpbmcgb3V0c2lkZVxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIGlmIChlLnRhcmdldC5pZCAhPT0gJ25hdi1saXN0JyAmJiBlLnRhcmdldC5pZCAhPT0gJ2hhbWJ1cmdlcicpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykucmVtb3ZlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnJlbW92ZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI21lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgfVxuICAgIH0pO1xuICAgIHZhciBzaWRlYmFyQmxvY2sgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zaWRlYmFyLWhlbHAtYmxvY2snKTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZG9jdW1lbnQpLm9uKCdjbGljaycsICcuaGVscC1idXR0b24nLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHNpZGViYXJCbG9jay5yZW1vdmVDbGFzcygnaGlkZGVuJyk7XG4gICAgICAgIHZhciBzaWRlYmFyQ29udGVudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5zaWJsaW5ncygnLmhlbHAtYnV0dG9uLWNvbnRlbnQnKS5odG1sKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1ibG9jay10ZXh0JykuaHRtbChzaWRlYmFyQ29udGVudCk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2lkZWJhci1oZWxwLWNsb3NlJykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAgICAgICBzaWRlYmFyQmxvY2suYWRkQ2xhc3MoJ2hpZGRlbicpO1xuICAgIH0pO1xufSk7XG4vLyByZW1vdmUgb3ZlcmxheSBwYWdlIGxvYWRlciBhZnRlciBsb2FkaW5nIGNvbXBsZXRlc1xuKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHdpbmRvdykub24oJ2xvYWQnLCBmdW5jdGlvbiAoKSB7XG4gICAgdmFyIG92ZXJsYXkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5vdmVybGF5Jyk7XG4gICAgb3ZlcmxheS5hZGRDbGFzcygnaGlkZGVuJyk7XG59KTtcbi8qKlxuICogRGlzYWJsZSBzdWJtaXQgYnV0dG9uIGFmdGVyIHNpbmdsZSAgY2xpY2tcbiAqL1xudmFyIHN1Ym1pdEJ0biA9ICdmb3JtIGJ1dHRvblt0eXBlPVwic3VibWl0XCJdJywgc3VibWl0QnRuRWxlbWVudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzdWJtaXRCdG4pO1xuaWYgKHN1Ym1pdEJ0bkVsZW1lbnQubGVuZ3RoID4gMCkge1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIHN1Ym1pdEJ0biwgZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLmNsb3Nlc3QoJ2Zvcm0nKS50cmlnZ2VyKCdzdWJtaXQnKTtcbiAgICB9KTtcbn1cbiJdLCJuYW1lcyI6WyJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJleHBvcnRzIiwidmFsdWUiLCJqcXVlcnlfMSIsInJlcXVpcmUiLCJqcXVlcnlfMiIsIm9uIiwidG9nZ2xlQ2xhc3MiLCJlIiwidGFyZ2V0IiwiaWQiLCJyZW1vdmVDbGFzcyIsInNpZGViYXJCbG9jayIsImRvY3VtZW50Iiwic2lkZWJhckNvbnRlbnQiLCJzaWJsaW5ncyIsImh0bWwiLCJhZGRDbGFzcyIsIndpbmRvdyIsIm92ZXJsYXkiLCJzdWJtaXRCdG4iLCJzdWJtaXRCdG5FbGVtZW50IiwibGVuZ3RoIiwiYXR0ciIsImNsb3Nlc3QiLCJ0cmlnZ2VyIl0sInNvdXJjZVJvb3QiOiIifQ==