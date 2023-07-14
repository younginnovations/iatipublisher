"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/webportal-script"],{

/***/ "./resources/assets/js/scripts/webportal-script.ts":
/*!*********************************************************!*\
  !*** ./resources/assets/js/scripts/webportal-script.ts ***!
  \*********************************************************/
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
    if (e.target.classList[0] === 'menu-overlay') {
      (0, jquery_1["default"])('#nav-list').removeClass('nav-active');
      (0, jquery_1["default"])('#hamburger').removeClass('active');
      (0, jquery_1["default"])('body').removeClass('overflow-hidden');
      (0, jquery_1["default"])('#menu-overlay').removeClass('menu-overlay');
      (0, jquery_1["default"])('#activity-menu-overlay').removeClass('menu-overlay');
    }
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["/js/vendor"], () => (__webpack_exec__("./resources/assets/js/scripts/webportal-script.ts")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiL2pzL3dlYnBvcnRhbC1zY3JpcHQuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQWE7O0FBQ2IsSUFBSUEsZUFBZSxHQUFJLFFBQVEsS0FBS0EsZUFBZCxJQUFrQyxVQUFVQyxHQUFWLEVBQWU7RUFDbkUsT0FBUUEsR0FBRyxJQUFJQSxHQUFHLENBQUNDLFVBQVosR0FBMEJELEdBQTFCLEdBQWdDO0lBQUUsV0FBV0E7RUFBYixDQUF2QztBQUNILENBRkQ7O0FBR0FFLDhDQUE2QztFQUFFRyxLQUFLLEVBQUU7QUFBVCxDQUE3Qzs7QUFDQSxJQUFJQyxRQUFRLEdBQUdQLGVBQWUsQ0FBQ1EsbUJBQU8sQ0FBQyxvREFBRCxDQUFSLENBQTlCOztBQUNBLElBQUlDLFFBQVEsR0FBR1QsZUFBZSxDQUFDUSxtQkFBTyxDQUFDLG9EQUFELENBQVIsQ0FBOUI7O0FBQ0EsQ0FBQyxHQUFHQyxRQUFRLFdBQVosRUFBc0IsWUFBWTtFQUM5QixDQUFDLEdBQUdGLFFBQVEsV0FBWixFQUFzQixNQUF0QixFQUE4QkcsRUFBOUIsQ0FBaUMsT0FBakMsRUFBMEMsWUFBMUMsRUFBd0QsWUFBWTtJQUNoRSxDQUFDLEdBQUdILFFBQVEsV0FBWixFQUFzQixXQUF0QixFQUFtQ0ksV0FBbkMsQ0FBK0MsWUFBL0M7SUFDQSxDQUFDLEdBQUdKLFFBQVEsV0FBWixFQUFzQixZQUF0QixFQUFvQ0ksV0FBcEMsQ0FBZ0QsUUFBaEQ7SUFDQSxDQUFDLEdBQUdKLFFBQVEsV0FBWixFQUFzQixNQUF0QixFQUE4QkksV0FBOUIsQ0FBMEMsaUJBQTFDO0lBQ0EsQ0FBQyxHQUFHSixRQUFRLFdBQVosRUFBc0IsZUFBdEIsRUFBdUNJLFdBQXZDLENBQW1ELGNBQW5EO0lBQ0EsQ0FBQyxHQUFHSixRQUFRLFdBQVosRUFBc0Isd0JBQXRCLEVBQWdESSxXQUFoRCxDQUE0RCxjQUE1RDtFQUNILENBTkQsRUFEOEIsQ0FROUI7O0VBQ0EsQ0FBQyxHQUFHSixRQUFRLFdBQVosRUFBc0IsTUFBdEIsRUFBOEJHLEVBQTlCLENBQWlDLE9BQWpDLEVBQTBDLFVBQVVFLENBQVYsRUFBYTtJQUNuRCxJQUFJQSxDQUFDLENBQUNDLE1BQUYsQ0FBU0MsU0FBVCxDQUFtQixDQUFuQixNQUEwQixjQUE5QixFQUE4QztNQUMxQyxDQUFDLEdBQUdQLFFBQVEsV0FBWixFQUFzQixXQUF0QixFQUFtQ1EsV0FBbkMsQ0FBK0MsWUFBL0M7TUFDQSxDQUFDLEdBQUdSLFFBQVEsV0FBWixFQUFzQixZQUF0QixFQUFvQ1EsV0FBcEMsQ0FBZ0QsUUFBaEQ7TUFDQSxDQUFDLEdBQUdSLFFBQVEsV0FBWixFQUFzQixNQUF0QixFQUE4QlEsV0FBOUIsQ0FBMEMsaUJBQTFDO01BQ0EsQ0FBQyxHQUFHUixRQUFRLFdBQVosRUFBc0IsZUFBdEIsRUFBdUNRLFdBQXZDLENBQW1ELGNBQW5EO01BQ0EsQ0FBQyxHQUFHUixRQUFRLFdBQVosRUFBc0Isd0JBQXRCLEVBQWdEUSxXQUFoRCxDQUE0RCxjQUE1RDtJQUNIO0VBQ0osQ0FSRDtBQVNILENBbEJEIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL3dlYnBvcnRhbC1zY3JpcHQudHMiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG52YXIgX19pbXBvcnREZWZhdWx0ID0gKHRoaXMgJiYgdGhpcy5fX2ltcG9ydERlZmF1bHQpIHx8IGZ1bmN0aW9uIChtb2QpIHtcbiAgICByZXR1cm4gKG1vZCAmJiBtb2QuX19lc01vZHVsZSkgPyBtb2QgOiB7IFwiZGVmYXVsdFwiOiBtb2QgfTtcbn07XG5PYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgXCJfX2VzTW9kdWxlXCIsIHsgdmFsdWU6IHRydWUgfSk7XG52YXIganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG52YXIganF1ZXJ5XzIgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG4oMCwganF1ZXJ5XzIuZGVmYXVsdCkoZnVuY3Rpb24gKCkge1xuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsICcjaGFtYnVyZ2VyJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNuYXYtbGlzdCcpLnRvZ2dsZUNsYXNzKCduYXYtYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnRvZ2dsZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykudG9nZ2xlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNtZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnRvZ2dsZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICB9KTtcbiAgICAvLyBjbG9zZSB0aGUgbmF2TWVudSBieSBjbGlja2luZyBvdXRzaWRlXG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgaWYgKGUudGFyZ2V0LmNsYXNzTGlzdFswXSA9PT0gJ21lbnUtb3ZlcmxheScpIHtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykucmVtb3ZlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2hhbWJ1cmdlcicpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnJlbW92ZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI21lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI2FjdGl2aXR5LW1lbnUtb3ZlcmxheScpLnJlbW92ZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgfVxuICAgIH0pO1xufSk7XG4iXSwibmFtZXMiOlsiX19pbXBvcnREZWZhdWx0IiwibW9kIiwiX19lc01vZHVsZSIsIk9iamVjdCIsImRlZmluZVByb3BlcnR5IiwiZXhwb3J0cyIsInZhbHVlIiwianF1ZXJ5XzEiLCJyZXF1aXJlIiwianF1ZXJ5XzIiLCJvbiIsInRvZ2dsZUNsYXNzIiwiZSIsInRhcmdldCIsImNsYXNzTGlzdCIsInJlbW92ZUNsYXNzIl0sInNvdXJjZVJvb3QiOiIifQ==