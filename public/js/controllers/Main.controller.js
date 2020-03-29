(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/controllers/Main.controller"],{

/***/ "./resources/js/artist4artist.config.js":
/*!**********************************************!*\
  !*** ./resources/js/artist4artist.config.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./resources/js/classes/Translation.js":
/*!*********************************************!*\
  !*** ./resources/js/classes/Translation.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/*
 * This file belong to app.utp.pt
 *
 * Copyright (c) 2019 Creative Code Solutions <creativecodesolutions.pt>. File Translation.js is protected by
 * All Rights Reserved
 */
var _ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");

var trans = function trans(string, args) {
  var value = _.get(window.translations, string);

  _.eachRight(args, function (paramVal, paramKey) {
    value = _.replace(value, ":".concat(paramKey), paramVal);
  });

  return value;
};

module.exports = trans;

/***/ }),

/***/ "./resources/js/controllers/Main.controller.js":
/*!*****************************************************!*\
  !*** ./resources/js/controllers/Main.controller.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var config = __webpack_require__(/*! ../artist4artist.config */ "./resources/js/artist4artist.config.js");

var trans = __webpack_require__(/*! ../classes/Translation */ "./resources/js/classes/Translation.js");

var Main = new function (w) {
  this.init = function () {
    this.loadPlugins();
  };

  this.loadPlugins = function () {
    $.each($("[data-autoload='select2']"), function () {
      var $this = $(this);
      $this.select2({
        'tags': $this.attr('data-select2-tags') ? true : false
      });
    });
  };
}(window);
window.InterfaceController = Main;

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************************************!*\
  !*** multi ./resources/js/controllers/Main.controller.js ./resources/sass/app.scss ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/jfontes/Sites/support-artists-project/resources/js/controllers/Main.controller.js */"./resources/js/controllers/Main.controller.js");
module.exports = __webpack_require__(/*! /Users/jfontes/Sites/support-artists-project/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

},[[0,"/js/manifest","/js/vendor"]]]);