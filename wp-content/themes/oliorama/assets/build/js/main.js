/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./sass/main.scss":
/*!************************!*\
  !*** ./sass/main.scss ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/mini-css-extract-plugin/dist/loader.js):\nModuleBuildError: Module build failed (from ./node_modules/postcss-loader/dist/cjs.js):\n/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/tailwind.config.js:70\n        'home-olive-oil': 'url(\"http://oliorama.com/wp-content/uploads/2022/01/Homepageoliveoil.png\")',\n        ^^^^^^^^^^^^^^^^\n\nSyntaxError: Unexpected string\n    at new Script (vm.js:102:7)\n    at NativeCompileCache._moduleCompile (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/v8-compile-cache/v8-compile-cache.js:240:18)\n    at Module._compile (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/v8-compile-cache/v8-compile-cache.js:184:36)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:1114:10)\n    at Module.load (internal/modules/cjs/loader.js:950:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:790:12)\n    at Module.require (internal/modules/cjs/loader.js:974:19)\n    at require (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/v8-compile-cache/v8-compile-cache.js:159:20)\n    at /home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/tailwindcss/lib/index.js:83:107\n    at tailwindcss (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/tailwindcss/lib/index.js:96:36)\n    at Processor.normalize (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/postcss/lib/processor.js:43:13)\n    at new Processor (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/postcss/lib/processor.js:10:25)\n    at postcss (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/postcss/lib/postcss.js:26:10)\n    at Object.loader (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/postcss-loader/dist/index.js:95:20)\n    at /home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/webpack/lib/NormalModule.js:316:20\n    at /home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/loader-runner/lib/LoaderRunner.js:367:11\n    at /home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/loader-runner/lib/LoaderRunner.js:233:18\n    at context.callback (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/loader-runner/lib/LoaderRunner.js:111:13)\n    at Object.loader (/home/klamaj/Sites/oliorama/wp-content/themes/oliorama/assets/node_modules/postcss-loader/dist/index.js:104:7)");

/***/ }),

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _sass_main_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../sass/main.scss */ "./sass/main.scss");
/* harmony import */ var _sass_main_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_sass_main_scss__WEBPACK_IMPORTED_MODULE_0__);
 // Open navigation

function openNav() {
  document.getElementById('nav').classList.remove('hidden');
} // Close navigation


function closeNav() {
  document.getElementById('nav').classList.add('hidden');
}

/***/ })

/******/ });
//# sourceMappingURL=main.js.map