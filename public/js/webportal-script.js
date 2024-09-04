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
  });
  // close the navMenu by clicking outside
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiL2pzL3dlYnBvcnRhbC1zY3JpcHQuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQWE7O0FBQ2IsSUFBSUEsZUFBZSxHQUFJLElBQUksSUFBSSxJQUFJLENBQUNBLGVBQWUsSUFBSyxVQUFVQyxHQUFHLEVBQUU7RUFDbkUsT0FBUUEsR0FBRyxJQUFJQSxHQUFHLENBQUNDLFVBQVUsR0FBSUQsR0FBRyxHQUFHO0lBQUUsU0FBUyxFQUFFQTtFQUFJLENBQUM7QUFDN0QsQ0FBQztBQUNERSw4Q0FBNkM7RUFBRUcsS0FBSyxFQUFFO0FBQUssQ0FBQyxFQUFDO0FBQzdELElBQUlDLFFBQVEsR0FBR1AsZUFBZSxDQUFDUSxtQkFBTyxDQUFDLG9EQUFRLENBQUMsQ0FBQztBQUNqRCxJQUFJQyxRQUFRLEdBQUdULGVBQWUsQ0FBQ1EsbUJBQU8sQ0FBQyxvREFBUSxDQUFDLENBQUM7QUFDakQsQ0FBQyxDQUFDLEVBQUVDLFFBQVEsV0FBUSxFQUFFLFlBQVk7RUFDOUIsQ0FBQyxDQUFDLEVBQUVGLFFBQVEsV0FBUSxFQUFFLE1BQU0sQ0FBQyxDQUFDRyxFQUFFLENBQUMsT0FBTyxFQUFFLFlBQVksRUFBRSxZQUFZO0lBQ2hFLENBQUMsQ0FBQyxFQUFFSCxRQUFRLFdBQVEsRUFBRSxXQUFXLENBQUMsQ0FBQ0ksV0FBVyxDQUFDLFlBQVksQ0FBQztJQUM1RCxDQUFDLENBQUMsRUFBRUosUUFBUSxXQUFRLEVBQUUsWUFBWSxDQUFDLENBQUNJLFdBQVcsQ0FBQyxRQUFRLENBQUM7SUFDekQsQ0FBQyxDQUFDLEVBQUVKLFFBQVEsV0FBUSxFQUFFLE1BQU0sQ0FBQyxDQUFDSSxXQUFXLENBQUMsaUJBQWlCLENBQUM7SUFDNUQsQ0FBQyxDQUFDLEVBQUVKLFFBQVEsV0FBUSxFQUFFLGVBQWUsQ0FBQyxDQUFDSSxXQUFXLENBQUMsY0FBYyxDQUFDO0lBQ2xFLENBQUMsQ0FBQyxFQUFFSixRQUFRLFdBQVEsRUFBRSx3QkFBd0IsQ0FBQyxDQUFDSSxXQUFXLENBQUMsY0FBYyxDQUFDO0VBQy9FLENBQUMsQ0FBQztFQUNGO0VBQ0EsQ0FBQyxDQUFDLEVBQUVKLFFBQVEsV0FBUSxFQUFFLE1BQU0sQ0FBQyxDQUFDRyxFQUFFLENBQUMsT0FBTyxFQUFFLFVBQVVFLENBQUMsRUFBRTtJQUNuRCxJQUFJQSxDQUFDLENBQUNDLE1BQU0sQ0FBQ0MsU0FBUyxDQUFDLENBQUMsQ0FBQyxLQUFLLGNBQWMsRUFBRTtNQUMxQyxDQUFDLENBQUMsRUFBRVAsUUFBUSxXQUFRLEVBQUUsV0FBVyxDQUFDLENBQUNRLFdBQVcsQ0FBQyxZQUFZLENBQUM7TUFDNUQsQ0FBQyxDQUFDLEVBQUVSLFFBQVEsV0FBUSxFQUFFLFlBQVksQ0FBQyxDQUFDUSxXQUFXLENBQUMsUUFBUSxDQUFDO01BQ3pELENBQUMsQ0FBQyxFQUFFUixRQUFRLFdBQVEsRUFBRSxNQUFNLENBQUMsQ0FBQ1EsV0FBVyxDQUFDLGlCQUFpQixDQUFDO01BQzVELENBQUMsQ0FBQyxFQUFFUixRQUFRLFdBQVEsRUFBRSxlQUFlLENBQUMsQ0FBQ1EsV0FBVyxDQUFDLGNBQWMsQ0FBQztNQUNsRSxDQUFDLENBQUMsRUFBRVIsUUFBUSxXQUFRLEVBQUUsd0JBQXdCLENBQUMsQ0FBQ1EsV0FBVyxDQUFDLGNBQWMsQ0FBQztJQUMvRTtFQUNKLENBQUMsQ0FBQztBQUNOLENBQUMsQ0FBQyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy93ZWJwb3J0YWwtc2NyaXB0LnRzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xudmFyIGpxdWVyeV8xID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xudmFyIGpxdWVyeV8yID0gX19pbXBvcnREZWZhdWx0KHJlcXVpcmUoXCJqcXVlcnlcIikpO1xuKDAsIGpxdWVyeV8yLmRlZmF1bHQpKGZ1bmN0aW9uICgpIHtcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAnI2hhbWJ1cmdlcicsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS50b2dnbGVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNoYW1idXJnZXInKS50b2dnbGVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLnRvZ2dsZUNsYXNzKCdvdmVyZmxvdy1oaWRkZW4nKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykudG9nZ2xlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eS1tZW51LW92ZXJsYXknKS50b2dnbGVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgfSk7XG4gICAgLy8gY2xvc2UgdGhlIG5hdk1lbnUgYnkgY2xpY2tpbmcgb3V0c2lkZVxuICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnYm9keScpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIGlmIChlLnRhcmdldC5jbGFzc0xpc3RbMF0gPT09ICdtZW51LW92ZXJsYXknKSB7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNuYXYtbGlzdCcpLnJlbW92ZUNsYXNzKCduYXYtYWN0aXZlJyk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNoYW1idXJnZXInKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5yZW1vdmVDbGFzcygnb3ZlcmZsb3ctaGlkZGVuJyk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNtZW51LW92ZXJsYXknKS5yZW1vdmVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJyNhY3Rpdml0eS1tZW51LW92ZXJsYXknKS5yZW1vdmVDbGFzcygnbWVudS1vdmVybGF5Jyk7XG4gICAgICAgIH1cbiAgICB9KTtcbn0pO1xuIl0sIm5hbWVzIjpbIl9faW1wb3J0RGVmYXVsdCIsIm1vZCIsIl9fZXNNb2R1bGUiLCJPYmplY3QiLCJkZWZpbmVQcm9wZXJ0eSIsImV4cG9ydHMiLCJ2YWx1ZSIsImpxdWVyeV8xIiwicmVxdWlyZSIsImpxdWVyeV8yIiwib24iLCJ0b2dnbGVDbGFzcyIsImUiLCJ0YXJnZXQiLCJjbGFzc0xpc3QiLCJyZW1vdmVDbGFzcyJdLCJzb3VyY2VSb290IjoiIn0=