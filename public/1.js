(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! element-ui */ "./node_modules/element-ui/lib/element-ui.common.js");
/* harmony import */ var element_ui__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(element_ui__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "CreateComponent",
  data: function data() {
    return {
      loading: false,
      schedule: [],
      selected: {},
      isactive: false,
      auto_up_on_schedule_end: false,
      form: new Form({
        schedule: '',
        schedule_start: '',
        schedule_end: '',
        message: '',
        notification_display_datetime: '',
        notification_message: '',
        auto_up_on_schedule_end: '',
        action_id: '',
        is_active: '',
        updated_by: '',
        added_by: ''
      }),
      ruleForm: {
        schedule: '',
        schedule_start: '',
        schedule_end: '',
        message: '',
        notification_display_datetime: '',
        notification_message: '',
        auto_up_on_schedule_end: '',
        action_id: '',
        is_active: '',
        updated_by: '',
        added_by: ''
      },
      rules: {
        schedule: [{
          type: 'array',
          required: true,
          message: 'Schedule is required',
          trigger: 'blur'
        }],
        message: [{
          required: true,
          message: 'Message is required'
        }, {
          min: 10,
          message: 'Length should be more than 10 characters',
          trigger: 'blur'
        }],
        notification_display_datetime: [{
          type: 'date',
          required: true,
          message: 'Notification Display Date is required',
          trigger: 'blur'
        }],
        notification_message: [{
          required: true,
          message: 'Notification Message',
          trigger: 'blur'
        }, {
          min: 10,
          message: 'Length should be more than 10 characters',
          trigger: 'blur'
        }]
      }
    };
  },
  mounted: function mounted() {// console.log(this.token)
  },
  created: function created() {
    var _this = this;

    Fire.$on('AfterCreatedUserLoadIt', function () {
      //custom events fire on
      _this.handleClose();
    });
  },
  methods: {
    setSchedule: function setSchedule() {
      var sched = [];
      sched.push(this.schedule[0]);
      sched.push(this.schedule[1]);
      this.schedule = sched;
    },
    handleSave: function handleSave(selected) {
      var _this2 = this;

      this.$refs.ruleForm.validate(function (valid) {
        if (valid) {
          _this2.$Progress.start();

          _this2.form.fill(selected);

          if (_this2.isactive === false) {
            // convert switch value from true/false to int
            _this2.form.is_active = 0;
          } else {
            _this2.form.is_active = 1;
          }

          if (_this2.auto_up_on_schedule_end === false) {
            // convert switch value from true/false to int
            _this2.form.auto_up_on_schedule_end = 0;
          } else {
            _this2.form.auto_up_on_schedule_end = 1;
          }

          var schedule = [];

          if (_this2.schedule === '' || _this2.schedule === null) {
            // schedule validator
            _this2.$message.error('Schedule is Required');

            return;
          } else {
            schedule.push(moment(selected.schedule[0]).format('MMMM Do YYYY, h:mm:ss a'));
            schedule.push(moment(selected.schedule[1]).format('MMMM Do YYYY, h:mm:ss a'));
            _this2.form.schedule = schedule;
            _this2.form.schedule_start = moment(selected.schedule[0]).format('MMMM Do YYYY, h:mm:ss a');
            _this2.form.schedule_end = moment(selected.schedule[1]).format('MMMM Do YYYY, h:mm:ss a');
          } // form.ticket_no = 123
          // this.form.schedule = this.schedule


          console.log(_this2.form);

          _this2.form.post('/maintenance/create').then(function () {
            element_ui__WEBPACK_IMPORTED_MODULE_0__["Notification"].success({
              title: 'Success',
              message: 'New Maintenance Schedule Created!',
              duration: 4 * 1000
            }); // Fire.$emit('AfterCreatedUserLoadIt'); //custom events

            _this2.$Progress.finish();

            _this2.handleClose(selected);
          })["catch"](function (error) {
            element_ui__WEBPACK_IMPORTED_MODULE_0__["Notification"].error({
              title: 'Error',
              message: 'Error!',
              duration: 4 * 1000
            });
          });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    handleClose: function handleClose() {
      this.$refs.ruleForm.resetFields();
      this.form = new Form({
        schedule: '',
        schedule_start: '',
        schedule_end: '',
        message: '',
        notification_display_datetime: '',
        notification_message: '',
        auto_up_on_schedule_end: '',
        action_id: '',
        is_active: '',
        updated_by: '',
        added_by: ''
      });
      this.schedule = [];
      this.selected = {};
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=template&id=5a8e770d&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=template&id=5a8e770d&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "el-col",
    { attrs: { span: 24 } },
    [
      _c("el-col", { staticClass: "page-content-title", attrs: { span: 24 } }, [
        _vm._v("Maintenance Management - Create New Maintenance Schedule")
      ]),
      _vm._v(" "),
      _c(
        "el-col",
        { staticClass: "content-margin", attrs: { span: 24 } },
        [
          _c(
            "el-col",
            { attrs: { span: 16 } },
            [
              _c(
                "el-card",
                { staticClass: "box-card layout-card" },
                [
                  _c(
                    "div",
                    {
                      staticClass: "clearfix",
                      staticStyle: { "padding-top": "5px !important" },
                      attrs: { slot: "header" },
                      slot: "header"
                    },
                    [_c("span", [_vm._v("Maintenance Schedule Details")])]
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticClass: "card-content" },
                    [
                      _c(
                        "el-form",
                        {
                          ref: "ruleForm",
                          staticClass: "demo-ruleForm",
                          attrs: {
                            model: _vm.selected,
                            rules: _vm.rules,
                            "label-width": "220px",
                            "label-position": "right"
                          }
                        },
                        [
                          _c(
                            "div",
                            [
                              _c(
                                "el-form-item",
                                {
                                  attrs: {
                                    label: "Schedule",
                                    required: "",
                                    prop: "schedule"
                                  }
                                },
                                [
                                  _c("el-date-picker", {
                                    attrs: {
                                      format: "yyyy-MM-dd h:mm:ss A",
                                      type: "datetimerange",
                                      "range-separator": "-",
                                      clearable: "",
                                      "start-placeholder": "Start date",
                                      "end-placeholder": "End date"
                                    },
                                    on: {
                                      change: function($event) {
                                        return _vm.setSchedule()
                                      }
                                    },
                                    model: {
                                      value: _vm.selected.schedule,
                                      callback: function($$v) {
                                        _vm.$set(_vm.selected, "schedule", $$v)
                                      },
                                      expression: "selected.schedule"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "el-form-item",
                                {
                                  attrs: {
                                    prop: "message",
                                    required: "",
                                    label: "Message:"
                                  }
                                },
                                [
                                  _c("el-input", {
                                    staticStyle: { width: "80%" },
                                    attrs: { type: "textarea", clearable: "" },
                                    model: {
                                      value: _vm.selected.message,
                                      callback: function($$v) {
                                        _vm.$set(_vm.selected, "message", $$v)
                                      },
                                      expression: "selected.message"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c("el-divider"),
                              _vm._v(" "),
                              _c(
                                "el-form-item",
                                {
                                  attrs: {
                                    prop: "notification_display_datetime",
                                    label: "Notification display Datetime:",
                                    required: ""
                                  }
                                },
                                [
                                  _c("el-date-picker", {
                                    attrs: {
                                      format: "yyyy-MM-dd h:mm:ss A",
                                      type: "datetime",
                                      clearable: "",
                                      placeholder: "Select date and time"
                                    },
                                    model: {
                                      value:
                                        _vm.selected
                                          .notification_display_datetime,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.selected,
                                          "notification_display_datetime",
                                          $$v
                                        )
                                      },
                                      expression:
                                        "selected.notification_display_datetime"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "el-form-item",
                                {
                                  attrs: {
                                    prop: "notification_message",
                                    label: "Notification Message",
                                    required: ""
                                  }
                                },
                                [
                                  _c("el-input", {
                                    staticStyle: { width: "80%" },
                                    attrs: { type: "textarea", clearable: "" },
                                    model: {
                                      value: _vm.selected.notification_message,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.selected,
                                          "notification_message",
                                          $$v
                                        )
                                      },
                                      expression:
                                        "selected.notification_message"
                                    }
                                  })
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "el-col",
                                { attrs: { span: 24 } },
                                [
                                  _c(
                                    "el-col",
                                    { attrs: { span: 12 } },
                                    [
                                      _c(
                                        "el-form-item",
                                        { attrs: { label: "Is Active:" } },
                                        [
                                          _c("el-switch", {
                                            model: {
                                              value: _vm.selected.is_active,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  _vm.selected,
                                                  "is_active",
                                                  $$v
                                                )
                                              },
                                              expression: "selected.is_active"
                                            }
                                          })
                                        ],
                                        1
                                      )
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "el-col",
                                    { attrs: { span: 12 } },
                                    [
                                      _c(
                                        "el-form-item",
                                        {
                                          attrs: {
                                            label: "Auto Up on Schedule End:",
                                            "label-width": "300"
                                          }
                                        },
                                        [
                                          _c("el-switch", {
                                            model: {
                                              value:
                                                _vm.selected
                                                  .auto_up_on_schedule_end,
                                              callback: function($$v) {
                                                _vm.$set(
                                                  _vm.selected,
                                                  "auto_up_on_schedule_end",
                                                  $$v
                                                )
                                              },
                                              expression:
                                                "selected.auto_up_on_schedule_end"
                                            }
                                          })
                                        ],
                                        1
                                      )
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ]
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "el-col",
                    { staticClass: "card-footer", attrs: { span: 24 } },
                    [
                      _c(
                        "div",
                        { staticStyle: { float: "right" } },
                        [
                          _c(
                            "el-button",
                            {
                              attrs: { size: "medium" },
                              on: {
                                click: function($event) {
                                  return _vm.handleClose()
                                }
                              }
                            },
                            [_vm._v("Clear")]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-button",
                            {
                              attrs: { type: "primary", size: "medium" },
                              on: {
                                click: function($event) {
                                  return _vm.handleSave(_vm.selected)
                                }
                              }
                            },
                            [_vm._v("Done")]
                          )
                        ],
                        1
                      )
                    ]
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _CreateComponent_vue_vue_type_template_id_5a8e770d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=template&id=5a8e770d&scoped=true& */ "./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=template&id=5a8e770d&scoped=true&");
/* harmony import */ var _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CreateComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _CreateComponent_vue_vue_type_template_id_5a8e770d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _CreateComponent_vue_vue_type_template_id_5a8e770d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "5a8e770d",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/MaintenanceManagement/CreateComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=template&id=5a8e770d&scoped=true&":
/*!****************************************************************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=template&id=5a8e770d&scoped=true& ***!
  \****************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_5a8e770d_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./CreateComponent.vue?vue&type=template&id=5a8e770d&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/CreateComponent.vue?vue&type=template&id=5a8e770d&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_5a8e770d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_CreateComponent_vue_vue_type_template_id_5a8e770d_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);