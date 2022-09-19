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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUFqQjtBQUNILENBSEQ7QUFJQTtBQUNBO0FBQ0E7O0FBQ0EsSUFBSUcsU0FBUyxHQUFHLDRCQUFoQjtBQUFBLElBQThDQyxnQkFBZ0IsR0FBRyxDQUFDLEdBQUdsQixRQUFRLFdBQVosRUFBc0JpQixTQUF0QixDQUFqRTs7QUFDQSxJQUFJQyxnQkFBZ0IsQ0FBQ0MsTUFBakIsR0FBMEIsQ0FBOUIsRUFBaUM7RUFDN0IsQ0FBQyxHQUFHbkIsUUFBUSxXQUFaLEVBQXNCLE1BQXRCLEVBQThCRyxFQUE5QixDQUFpQyxPQUFqQyxFQUEwQ2MsU0FBMUMsRUFBcUQsWUFBWTtJQUM3RCxDQUFDLEdBQUdqQixRQUFRLFdBQVosRUFBc0IsSUFBdEIsRUFBNEJvQixJQUE1QixDQUFpQyxVQUFqQyxFQUE2QyxVQUE3QztJQUNBLENBQUMsR0FBR3BCLFFBQVEsV0FBWixFQUFzQixJQUF0QixFQUE0QnFCLE9BQTVCLENBQW9DLE1BQXBDLEVBQTRDQyxPQUE1QyxDQUFvRCxRQUFwRDtFQUNILENBSEQ7QUFJSCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy9zY3JpcHQudHMiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG52YXIganF1ZXJ5XzIgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG5yZXF1aXJlKFwic2VsZWN0MlwiKTtcbigwLCBqcXVlcnlfMi5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJyNoYW1idXJnZXInLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykudG9nZ2xlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykudG9nZ2xlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS50b2dnbGVDbGFzcygnb3ZlcmZsb3ctaGlkZGVuJyk7XG4gICAgfSk7XG4gICAgLy8gY2xvc2UgdGhlIG5hdk1lbnUgYnkgY2xpY2tpbmcgb3V0c2lkZVxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIGlmIChlLnRhcmdldC5pZCAhPT0gJ25hdi1saXN0JyAmJiBlLnRhcmdldC5pZCAhPT0gJ2hhbWJ1cmdlcicpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykucmVtb3ZlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnJlbW92ZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgfVxuICAgIH0pO1xuICAgIHZhciBzaWRlYmFyQmxvY2sgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zaWRlYmFyLWhlbHAtYmxvY2snKTtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZG9jdW1lbnQpLm9uKCdjbGljaycsICcuaGVscC1idXR0b24nLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHNpZGViYXJCbG9jay5yZW1vdmVDbGFzcygnaGlkZGVuJyk7XG4gICAgICAgIHZhciBzaWRlYmFyQ29udGVudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5zaWJsaW5ncygnLmhlbHAtYnV0dG9uLWNvbnRlbnQnKS5odG1sKCk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1ibG9jay10ZXh0JykuaHRtbChzaWRlYmFyQ29udGVudCk7XG4gICAgfSk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2lkZWJhci1oZWxwLWNsb3NlJykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAgICAgICBzaWRlYmFyQmxvY2suYWRkQ2xhc3MoJ2hpZGRlbicpO1xuICAgIH0pO1xufSk7XG4vLyByZW1vdmUgb3ZlcmxheSBwYWdlIGxvYWRlciBhZnRlciBsb2FkaW5nIGNvbXBsZXRlc1xuKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHdpbmRvdykub24oJ2xvYWQnLCBmdW5jdGlvbiAoKSB7XG4gICAgdmFyIG92ZXJsYXkgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5vdmVybGF5Jyk7XG4gICAgb3ZlcmxheS5hZGRDbGFzcygnaGlkZGVuJyk7XG59KTtcbi8qKlxuICogRGlzYWJsZSBzdWJtaXQgYnV0dG9uIGFmdGVyIHNpbmdsZSAgY2xpY2tcbiAqL1xudmFyIHN1Ym1pdEJ0biA9ICdmb3JtIGJ1dHRvblt0eXBlPVwic3VibWl0XCJdJywgc3VibWl0QnRuRWxlbWVudCA9ICgwLCBqcXVlcnlfMS5kZWZhdWx0KShzdWJtaXRCdG4pO1xuaWYgKHN1Ym1pdEJ0bkVsZW1lbnQubGVuZ3RoID4gMCkge1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIHN1Ym1pdEJ0biwgZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuYXR0cignZGlzYWJsZWQnLCAnZGlzYWJsZWQnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLmNsb3Nlc3QoJ2Zvcm0nKS50cmlnZ2VyKCdzdWJtaXQnKTtcbiAgICB9KTtcbn1cbiJdLCJuYW1lcyI6WyJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJleHBvcnRzIiwidmFsdWUiLCJqcXVlcnlfMSIsInJlcXVpcmUiLCJqcXVlcnlfMiIsIm9uIiwidG9nZ2xlQ2xhc3MiLCJlIiwidGFyZ2V0IiwiaWQiLCJyZW1vdmVDbGFzcyIsInNpZGViYXJCbG9jayIsImRvY3VtZW50Iiwic2lkZWJhckNvbnRlbnQiLCJzaWJsaW5ncyIsImh0bWwiLCJhZGRDbGFzcyIsIndpbmRvdyIsIm92ZXJsYXkiLCJzdWJtaXRCdG4iLCJzdWJtaXRCdG5FbGVtZW50IiwibGVuZ3RoIiwiYXR0ciIsImNsb3Nlc3QiLCJ0cmlnZ2VyIl0sInNvdXJjZVJvb3QiOiIifQ==