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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiL2pzL3NjcmlwdC5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBYTs7QUFDYixJQUFJQSxlQUFlLEdBQUksUUFBUSxLQUFLQSxlQUFkLElBQWtDLFVBQVVDLEdBQVYsRUFBZTtBQUNuRSxTQUFRQSxHQUFHLElBQUlBLEdBQUcsQ0FBQ0MsVUFBWixHQUEwQkQsR0FBMUIsR0FBZ0M7QUFBRSxlQUFXQTtBQUFiLEdBQXZDO0FBQ0gsQ0FGRDs7QUFHQUUsOENBQTZDO0FBQUVHLEVBQUFBLEtBQUssRUFBRTtBQUFULENBQTdDOztBQUNBLElBQUlDLFFBQVEsR0FBR1AsZUFBZSxDQUFDUSxtQkFBTyxDQUFDLG9EQUFELENBQVIsQ0FBOUI7O0FBQ0EsSUFBSUMsUUFBUSxHQUFHVCxlQUFlLENBQUNRLG1CQUFPLENBQUMsb0RBQUQsQ0FBUixDQUE5Qjs7QUFDQUEsbUJBQU8sQ0FBQywwREFBRCxDQUFQOztBQUNBLENBQUMsR0FBR0MsUUFBUSxXQUFaLEVBQXNCLFlBQVk7QUFDOUIsR0FBQyxHQUFHRixRQUFRLFdBQVosRUFBc0IsTUFBdEIsRUFBOEJHLEVBQTlCLENBQWlDLE9BQWpDLEVBQTBDLFlBQTFDLEVBQXdELFlBQVk7QUFDaEUsS0FBQyxHQUFHSCxRQUFRLFdBQVosRUFBc0IsV0FBdEIsRUFBbUNJLFdBQW5DLENBQStDLFlBQS9DO0FBQ0EsS0FBQyxHQUFHSixRQUFRLFdBQVosRUFBc0IsWUFBdEIsRUFBb0NJLFdBQXBDLENBQWdELFFBQWhEO0FBQ0EsS0FBQyxHQUFHSixRQUFRLFdBQVosRUFBc0IsTUFBdEIsRUFBOEJJLFdBQTlCLENBQTBDLGlCQUExQztBQUNBLEtBQUMsR0FBR0osUUFBUSxXQUFaLEVBQXNCLGVBQXRCLEVBQXVDSSxXQUF2QyxDQUFtRCxjQUFuRDtBQUNBLEtBQUMsR0FBR0osUUFBUSxXQUFaLEVBQXNCLHdCQUF0QixFQUFnREksV0FBaEQsQ0FBNEQsY0FBNUQ7QUFDSCxHQU5ELEVBRDhCLENBUTlCOztBQUNBLEdBQUMsR0FBR0osUUFBUSxXQUFaLEVBQXNCLE1BQXRCLEVBQThCRyxFQUE5QixDQUFpQyxPQUFqQyxFQUEwQyxVQUFVRSxDQUFWLEVBQWE7QUFDbkQsUUFBSUEsQ0FBQyxDQUFDQyxNQUFGLENBQVNDLEVBQVQsS0FBZ0IsVUFBaEIsSUFBOEJGLENBQUMsQ0FBQ0MsTUFBRixDQUFTQyxFQUFULEtBQWdCLFdBQWxELEVBQStEO0FBQzNELE9BQUMsR0FBR1AsUUFBUSxXQUFaLEVBQXNCLFdBQXRCLEVBQW1DUSxXQUFuQyxDQUErQyxZQUEvQztBQUNBLE9BQUMsR0FBR1IsUUFBUSxXQUFaLEVBQXNCLFlBQXRCLEVBQW9DUSxXQUFwQyxDQUFnRCxRQUFoRDtBQUNBLE9BQUMsR0FBR1IsUUFBUSxXQUFaLEVBQXNCLE1BQXRCLEVBQThCUSxXQUE5QixDQUEwQyxpQkFBMUM7QUFDQSxPQUFDLEdBQUdSLFFBQVEsV0FBWixFQUFzQixlQUF0QixFQUF1Q1EsV0FBdkMsQ0FBbUQsY0FBbkQ7QUFDQSxPQUFDLEdBQUdSLFFBQVEsV0FBWixFQUFzQix3QkFBdEIsRUFBZ0RRLFdBQWhELENBQTRELGNBQTVEO0FBQ0g7QUFDSixHQVJEO0FBU0EsTUFBSUMsWUFBWSxHQUFHLENBQUMsR0FBR1QsUUFBUSxXQUFaLEVBQXNCLHFCQUF0QixDQUFuQjtBQUNBLEdBQUMsR0FBR0EsUUFBUSxXQUFaLEVBQXNCVSxRQUF0QixFQUFnQ1AsRUFBaEMsQ0FBbUMsT0FBbkMsRUFBNEMsY0FBNUMsRUFBNEQsWUFBWTtBQUNwRU0sSUFBQUEsWUFBWSxDQUFDRCxXQUFiLENBQXlCLFFBQXpCO0FBQ0EsUUFBSUcsY0FBYyxHQUFHLENBQUMsR0FBR1gsUUFBUSxXQUFaLEVBQXNCLElBQXRCLEVBQTRCWSxRQUE1QixDQUFxQyxzQkFBckMsRUFBNkRDLElBQTdELEVBQXJCO0FBQ0EsS0FBQyxHQUFHYixRQUFRLFdBQVosRUFBc0IsMEJBQXRCLEVBQWtEYSxJQUFsRCxDQUF1REYsY0FBdkQ7QUFDSCxHQUpEO0FBS0EsR0FBQyxHQUFHWCxRQUFRLFdBQVosRUFBc0IscUJBQXRCLEVBQTZDRyxFQUE3QyxDQUFnRCxPQUFoRCxFQUF5RCxZQUFZO0FBQ2pFTSxJQUFBQSxZQUFZLENBQUNLLFFBQWIsQ0FBc0IsUUFBdEI7QUFDSCxHQUZEO0FBR0gsQ0EzQkQsR0E0QkE7O0FBQ0EsQ0FBQyxHQUFHZCxRQUFRLFdBQVosRUFBc0JlLE1BQXRCLEVBQThCWixFQUE5QixDQUFpQyxNQUFqQyxFQUF5QyxZQUFZO0FBQ2pELE1BQUlhLE9BQU8sR0FBRyxDQUFDLEdBQUdoQixRQUFRLFdBQVosRUFBc0IsVUFBdEIsQ0FBZDtBQUNBZ0IsRUFBQUEsT0FBTyxDQUFDRixRQUFSLENBQWlCLFFBQWpCO0FBQ0gsQ0FIRDtBQUlBO0FBQ0E7QUFDQTs7QUFDQSxJQUFJRyxTQUFTLEdBQUcsNEJBQWhCO0FBQUEsSUFBOENDLGdCQUFnQixHQUFHLENBQUMsR0FBR2xCLFFBQVEsV0FBWixFQUFzQmlCLFNBQXRCLENBQWpFOztBQUNBLElBQUlDLGdCQUFnQixDQUFDQyxNQUFqQixHQUEwQixDQUE5QixFQUFpQztBQUM3QixHQUFDLEdBQUduQixRQUFRLFdBQVosRUFBc0IsTUFBdEIsRUFBOEJHLEVBQTlCLENBQWlDLE9BQWpDLEVBQTBDYyxTQUExQyxFQUFxRCxZQUFZO0FBQzdELEtBQUMsR0FBR2pCLFFBQVEsV0FBWixFQUFzQixJQUF0QixFQUE0Qm9CLElBQTVCLENBQWlDLFVBQWpDLEVBQTZDLFVBQTdDO0FBQ0EsS0FBQyxHQUFHcEIsUUFBUSxXQUFaLEVBQXNCLElBQXRCLEVBQTRCcUIsT0FBNUIsQ0FBb0MsTUFBcEMsRUFBNENDLE9BQTVDLENBQW9ELFFBQXBEO0FBQ0gsR0FIRDtBQUlIIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL3NjcmlwdC50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcclxudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XHJcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcclxufTtcclxuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xyXG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XHJcbnZhciBqcXVlcnlfMiA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcclxucmVxdWlyZShcInNlbGVjdDJcIik7XHJcbigwLCBqcXVlcnlfMi5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XHJcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnI2hhbWJ1cmdlcicsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNuYXYtbGlzdCcpLnRvZ2dsZUNsYXNzKCduYXYtYWN0aXZlJyk7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykudG9nZ2xlQ2xhc3MoJ2FjdGl2ZScpO1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnRvZ2dsZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcclxuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNtZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykudG9nZ2xlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xyXG4gICAgfSk7XHJcbiAgICAvLyBjbG9zZSB0aGUgbmF2TWVudSBieSBjbGlja2luZyBvdXRzaWRlXHJcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgIGlmIChlLnRhcmdldC5pZCAhPT0gJ25hdi1saXN0JyAmJiBlLnRhcmdldC5pZCAhPT0gJ2hhbWJ1cmdlcicpIHtcclxuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS5yZW1vdmVDbGFzcygnbmF2LWFjdGl2ZScpO1xyXG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNoYW1idXJnZXInKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XHJcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnJlbW92ZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcclxuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xyXG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eS1tZW51LW92ZXJsYXknKS5yZW1vdmVDbGFzcygnbWVudS1vdmVybGF5Jyk7XHJcbiAgICAgICAgfVxyXG4gICAgfSk7XHJcbiAgICB2YXIgc2lkZWJhckJsb2NrID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2lkZWJhci1oZWxwLWJsb2NrJyk7XHJcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoZG9jdW1lbnQpLm9uKCdjbGljaycsICcuaGVscC1idXR0b24nLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgc2lkZWJhckJsb2NrLnJlbW92ZUNsYXNzKCdoaWRkZW4nKTtcclxuICAgICAgICB2YXIgc2lkZWJhckNvbnRlbnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuc2libGluZ3MoJy5oZWxwLWJ1dHRvbi1jb250ZW50JykuaHRtbCgpO1xyXG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1ibG9jay10ZXh0JykuaHRtbChzaWRlYmFyQ29udGVudCk7XHJcbiAgICB9KTtcclxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1jbG9zZScpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBzaWRlYmFyQmxvY2suYWRkQ2xhc3MoJ2hpZGRlbicpO1xyXG4gICAgfSk7XHJcbn0pO1xyXG4vLyByZW1vdmUgb3ZlcmxheSBwYWdlIGxvYWRlciBhZnRlciBsb2FkaW5nIGNvbXBsZXRlc1xyXG4oMCwganF1ZXJ5XzEuZGVmYXVsdCkod2luZG93KS5vbignbG9hZCcsIGZ1bmN0aW9uICgpIHtcclxuICAgIHZhciBvdmVybGF5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcub3ZlcmxheScpO1xyXG4gICAgb3ZlcmxheS5hZGRDbGFzcygnaGlkZGVuJyk7XHJcbn0pO1xyXG4vKipcclxuICogRGlzYWJsZSBzdWJtaXQgYnV0dG9uIGFmdGVyIHNpbmdsZSAgY2xpY2tcclxuICovXHJcbnZhciBzdWJtaXRCdG4gPSAnZm9ybSBidXR0b25bdHlwZT1cInN1Ym1pdFwiXScsIHN1Ym1pdEJ0bkVsZW1lbnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc3VibWl0QnRuKTtcclxuaWYgKHN1Ym1pdEJ0bkVsZW1lbnQubGVuZ3RoID4gMCkge1xyXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgc3VibWl0QnRuLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJyk7XHJcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLmNsb3Nlc3QoJ2Zvcm0nKS50cmlnZ2VyKCdzdWJtaXQnKTtcclxuICAgIH0pO1xyXG59XHJcbiJdLCJuYW1lcyI6WyJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJleHBvcnRzIiwidmFsdWUiLCJqcXVlcnlfMSIsInJlcXVpcmUiLCJqcXVlcnlfMiIsIm9uIiwidG9nZ2xlQ2xhc3MiLCJlIiwidGFyZ2V0IiwiaWQiLCJyZW1vdmVDbGFzcyIsInNpZGViYXJCbG9jayIsImRvY3VtZW50Iiwic2lkZWJhckNvbnRlbnQiLCJzaWJsaW5ncyIsImh0bWwiLCJhZGRDbGFzcyIsIndpbmRvdyIsIm92ZXJsYXkiLCJzdWJtaXRCdG4iLCJzdWJtaXRCdG5FbGVtZW50IiwibGVuZ3RoIiwiYXR0ciIsImNsb3Nlc3QiLCJ0cmlnZ2VyIl0sInNvdXJjZVJvb3QiOiIifQ==