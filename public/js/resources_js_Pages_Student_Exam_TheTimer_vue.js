"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Student_Exam_TheTimer_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: ['duration'],
  // in minute
  data: function data() {
    return {
      timePassed: 0,
      timerInterval: null
    };
  },
  computed: {
    formattedTimeLeft: function formattedTimeLeft() {
      var timeLeft = this.timeLeft;
      var hours = Math.floor(timeLeft / 3600);
      var minutes = Math.floor(timeLeft / 60) >= 60 ? Math.floor(timeLeft / 60) - 60 : Math.floor(timeLeft / 60);
      var seconds = timeLeft % 60;

      if (hours < 10) {
        hours = "0".concat(hours);
      }

      if (minutes < 10) {
        minutes = "0".concat(minutes);
      }

      if (seconds < 10) {
        seconds = "0".concat(seconds);
      }

      return "".concat(hours, ":").concat(minutes, ":").concat(seconds);
    },
    timeLeft: function timeLeft() {
      return this.duration * 60 - this.timePassed; // duration converted to second
    }
  },
  methods: {
    onTimesUp: function onTimesUp() {
      this.$emit('times-up');
      clearInterval(this.timerInterval);
    },
    startTimer: function startTimer() {
      var _this = this;

      this.timerInterval = setInterval(function () {
        return _this.timePassed += 1;
      }, 1000);
    }
  },
  watch: {
    timeLeft: function timeLeft(newValue) {
      if (newValue === 0) {
        this.onTimesUp();
      }
    }
  },
  mounted: function mounted() {
    this.startTimer();
  },
  destroyed: function destroyed() {
    clearInterval(this.timerInterval);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=template&id=d4379ad2":
/*!**************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=template&id=d4379ad2 ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "inline-flex items-center"
};
var _hoisted_2 = {
  "class": "font-semibold tracking-widest"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_2, "Time Left: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.formattedTimeLeft), 1
  /* TEXT */
  )]);
}

/***/ }),

/***/ "./resources/js/Pages/Student/Exam/TheTimer.vue":
/*!******************************************************!*\
  !*** ./resources/js/Pages/Student/Exam/TheTimer.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TheTimer_vue_vue_type_template_id_d4379ad2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheTimer.vue?vue&type=template&id=d4379ad2 */ "./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=template&id=d4379ad2");
/* harmony import */ var _TheTimer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheTimer.vue?vue&type=script&lang=js */ "./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=script&lang=js");



_TheTimer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.default.render = _TheTimer_vue_vue_type_template_id_d4379ad2__WEBPACK_IMPORTED_MODULE_0__.render
/* hot reload */
if (false) {}

_TheTimer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.default.__file = "resources/js/Pages/Student/Exam/TheTimer.vue"

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_TheTimer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__.default);

/***/ }),

/***/ "./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=script&lang=js":
/*!******************************************************************************!*\
  !*** ./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=script&lang=js ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheTimer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__.default)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheTimer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TheTimer.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=template&id=d4379ad2":
/*!************************************************************************************!*\
  !*** ./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=template&id=d4379ad2 ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheTimer_vue_vue_type_template_id_d4379ad2__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheTimer_vue_vue_type_template_id_d4379ad2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TheTimer.vue?vue&type=template&id=d4379ad2 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Student/Exam/TheTimer.vue?vue&type=template&id=d4379ad2");


/***/ })

}]);