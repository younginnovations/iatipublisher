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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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SCxDQUZEO0FBR0gsQ0EzQkQsR0E0QkE7O0FBQ0EsQ0FBQyxHQUFHZCxRQUFRLFdBQVosRUFBc0JlLE1BQXRCLEVBQThCWixFQUE5QixDQUFpQyxNQUFqQyxFQUF5QyxZQUFZO0VBQ2pELElBQUlhLE9BQU8sR0FBRyxDQUFDLEdBQUdoQixRQUFRLFdBQVosRUFBc0IsVUFBdEIsQ0FBZDtFQUNBZ0IsT0FBTyxDQUFDRixRQUFSLENBQWlCLFFBQWpCO0FBQ0gsQ0FIRDtBQUlBO0FBQ0E7QUFDQTs7QUFDQSxJQUFJRyxTQUFTLEdBQUcsNEJBQWhCO0FBQUEsSUFBOENDLGdCQUFnQixHQUFHLENBQUMsR0FBR2xCLFFBQVEsV0FBWixFQUFzQmlCLFNBQXRCLENBQWpFOztBQUNBLElBQUlDLGdCQUFnQixDQUFDQyxNQUFqQixHQUEwQixDQUE5QixFQUFpQztFQUM3QixDQUFDLEdBQUduQixRQUFRLFdBQVosRUFBc0IsTUFBdEIsRUFBOEJHLEVBQTlCLENBQWlDLE9BQWpDLEVBQTBDYyxTQUExQyxFQUFxRCxZQUFZO0lBQzdELENBQUMsR0FBR2pCLFFBQVEsV0FBWixFQUFzQixJQUF0QixFQUE0Qm9CLElBQTVCLENBQWlDLFVBQWpDLEVBQTZDLFVBQTdDO0lBQ0EsQ0FBQyxHQUFHcEIsUUFBUSxXQUFaLEVBQXNCLElBQXRCLEVBQTRCcUIsT0FBNUIsQ0FBb0MsTUFBcEMsRUFBNENDLE9BQTVDLENBQW9ELFFBQXBEO0VBQ0gsQ0FIRDtBQUlIIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL3NjcmlwdC50cyJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcbnZhciBfX2ltcG9ydERlZmF1bHQgPSAodGhpcyAmJiB0aGlzLl9faW1wb3J0RGVmYXVsdCkgfHwgZnVuY3Rpb24gKG1vZCkge1xuICAgIHJldHVybiAobW9kICYmIG1vZC5fX2VzTW9kdWxlKSA/IG1vZCA6IHsgXCJkZWZhdWx0XCI6IG1vZCB9O1xufTtcbk9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBcIl9fZXNNb2R1bGVcIiwgeyB2YWx1ZTogdHJ1ZSB9KTtcbnZhciBqcXVlcnlfMSA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbnZhciBqcXVlcnlfMiA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbigwLCBqcXVlcnlfMi5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJyNoYW1idXJnZXInLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykudG9nZ2xlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykudG9nZ2xlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS50b2dnbGVDbGFzcygnb3ZlcmZsb3ctaGlkZGVuJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI21lbnUtb3ZlcmxheScpLnRvZ2dsZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykudG9nZ2xlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgIH0pO1xuICAgIC8vIGNsb3NlIHRoZSBuYXZNZW51IGJ5IGNsaWNraW5nIG91dHNpZGVcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICBpZiAoZS50YXJnZXQuY2xhc3NMaXN0WzBdID09ICdtZW51LW92ZXJsYXknKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNuYXYtbGlzdCcpLnJlbW92ZUNsYXNzKCduYXYtYWN0aXZlJyk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNoYW1idXJnZXInKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5yZW1vdmVDbGFzcygnb3ZlcmZsb3ctaGlkZGVuJyk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNtZW51LW92ZXJsYXknKS5yZW1vdmVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eS1tZW51LW92ZXJsYXknKS5yZW1vdmVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgIH1cbiAgICB9KTtcbiAgICB2YXIgc2lkZWJhckJsb2NrID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcuc2lkZWJhci1oZWxwLWJsb2NrJyk7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKGRvY3VtZW50KS5vbignY2xpY2snLCAnLmhlbHAtYnV0dG9uJywgZnVuY3Rpb24gKCkge1xuICAgICAgICBzaWRlYmFyQmxvY2sucmVtb3ZlQ2xhc3MoJ2hpZGRlbicpO1xuICAgICAgICB2YXIgc2lkZWJhckNvbnRlbnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkodGhpcykuc2libGluZ3MoJy5oZWxwLWJ1dHRvbi1jb250ZW50JykuaHRtbCgpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJy5zaWRlYmFyLWhlbHAtYmxvY2stdGV4dCcpLmh0bWwoc2lkZWJhckNvbnRlbnQpO1xuICAgIH0pO1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnLnNpZGViYXItaGVscC1jbG9zZScpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgc2lkZWJhckJsb2NrLmFkZENsYXNzKCdoaWRkZW4nKTtcbiAgICB9KTtcbn0pO1xuLy8gcmVtb3ZlIG92ZXJsYXkgcGFnZSBsb2FkZXIgYWZ0ZXIgbG9hZGluZyBjb21wbGV0ZXNcbigwLCBqcXVlcnlfMS5kZWZhdWx0KSh3aW5kb3cpLm9uKCdsb2FkJywgZnVuY3Rpb24gKCkge1xuICAgIHZhciBvdmVybGF5ID0gKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcub3ZlcmxheScpO1xuICAgIG92ZXJsYXkuYWRkQ2xhc3MoJ2hpZGRlbicpO1xufSk7XG4vKipcbiAqIERpc2FibGUgc3VibWl0IGJ1dHRvbiBhZnRlciBzaW5nbGUgIGNsaWNrXG4gKi9cbnZhciBzdWJtaXRCdG4gPSAnZm9ybSBidXR0b25bdHlwZT1cInN1Ym1pdFwiXScsIHN1Ym1pdEJ0bkVsZW1lbnQgPSAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoc3VibWl0QnRuKTtcbmlmIChzdWJtaXRCdG5FbGVtZW50Lmxlbmd0aCA+IDApIHtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCBzdWJtaXRCdG4sIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKHRoaXMpLmF0dHIoJ2Rpc2FibGVkJywgJ2Rpc2FibGVkJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSh0aGlzKS5jbG9zZXN0KCdmb3JtJykudHJpZ2dlcignc3VibWl0Jyk7XG4gICAgfSk7XG59XG4iXSwibmFtZXMiOlsiX19pbXBvcnREZWZhdWx0IiwibW9kIiwiX19lc01vZHVsZSIsIk9iamVjdCIsImRlZmluZVByb3BlcnR5IiwiZXhwb3J0cyIsInZhbHVlIiwianF1ZXJ5XzEiLCJyZXF1aXJlIiwianF1ZXJ5XzIiLCJvbiIsInRvZ2dsZUNsYXNzIiwiZSIsInRhcmdldCIsImNsYXNzTGlzdCIsInJlbW92ZUNsYXNzIiwic2lkZWJhckJsb2NrIiwiZG9jdW1lbnQiLCJzaWRlYmFyQ29udGVudCIsInNpYmxpbmdzIiwiaHRtbCIsImFkZENsYXNzIiwid2luZG93Iiwib3ZlcmxheSIsInN1Ym1pdEJ0biIsInN1Ym1pdEJ0bkVsZW1lbnQiLCJsZW5ndGgiLCJhdHRyIiwiY2xvc2VzdCIsInRyaWdnZXIiXSwic291cmNlUm9vdCI6IiJ9