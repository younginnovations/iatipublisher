/******/ (() => {
  // webpackBootstrap
  /******/ var __webpack_modules__ = {
    /***/ './resources/assets/js/scripts/script.js':
      /*!***********************************************!*\
  !*** ./resources/assets/js/scripts/script.js ***!
  \***********************************************/
      /***/ () => {
        // Hamburger menu
        var burger = document.getElementById('hamburger');
        var nav = document.getElementById('nav-list');
        burger.addEventListener('click', function () {
          nav.classList.toggle('nav-active');
          burger.classList.toggle('active');
          document.body.classList.toggle('overflow-hidden');
        }); // close the navMenu by clicking outside

        document.addEventListener('click', function (e) {
          if (e.target.id !== 'nav-list' && e.target.id !== 'hamburger') {
            nav.classList.remove('nav-active');
            burger.classList.remove('active');
            document.body.classList.remove('overflow-hidden');
          }
        }); // Active class

        var menuItem = document.querySelectorAll('.languages a');
        var menuLength = menuItem.length;

        var _loop = function _loop(i) {
          menuItem[i].addEventListener('click', function (e) {
            for (var j = 0; j < menuLength; j += 1) {
              if (menuItem[i] !== menuItem[j]) {
                menuItem[j].classList.remove('nav__active');
                menuItem[j].classList.remove('links__active');
              }
            }

            e.stopPropagation();
            e.currentTarget.classList.add('nav__active');
            e.currentTarget.classList.add('links__active');
          });
        };

        for (var i = 0; i < menuLength; i += 1) {
          _loop(i);
        } // Form validation

        var submitButton = document.getElementById('btn');
        var username = document.querySelector('.username');
        var password = document.querySelector('.password');

        function nameValidation() {
          if (!username.value) {
            username.style.border = '1.5px solid crimson';
          }
        }

        function passwordValidation() {
          if (!password.value) {
            password.style.border = '1.5px solid crimson';
          }
        }

        submitButton.addEventListener('click', function (e) {
          e.preventDefault();
          nameValidation();
          passwordValidation();
        });

        /***/
      },

    /***/ './resources/assets/sass/app.scss':
      /*!****************************************!*\
  !*** ./resources/assets/sass/app.scss ***!
  \****************************************/
      /***/ (
        __unused_webpack_module,
        __webpack_exports__,
        __webpack_require__
      ) => {
        'use strict';
        __webpack_require__.r(__webpack_exports__);
        // extracted by mini-css-extract-plugin

        /***/
      },

    /******/
  };
  /************************************************************************/
  /******/ // The module cache
  /******/ var __webpack_module_cache__ = {};
  /******/
  /******/ // The require function
  /******/ function __webpack_require__(moduleId) {
    /******/ // Check if module is in cache
    /******/ var cachedModule = __webpack_module_cache__[moduleId];
    /******/ if (cachedModule !== undefined) {
      /******/ return cachedModule.exports;
      /******/
    }
    /******/ // Create a new module (and put it into the cache)
    /******/ var module = (__webpack_module_cache__[moduleId] = {
      /******/ // no module.id needed
      /******/ // no module.loaded needed
      /******/ exports: {},
      /******/
    });
    /******/
    /******/ // Execute the module function
    /******/ __webpack_modules__[moduleId](
      module,
      module.exports,
      __webpack_require__
    );
    /******/
    /******/ // Return the exports of the module
    /******/ return module.exports;
    /******/
  }
  /******/
  /******/ // expose the modules object (__webpack_modules__)
  /******/ __webpack_require__.m = __webpack_modules__;
  /******/
  /************************************************************************/
  /******/ /* webpack/runtime/chunk loaded */
  /******/ (() => {
    /******/ var deferred = [];
    /******/ __webpack_require__.O = (result, chunkIds, fn, priority) => {
      /******/ if (chunkIds) {
        /******/ priority = priority || 0;
        /******/ for (
          var i = deferred.length;
          i > 0 && deferred[i - 1][2] > priority;
          i--
        )
          deferred[i] = deferred[i - 1];
        /******/ deferred[i] = [chunkIds, fn, priority];
        /******/ return;
        /******/
      }
      /******/ var notFulfilled = Infinity;
      /******/ for (var i = 0; i < deferred.length; i++) {
        /******/ var [chunkIds, fn, priority] = deferred[i];
        /******/ var fulfilled = true;
        /******/ for (var j = 0; j < chunkIds.length; j++) {
          /******/ if (
            (priority & (1 === 0) || notFulfilled >= priority) &&
            Object.keys(__webpack_require__.O).every((key) =>
              __webpack_require__.O[key](chunkIds[j])
            )
          ) {
            /******/ chunkIds.splice(j--, 1);
            /******/
          } else {
            /******/ fulfilled = false;
            /******/ if (priority < notFulfilled) notFulfilled = priority;
            /******/
          }
          /******/
        }
        /******/ if (fulfilled) {
          /******/ deferred.splice(i--, 1);
          /******/ var r = fn();
          /******/ if (r !== undefined) result = r;
          /******/
        }
        /******/
      }
      /******/ return result;
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/hasOwnProperty shorthand */
  /******/ (() => {
    /******/ __webpack_require__.o = (obj, prop) =>
      Object.prototype.hasOwnProperty.call(obj, prop);
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/make namespace object */
  /******/ (() => {
    /******/ // define __esModule on exports
    /******/ __webpack_require__.r = (exports) => {
      /******/ if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
        /******/ Object.defineProperty(exports, Symbol.toStringTag, {
          value: 'Module',
        });
        /******/
      }
      /******/ Object.defineProperty(exports, '__esModule', { value: true });
      /******/
    };
    /******/
  })();
  /******/
  /******/ /* webpack/runtime/jsonp chunk loading */
  /******/ (() => {
    /******/ // no baseURI
    /******/
    /******/ // object to store loaded and loading chunks
    /******/ // undefined = chunk not loaded, null = chunk preloaded/prefetched
    /******/ // [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
    /******/ var installedChunks = {
      /******/ '/js/script': 0,
      /******/ 'css/app': 0,
      /******/
    };
    /******/
    /******/ // no chunk on demand loading
    /******/
    /******/ // no prefetching
    /******/
    /******/ // no preloaded
    /******/
    /******/ // no HMR
    /******/
    /******/ // no HMR manifest
    /******/
    /******/ __webpack_require__.O.j = (chunkId) =>
      installedChunks[chunkId] === 0;
    /******/
    /******/ // install a JSONP callback for chunk loading
    /******/ var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
      /******/ var [chunkIds, moreModules, runtime] = data;
      /******/ // add "moreModules" to the modules object,
      /******/ // then flag all "chunkIds" as loaded and fire callback
      /******/ var moduleId,
        chunkId,
        i = 0;
      /******/ if (chunkIds.some((id) => installedChunks[id] !== 0)) {
        /******/ for (moduleId in moreModules) {
          /******/ if (__webpack_require__.o(moreModules, moduleId)) {
            /******/ __webpack_require__.m[moduleId] = moreModules[moduleId];
            /******/
          }
          /******/
        }
        /******/ if (runtime) var result = runtime(__webpack_require__);
        /******/
      }
      /******/ if (parentChunkLoadingFunction) parentChunkLoadingFunction(data);
      /******/ for (; i < chunkIds.length; i++) {
        /******/ chunkId = chunkIds[i];
        /******/ if (
          __webpack_require__.o(installedChunks, chunkId) &&
          installedChunks[chunkId]
        ) {
          /******/ installedChunks[chunkId][0]();
          /******/
        }
        /******/ installedChunks[chunkId] = 0;
        /******/
      }
      /******/ return __webpack_require__.O(result);
      /******/
    };
    /******/
    /******/ var chunkLoadingGlobal = (self['webpackChunk'] =
      self['webpackChunk'] || []);
    /******/ chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
    /******/ chunkLoadingGlobal.push = webpackJsonpCallback.bind(
      null,
      chunkLoadingGlobal.push.bind(chunkLoadingGlobal)
    );
    /******/
  })();
  /******/
  /************************************************************************/
  /******/
  /******/ // startup
  /******/ // Load entry module and return exports
  /******/ // This entry module depends on other loaded chunks and execution need to be delayed
  /******/ __webpack_require__.O(undefined, ['css/app'], () =>
    __webpack_require__('./resources/assets/js/scripts/script.js')
  );
  /******/ var __webpack_exports__ = __webpack_require__.O(
    undefined,
    ['css/app'],
    () => __webpack_require__('./resources/assets/sass/app.scss')
  );
  /******/ __webpack_exports__ = __webpack_require__.O(__webpack_exports__);
  /******/
  /******/
})();
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiL2pzL3NjcmlwdC5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQTtBQUNBLElBQU1BLE1BQU0sR0FBR0MsUUFBUSxDQUFDQyxjQUFURCxDQUF3QixXQUF4QkEsQ0FBZjtBQUNBLElBQU1FLEdBQUcsR0FBR0YsUUFBUSxDQUFDQyxjQUFURCxDQUF3QixVQUF4QkEsQ0FBWjtBQUVBRCxNQUFNLENBQUNJLGdCQUFQSixDQUF3QixPQUF4QkEsRUFBaUMsWUFBTTtBQUNyQ0csS0FBRyxDQUFDRSxTQUFKRixDQUFjRyxNQUFkSCxDQUFxQixZQUFyQkE7QUFDQUgsUUFBTSxDQUFDSyxTQUFQTCxDQUFpQk0sTUFBakJOLENBQXdCLFFBQXhCQTtBQUNBQyxVQUFRLENBQUNNLElBQVROLENBQWNJLFNBQWRKLENBQXdCSyxNQUF4QkwsQ0FBK0IsaUJBQS9CQTtBQUhGLElBTUE7O0FBQ0FBLFFBQVEsQ0FBQ0csZ0JBQVRILENBQTBCLE9BQTFCQSxFQUFtQyxVQUFDTyxDQUFELEVBQU87QUFDeEMsTUFBSUEsQ0FBQyxDQUFDQyxNQUFGRCxDQUFTRSxFQUFURixLQUFnQixVQUFoQkEsSUFBOEJBLENBQUMsQ0FBQ0MsTUFBRkQsQ0FBU0UsRUFBVEYsS0FBZ0IsV0FBbEQsRUFBK0Q7QUFDN0RMLE9BQUcsQ0FBQ0UsU0FBSkYsQ0FBY1EsTUFBZFIsQ0FBcUIsWUFBckJBO0FBQ0FILFVBQU0sQ0FBQ0ssU0FBUEwsQ0FBaUJXLE1BQWpCWCxDQUF3QixRQUF4QkE7QUFDQUMsWUFBUSxDQUFDTSxJQUFUTixDQUFjSSxTQUFkSixDQUF3QlUsTUFBeEJWLENBQStCLGlCQUEvQkE7QUFDRDtBQUxILElBUUE7O0FBQ0EsSUFBTVcsUUFBUSxHQUFHWCxRQUFRLENBQUNZLGdCQUFUWixDQUEwQixjQUExQkEsQ0FBakI7QUFDQSxJQUFNYSxVQUFVLEdBQUdGLFFBQVEsQ0FBQ0csTUFBNUI7OzJCQUVTQztBQUNQSixVQUFRLENBQUNJLENBQUQsQ0FBUkosQ0FBWVIsZ0JBQVpRLENBQTZCLE9BQTdCQSxFQUFzQyxVQUFDSixDQUFELEVBQU87QUFDM0MsU0FBSyxJQUFJUyxDQUFDLEdBQUcsQ0FBYixFQUFnQkEsQ0FBQyxHQUFHSCxVQUFwQixFQUFnQ0csQ0FBQyxJQUFJLENBQXJDLEVBQXdDO0FBQ3RDLFVBQUlMLFFBQVEsQ0FBQ0ksQ0FBRCxDQUFSSixLQUFnQkEsUUFBUSxDQUFDSyxDQUFELENBQTVCLEVBQWlDO0FBQy9CTCxnQkFBUSxDQUFDSyxDQUFELENBQVJMLENBQVlQLFNBQVpPLENBQXNCRCxNQUF0QkMsQ0FBNkIsYUFBN0JBO0FBQ0FBLGdCQUFRLENBQUNLLENBQUQsQ0FBUkwsQ0FBWVAsU0FBWk8sQ0FBc0JELE1BQXRCQyxDQUE2QixlQUE3QkE7QUFDRDtBQUNGOztBQUNESixLQUFDLENBQUNVLGVBQUZWO0FBQ0FBLEtBQUMsQ0FBQ1csYUFBRlgsQ0FBZ0JILFNBQWhCRyxDQUEwQlksR0FBMUJaLENBQThCLGFBQTlCQTtBQUNBQSxLQUFDLENBQUNXLGFBQUZYLENBQWdCSCxTQUFoQkcsQ0FBMEJZLEdBQTFCWixDQUE4QixlQUE5QkE7QUFURjs7O0FBREYsS0FBSyxJQUFJUSxDQUFDLEdBQUcsQ0FBYixFQUFnQkEsQ0FBQyxHQUFHRixVQUFwQixFQUFnQ0UsQ0FBQyxJQUFJLENBQXJDLEVBQXdDO0FBQUFLLFFBQS9CTCxDQUErQjtFQWN4Qzs7O0FBQ0EsSUFBTU0sWUFBWSxHQUFHckIsUUFBUSxDQUFDQyxjQUFURCxDQUF3QixLQUF4QkEsQ0FBckI7QUFDQSxJQUFNc0IsUUFBUSxHQUFHdEIsUUFBUSxDQUFDdUIsYUFBVHZCLENBQXVCLFdBQXZCQSxDQUFqQjtBQUNBLElBQU13QixRQUFRLEdBQUd4QixRQUFRLENBQUN1QixhQUFUdkIsQ0FBdUIsV0FBdkJBLENBQWpCOztBQUVBLFNBQVN5QixjQUFULEdBQTBCO0FBQ3hCLE1BQUksQ0FBQ0gsUUFBUSxDQUFDSSxLQUFkLEVBQXFCO0FBQ25CSixZQUFRLENBQUNLLEtBQVRMLENBQWVNLE1BQWZOLEdBQXdCLHFCQUF4QkE7QUFDRDtBQUNGOztBQUNELFNBQVNPLGtCQUFULEdBQThCO0FBQzVCLE1BQUksQ0FBQ0wsUUFBUSxDQUFDRSxLQUFkLEVBQXFCO0FBQ25CRixZQUFRLENBQUNHLEtBQVRILENBQWVJLE1BQWZKLEdBQXdCLHFCQUF4QkE7QUFDRDtBQUNGOztBQUVESCxZQUFZLENBQUNsQixnQkFBYmtCLENBQThCLE9BQTlCQSxFQUF1QyxVQUFDZCxDQUFELEVBQU87QUFDNUNBLEdBQUMsQ0FBQ3VCLGNBQUZ2QjtBQUNBa0IsZ0JBQWM7QUFDZEksb0JBQWtCO0FBSHBCOzs7Ozs7Ozs7Ozs7QUNyREE7Ozs7Ozs7VUNBQTtVQUNBOztVQUVBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBOztVQUVBO1VBQ0E7O1VBRUE7VUFDQTtVQUNBOztVQUVBO1VBQ0E7Ozs7O1dDekJBO1dBQ0E7V0FDQTtXQUNBO1dBQ0EsK0JBQStCLHdDQUF3QztXQUN2RTtXQUNBO1dBQ0E7V0FDQTtXQUNBLGlCQUFpQixxQkFBcUI7V0FDdEM7V0FDQTtXQUNBLGtCQUFrQixxQkFBcUI7V0FDdkM7V0FDQTtXQUNBLEtBQUs7V0FDTDtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7Ozs7O1dDM0JBOzs7OztXQ0FBO1dBQ0E7V0FDQTtXQUNBLHVEQUF1RCxpQkFBaUI7V0FDeEU7V0FDQSxnREFBZ0QsYUFBYTtXQUM3RDs7Ozs7V0NOQTs7V0FFQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTs7V0FFQTs7V0FFQTs7V0FFQTs7V0FFQTs7V0FFQTs7V0FFQTs7V0FFQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQSxNQUFNLHFCQUFxQjtXQUMzQjtXQUNBO1dBQ0E7V0FDQTtXQUNBO1dBQ0E7V0FDQTtXQUNBOztXQUVBO1dBQ0E7V0FDQTs7Ozs7VUVqREE7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL3NjcmlwdC5qcyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL3Nhc3MvYXBwLnNjc3M/NjFjNCIsIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9jaHVuayBsb2FkZWQiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9oYXNPd25Qcm9wZXJ0eSBzaG9ydGhhbmQiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9tYWtlIG5hbWVzcGFjZSBvYmplY3QiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svcnVudGltZS9qc29ucCBjaHVuayBsb2FkaW5nIiwid2VicGFjazovLy93ZWJwYWNrL2JlZm9yZS1zdGFydHVwIiwid2VicGFjazovLy93ZWJwYWNrL3N0YXJ0dXAiLCJ3ZWJwYWNrOi8vL3dlYnBhY2svYWZ0ZXItc3RhcnR1cCJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyBIYW1idXJnZXIgbWVudVxuY29uc3QgYnVyZ2VyID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2hhbWJ1cmdlcicpO1xuY29uc3QgbmF2ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ25hdi1saXN0Jyk7XG5cbmJ1cmdlci5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsICgpID0+IHtcbiAgbmF2LmNsYXNzTGlzdC50b2dnbGUoJ25hdi1hY3RpdmUnKTtcbiAgYnVyZ2VyLmNsYXNzTGlzdC50b2dnbGUoJ2FjdGl2ZScpO1xuICBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC50b2dnbGUoJ292ZXJmbG93LWhpZGRlbicpO1xufSk7XG5cbi8vIGNsb3NlIHRoZSBuYXZNZW51IGJ5IGNsaWNraW5nIG91dHNpZGVcbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgKGUpID0+IHtcbiAgaWYgKGUudGFyZ2V0LmlkICE9PSAnbmF2LWxpc3QnICYmIGUudGFyZ2V0LmlkICE9PSAnaGFtYnVyZ2VyJykge1xuICAgIG5hdi5jbGFzc0xpc3QucmVtb3ZlKCduYXYtYWN0aXZlJyk7XG4gICAgYnVyZ2VyLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpO1xuICAgIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSgnb3ZlcmZsb3ctaGlkZGVuJyk7XG4gIH1cbn0pO1xuXG4vLyBBY3RpdmUgY2xhc3NcbmNvbnN0IG1lbnVJdGVtID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmxhbmd1YWdlcyBhJyk7XG5jb25zdCBtZW51TGVuZ3RoID0gbWVudUl0ZW0ubGVuZ3RoO1xuXG5mb3IgKGxldCBpID0gMDsgaSA8IG1lbnVMZW5ndGg7IGkgKz0gMSkge1xuICBtZW51SXRlbVtpXS5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gICAgZm9yIChsZXQgaiA9IDA7IGogPCBtZW51TGVuZ3RoOyBqICs9IDEpIHtcbiAgICAgIGlmIChtZW51SXRlbVtpXSAhPT0gbWVudUl0ZW1bal0pIHtcbiAgICAgICAgbWVudUl0ZW1bal0uY2xhc3NMaXN0LnJlbW92ZSgnbmF2X19hY3RpdmUnKTtcbiAgICAgICAgbWVudUl0ZW1bal0uY2xhc3NMaXN0LnJlbW92ZSgnbGlua3NfX2FjdGl2ZScpO1xuICAgICAgfVxuICAgIH1cbiAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgIGUuY3VycmVudFRhcmdldC5jbGFzc0xpc3QuYWRkKCduYXZfX2FjdGl2ZScpO1xuICAgIGUuY3VycmVudFRhcmdldC5jbGFzc0xpc3QuYWRkKCdsaW5rc19fYWN0aXZlJyk7XG4gIH0pO1xufVxuXG4vLyBGb3JtIHZhbGlkYXRpb25cbmNvbnN0IHN1Ym1pdEJ1dHRvbiA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdidG4nKTtcbmNvbnN0IHVzZXJuYW1lID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnVzZXJuYW1lJyk7XG5jb25zdCBwYXNzd29yZCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5wYXNzd29yZCcpO1xuXG5mdW5jdGlvbiBuYW1lVmFsaWRhdGlvbigpIHtcbiAgaWYgKCF1c2VybmFtZS52YWx1ZSkge1xuICAgIHVzZXJuYW1lLnN0eWxlLmJvcmRlciA9ICcxLjVweCBzb2xpZCBjcmltc29uJztcbiAgfVxufVxuZnVuY3Rpb24gcGFzc3dvcmRWYWxpZGF0aW9uKCkge1xuICBpZiAoIXBhc3N3b3JkLnZhbHVlKSB7XG4gICAgcGFzc3dvcmQuc3R5bGUuYm9yZGVyID0gJzEuNXB4IHNvbGlkIGNyaW1zb24nO1xuICB9XG59XG5cbnN1Ym1pdEJ1dHRvbi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIChlKSA9PiB7XG4gIGUucHJldmVudERlZmF1bHQoKTtcbiAgbmFtZVZhbGlkYXRpb24oKTtcbiAgcGFzc3dvcmRWYWxpZGF0aW9uKCk7XG59KTtcbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyIsIi8vIFRoZSBtb2R1bGUgY2FjaGVcbnZhciBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX18gPSB7fTtcblxuLy8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbmZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG5cdHZhciBjYWNoZWRNb2R1bGUgPSBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX19bbW9kdWxlSWRdO1xuXHRpZiAoY2FjaGVkTW9kdWxlICE9PSB1bmRlZmluZWQpIHtcblx0XHRyZXR1cm4gY2FjaGVkTW9kdWxlLmV4cG9ydHM7XG5cdH1cblx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcblx0dmFyIG1vZHVsZSA9IF9fd2VicGFja19tb2R1bGVfY2FjaGVfX1ttb2R1bGVJZF0gPSB7XG5cdFx0Ly8gbm8gbW9kdWxlLmlkIG5lZWRlZFxuXHRcdC8vIG5vIG1vZHVsZS5sb2FkZWQgbmVlZGVkXG5cdFx0ZXhwb3J0czoge31cblx0fTtcblxuXHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cblx0X193ZWJwYWNrX21vZHVsZXNfX1ttb2R1bGVJZF0obW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cblx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcblx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xufVxuXG4vLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuX193ZWJwYWNrX3JlcXVpcmVfXy5tID0gX193ZWJwYWNrX21vZHVsZXNfXztcblxuIiwidmFyIGRlZmVycmVkID0gW107XG5fX3dlYnBhY2tfcmVxdWlyZV9fLk8gPSAocmVzdWx0LCBjaHVua0lkcywgZm4sIHByaW9yaXR5KSA9PiB7XG5cdGlmKGNodW5rSWRzKSB7XG5cdFx0cHJpb3JpdHkgPSBwcmlvcml0eSB8fCAwO1xuXHRcdGZvcih2YXIgaSA9IGRlZmVycmVkLmxlbmd0aDsgaSA+IDAgJiYgZGVmZXJyZWRbaSAtIDFdWzJdID4gcHJpb3JpdHk7IGktLSkgZGVmZXJyZWRbaV0gPSBkZWZlcnJlZFtpIC0gMV07XG5cdFx0ZGVmZXJyZWRbaV0gPSBbY2h1bmtJZHMsIGZuLCBwcmlvcml0eV07XG5cdFx0cmV0dXJuO1xuXHR9XG5cdHZhciBub3RGdWxmaWxsZWQgPSBJbmZpbml0eTtcblx0Zm9yICh2YXIgaSA9IDA7IGkgPCBkZWZlcnJlZC5sZW5ndGg7IGkrKykge1xuXHRcdHZhciBbY2h1bmtJZHMsIGZuLCBwcmlvcml0eV0gPSBkZWZlcnJlZFtpXTtcblx0XHR2YXIgZnVsZmlsbGVkID0gdHJ1ZTtcblx0XHRmb3IgKHZhciBqID0gMDsgaiA8IGNodW5rSWRzLmxlbmd0aDsgaisrKSB7XG5cdFx0XHRpZiAoKHByaW9yaXR5ICYgMSA9PT0gMCB8fCBub3RGdWxmaWxsZWQgPj0gcHJpb3JpdHkpICYmIE9iamVjdC5rZXlzKF9fd2VicGFja19yZXF1aXJlX18uTykuZXZlcnkoKGtleSkgPT4gKF9fd2VicGFja19yZXF1aXJlX18uT1trZXldKGNodW5rSWRzW2pdKSkpKSB7XG5cdFx0XHRcdGNodW5rSWRzLnNwbGljZShqLS0sIDEpO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0ZnVsZmlsbGVkID0gZmFsc2U7XG5cdFx0XHRcdGlmKHByaW9yaXR5IDwgbm90RnVsZmlsbGVkKSBub3RGdWxmaWxsZWQgPSBwcmlvcml0eTtcblx0XHRcdH1cblx0XHR9XG5cdFx0aWYoZnVsZmlsbGVkKSB7XG5cdFx0XHRkZWZlcnJlZC5zcGxpY2UoaS0tLCAxKVxuXHRcdFx0dmFyIHIgPSBmbigpO1xuXHRcdFx0aWYgKHIgIT09IHVuZGVmaW5lZCkgcmVzdWx0ID0gcjtcblx0XHR9XG5cdH1cblx0cmV0dXJuIHJlc3VsdDtcbn07IiwiX193ZWJwYWNrX3JlcXVpcmVfXy5vID0gKG9iaiwgcHJvcCkgPT4gKE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmosIHByb3ApKSIsIi8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbl9fd2VicGFja19yZXF1aXJlX18uciA9IChleHBvcnRzKSA9PiB7XG5cdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuXHR9XG5cdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG59OyIsIi8vIG5vIGJhc2VVUklcblxuLy8gb2JqZWN0IHRvIHN0b3JlIGxvYWRlZCBhbmQgbG9hZGluZyBjaHVua3Ncbi8vIHVuZGVmaW5lZCA9IGNodW5rIG5vdCBsb2FkZWQsIG51bGwgPSBjaHVuayBwcmVsb2FkZWQvcHJlZmV0Y2hlZFxuLy8gW3Jlc29sdmUsIHJlamVjdCwgUHJvbWlzZV0gPSBjaHVuayBsb2FkaW5nLCAwID0gY2h1bmsgbG9hZGVkXG52YXIgaW5zdGFsbGVkQ2h1bmtzID0ge1xuXHRcIi9qcy9zY3JpcHRcIjogMCxcblx0XCJjc3MvYXBwXCI6IDBcbn07XG5cbi8vIG5vIGNodW5rIG9uIGRlbWFuZCBsb2FkaW5nXG5cbi8vIG5vIHByZWZldGNoaW5nXG5cbi8vIG5vIHByZWxvYWRlZFxuXG4vLyBubyBITVJcblxuLy8gbm8gSE1SIG1hbmlmZXN0XG5cbl9fd2VicGFja19yZXF1aXJlX18uTy5qID0gKGNodW5rSWQpID0+IChpbnN0YWxsZWRDaHVua3NbY2h1bmtJZF0gPT09IDApO1xuXG4vLyBpbnN0YWxsIGEgSlNPTlAgY2FsbGJhY2sgZm9yIGNodW5rIGxvYWRpbmdcbnZhciB3ZWJwYWNrSnNvbnBDYWxsYmFjayA9IChwYXJlbnRDaHVua0xvYWRpbmdGdW5jdGlvbiwgZGF0YSkgPT4ge1xuXHR2YXIgW2NodW5rSWRzLCBtb3JlTW9kdWxlcywgcnVudGltZV0gPSBkYXRhO1xuXHQvLyBhZGQgXCJtb3JlTW9kdWxlc1wiIHRvIHRoZSBtb2R1bGVzIG9iamVjdCxcblx0Ly8gdGhlbiBmbGFnIGFsbCBcImNodW5rSWRzXCIgYXMgbG9hZGVkIGFuZCBmaXJlIGNhbGxiYWNrXG5cdHZhciBtb2R1bGVJZCwgY2h1bmtJZCwgaSA9IDA7XG5cdGlmKGNodW5rSWRzLnNvbWUoKGlkKSA9PiAoaW5zdGFsbGVkQ2h1bmtzW2lkXSAhPT0gMCkpKSB7XG5cdFx0Zm9yKG1vZHVsZUlkIGluIG1vcmVNb2R1bGVzKSB7XG5cdFx0XHRpZihfX3dlYnBhY2tfcmVxdWlyZV9fLm8obW9yZU1vZHVsZXMsIG1vZHVsZUlkKSkge1xuXHRcdFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLm1bbW9kdWxlSWRdID0gbW9yZU1vZHVsZXNbbW9kdWxlSWRdO1xuXHRcdFx0fVxuXHRcdH1cblx0XHRpZihydW50aW1lKSB2YXIgcmVzdWx0ID0gcnVudGltZShfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblx0fVxuXHRpZihwYXJlbnRDaHVua0xvYWRpbmdGdW5jdGlvbikgcGFyZW50Q2h1bmtMb2FkaW5nRnVuY3Rpb24oZGF0YSk7XG5cdGZvcig7aSA8IGNodW5rSWRzLmxlbmd0aDsgaSsrKSB7XG5cdFx0Y2h1bmtJZCA9IGNodW5rSWRzW2ldO1xuXHRcdGlmKF9fd2VicGFja19yZXF1aXJlX18ubyhpbnN0YWxsZWRDaHVua3MsIGNodW5rSWQpICYmIGluc3RhbGxlZENodW5rc1tjaHVua0lkXSkge1xuXHRcdFx0aW5zdGFsbGVkQ2h1bmtzW2NodW5rSWRdWzBdKCk7XG5cdFx0fVxuXHRcdGluc3RhbGxlZENodW5rc1tjaHVua0lkXSA9IDA7XG5cdH1cblx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18uTyhyZXN1bHQpO1xufVxuXG52YXIgY2h1bmtMb2FkaW5nR2xvYmFsID0gc2VsZltcIndlYnBhY2tDaHVua1wiXSA9IHNlbGZbXCJ3ZWJwYWNrQ2h1bmtcIl0gfHwgW107XG5jaHVua0xvYWRpbmdHbG9iYWwuZm9yRWFjaCh3ZWJwYWNrSnNvbnBDYWxsYmFjay5iaW5kKG51bGwsIDApKTtcbmNodW5rTG9hZGluZ0dsb2JhbC5wdXNoID0gd2VicGFja0pzb25wQ2FsbGJhY2suYmluZChudWxsLCBjaHVua0xvYWRpbmdHbG9iYWwucHVzaC5iaW5kKGNodW5rTG9hZGluZ0dsb2JhbCkpOyIsIiIsIi8vIHN0YXJ0dXBcbi8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuLy8gVGhpcyBlbnRyeSBtb2R1bGUgZGVwZW5kcyBvbiBvdGhlciBsb2FkZWQgY2h1bmtzIGFuZCBleGVjdXRpb24gbmVlZCB0byBiZSBkZWxheWVkXG5fX3dlYnBhY2tfcmVxdWlyZV9fLk8odW5kZWZpbmVkLCBbXCJjc3MvYXBwXCJdLCAoKSA9PiAoX193ZWJwYWNrX3JlcXVpcmVfXyhcIi4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9zY3JpcHRzL3NjcmlwdC5qc1wiKSkpXG52YXIgX193ZWJwYWNrX2V4cG9ydHNfXyA9IF9fd2VicGFja19yZXF1aXJlX18uTyh1bmRlZmluZWQsIFtcImNzcy9hcHBcIl0sICgpID0+IChfX3dlYnBhY2tfcmVxdWlyZV9fKFwiLi9yZXNvdXJjZXMvYXNzZXRzL3Nhc3MvYXBwLnNjc3NcIikpKVxuX193ZWJwYWNrX2V4cG9ydHNfXyA9IF9fd2VicGFja19yZXF1aXJlX18uTyhfX3dlYnBhY2tfZXhwb3J0c19fKTtcbiIsIiJdLCJuYW1lcyI6WyJidXJnZXIiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwibmF2IiwiYWRkRXZlbnRMaXN0ZW5lciIsImNsYXNzTGlzdCIsInRvZ2dsZSIsImJvZHkiLCJlIiwidGFyZ2V0IiwiaWQiLCJyZW1vdmUiLCJtZW51SXRlbSIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJtZW51TGVuZ3RoIiwibGVuZ3RoIiwiaSIsImoiLCJzdG9wUHJvcGFnYXRpb24iLCJjdXJyZW50VGFyZ2V0IiwiYWRkIiwiX2xvb3AiLCJzdWJtaXRCdXR0b24iLCJ1c2VybmFtZSIsInF1ZXJ5U2VsZWN0b3IiLCJwYXNzd29yZCIsIm5hbWVWYWxpZGF0aW9uIiwidmFsdWUiLCJzdHlsZSIsImJvcmRlciIsInBhc3N3b3JkVmFsaWRhdGlvbiIsInByZXZlbnREZWZhdWx0Il0sInNvdXJjZVJvb3QiOiIifQ==
