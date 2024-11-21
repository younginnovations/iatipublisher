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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiL2pzL3dlYnBvcnRhbC1zY3JpcHQuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQWE7O0FBQ2IsSUFBSUEsZUFBZSxHQUFJLElBQUksSUFBSSxJQUFJLENBQUNBLGVBQWUsSUFBSyxVQUFVQyxHQUFHLEVBQUU7RUFDbkUsT0FBUUEsR0FBRyxJQUFJQSxHQUFHLENBQUNDLFVBQVUsR0FBSUQsR0FBRyxHQUFHO0lBQUUsU0FBUyxFQUFFQTtFQUFJLENBQUM7QUFDN0QsQ0FBQztBQUNERSw4Q0FBNkM7RUFBRUcsS0FBSyxFQUFFO0FBQUssQ0FBQyxFQUFDO0FBQzdELElBQU1DLFFBQVEsR0FBR1AsZUFBZSxDQUFDUSxtQkFBTyxDQUFDLG9EQUFRLENBQUMsQ0FBQztBQUNuRCxJQUFNQyxRQUFRLEdBQUdULGVBQWUsQ0FBQ1EsbUJBQU8sQ0FBQyxvREFBUSxDQUFDLENBQUM7QUFDbkQsQ0FBQyxDQUFDLEVBQUVDLFFBQVEsV0FBUSxFQUFFLFlBQVk7RUFDOUIsQ0FBQyxDQUFDLEVBQUVGLFFBQVEsV0FBUSxFQUFFLE1BQU0sQ0FBQyxDQUFDRyxFQUFFLENBQUMsT0FBTyxFQUFFLFlBQVksRUFBRSxZQUFNO0lBQzFELENBQUMsQ0FBQyxFQUFFSCxRQUFRLFdBQVEsRUFBRSxXQUFXLENBQUMsQ0FBQ0ksV0FBVyxDQUFDLFlBQVksQ0FBQztJQUM1RCxDQUFDLENBQUMsRUFBRUosUUFBUSxXQUFRLEVBQUUsWUFBWSxDQUFDLENBQUNJLFdBQVcsQ0FBQyxRQUFRLENBQUM7SUFDekQsQ0FBQyxDQUFDLEVBQUVKLFFBQVEsV0FBUSxFQUFFLE1BQU0sQ0FBQyxDQUFDSSxXQUFXLENBQUMsaUJBQWlCLENBQUM7SUFDNUQsQ0FBQyxDQUFDLEVBQUVKLFFBQVEsV0FBUSxFQUFFLGVBQWUsQ0FBQyxDQUFDSSxXQUFXLENBQUMsY0FBYyxDQUFDO0lBQ2xFLENBQUMsQ0FBQyxFQUFFSixRQUFRLFdBQVEsRUFBRSx3QkFBd0IsQ0FBQyxDQUFDSSxXQUFXLENBQUMsY0FBYyxDQUFDO0VBQy9FLENBQUMsQ0FBQztFQUNGO0VBQ0EsQ0FBQyxDQUFDLEVBQUVKLFFBQVEsV0FBUSxFQUFFLE1BQU0sQ0FBQyxDQUFDRyxFQUFFLENBQUMsT0FBTyxFQUFFLFVBQUNFLENBQUMsRUFBSztJQUM3QyxJQUFJQSxDQUFDLENBQUNDLE1BQU0sQ0FBQ0MsU0FBUyxDQUFDLENBQUMsQ0FBQyxLQUFLLGNBQWMsRUFBRTtNQUMxQyxDQUFDLENBQUMsRUFBRVAsUUFBUSxXQUFRLEVBQUUsV0FBVyxDQUFDLENBQUNRLFdBQVcsQ0FBQyxZQUFZLENBQUM7TUFDNUQsQ0FBQyxDQUFDLEVBQUVSLFFBQVEsV0FBUSxFQUFFLFlBQVksQ0FBQyxDQUFDUSxXQUFXLENBQUMsUUFBUSxDQUFDO01BQ3pELENBQUMsQ0FBQyxFQUFFUixRQUFRLFdBQVEsRUFBRSxNQUFNLENBQUMsQ0FBQ1EsV0FBVyxDQUFDLGlCQUFpQixDQUFDO01BQzVELENBQUMsQ0FBQyxFQUFFUixRQUFRLFdBQVEsRUFBRSxlQUFlLENBQUMsQ0FBQ1EsV0FBVyxDQUFDLGNBQWMsQ0FBQztNQUNsRSxDQUFDLENBQUMsRUFBRVIsUUFBUSxXQUFRLEVBQUUsd0JBQXdCLENBQUMsQ0FBQ1EsV0FBVyxDQUFDLGNBQWMsQ0FBQztJQUMvRTtFQUNKLENBQUMsQ0FBQztBQUNOLENBQUMsQ0FBQyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvc2NyaXB0cy93ZWJwb3J0YWwtc2NyaXB0LnRzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xudmFyIF9faW1wb3J0RGVmYXVsdCA9ICh0aGlzICYmIHRoaXMuX19pbXBvcnREZWZhdWx0KSB8fCBmdW5jdGlvbiAobW9kKSB7XG4gICAgcmV0dXJuIChtb2QgJiYgbW9kLl9fZXNNb2R1bGUpID8gbW9kIDogeyBcImRlZmF1bHRcIjogbW9kIH07XG59O1xuT2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFwiX19lc01vZHVsZVwiLCB7IHZhbHVlOiB0cnVlIH0pO1xuY29uc3QganF1ZXJ5XzEgPSBfX2ltcG9ydERlZmF1bHQocmVxdWlyZShcImpxdWVyeVwiKSk7XG5jb25zdCBqcXVlcnlfMiA9IF9faW1wb3J0RGVmYXVsdChyZXF1aXJlKFwianF1ZXJ5XCIpKTtcbigwLCBqcXVlcnlfMi5kZWZhdWx0KShmdW5jdGlvbiAoKSB7XG4gICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5Jykub24oJ2NsaWNrJywgJyNoYW1idXJnZXInLCAoKSA9PiB7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI25hdi1saXN0JykudG9nZ2xlQ2xhc3MoJ25hdi1hY3RpdmUnKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykudG9nZ2xlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS50b2dnbGVDbGFzcygnb3ZlcmZsb3ctaGlkZGVuJyk7XG4gICAgICAgICgwLCBqcXVlcnlfMS5kZWZhdWx0KSgnI21lbnUtb3ZlcmxheScpLnRvZ2dsZUNsYXNzKCdtZW51LW92ZXJsYXknKTtcbiAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykudG9nZ2xlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgIH0pO1xuICAgIC8vIGNsb3NlIHRoZSBuYXZNZW51IGJ5IGNsaWNraW5nIG91dHNpZGVcbiAgICAoMCwganF1ZXJ5XzEuZGVmYXVsdCkoJ2JvZHknKS5vbignY2xpY2snLCAoZSkgPT4ge1xuICAgICAgICBpZiAoZS50YXJnZXQuY2xhc3NMaXN0WzBdID09PSAnbWVudS1vdmVybGF5Jykge1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbmF2LWxpc3QnKS5yZW1vdmVDbGFzcygnbmF2LWFjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjaGFtYnVyZ2VyJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCdib2R5JykucmVtb3ZlQ2xhc3MoJ292ZXJmbG93LWhpZGRlbicpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICAgICAgKDAsIGpxdWVyeV8xLmRlZmF1bHQpKCcjYWN0aXZpdHktbWVudS1vdmVybGF5JykucmVtb3ZlQ2xhc3MoJ21lbnUtb3ZlcmxheScpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTtcbiJdLCJuYW1lcyI6WyJfX2ltcG9ydERlZmF1bHQiLCJtb2QiLCJfX2VzTW9kdWxlIiwiT2JqZWN0IiwiZGVmaW5lUHJvcGVydHkiLCJleHBvcnRzIiwidmFsdWUiLCJqcXVlcnlfMSIsInJlcXVpcmUiLCJqcXVlcnlfMiIsIm9uIiwidG9nZ2xlQ2xhc3MiLCJlIiwidGFyZ2V0IiwiY2xhc3NMaXN0IiwicmVtb3ZlQ2xhc3MiXSwic291cmNlUm9vdCI6IiJ9