(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************/
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
  name: "EditComponent",
  props: {
    selected: {
      required: true,
      type: Object
    }
  },
  data: function data() {
    return {
      dialogEdit: false,
      title: '',
      schedule: [],
      isactive: false,
      auto_up_on_schedule_end: false,
      newData: {},
      form: new Form({
        id: '',
        schedule: '',
        schedule_start: '',
        schedule_end: '',
        message: '',
        notification_display_datetime: '',
        notification_message: '',
        // updated_at: "2020-08-27T07:07:03.000000Z",
        auto_up_on_schedule_end: '',
        action_id: '',
        is_active: '',
        updated_by: '',
        added_by: ''
      }),
      ruleForm: {
        id: '',
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
        // schedule: [
        //   { type: 'array', required: true, message: 'Schedule is required', trigger: 'blur' }
        // ],
        message: [{
          required: true,
          message: 'Message is required'
        }, {
          min: 10,
          message: 'Length should be more than 10 characters',
          trigger: 'blur'
        }],
        notification_display_datetime: [{
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
  filters: {
    moment: function (_moment) {
      function moment(_x) {
        return _moment.apply(this, arguments);
      }

      moment.toString = function () {
        return _moment.toString();
      };

      return moment;
    }(function (date) {
      return moment(date).format('lll');
    })
  },
  created: function created() {
    var schedule = [];
    schedule.push(this.selected.schedule_start);
    schedule.push(this.selected.schedule_end);
    this.schedule = schedule;

    if (this.selected.is_active === 0 || this.selected.is_active === false) {
      this.isactive = false;
    } else {
      this.isactive = true;
    }

    if (this.selected.auto_up_on_schedule_end === 0 || this.selected.auto_up_on_schedule_end === false) {
      this.auto_up_on_schedule_end = false;
    } else {
      this.auto_up_on_schedule_end = true;
    }
  },
  methods: {
    setSchedule: function setSchedule() {
      var sched = [];
      sched.push(this.schedule[0]);
      sched.push(this.schedule[1]);
      this.schedule = sched;
    },
    handleSave: function handleSave(selected) {
      var _this = this;

      this.$refs.ruleForm.validate(function (valid) {
        if (valid) {
          _this.form.fill(selected);

          if (_this.isactive === false) {
            // convert switch value from true/false to int
            _this.form.is_active = 0;
          } else {
            _this.form.is_active = 1;
          }

          if (_this.auto_up_on_schedule_end === false) {
            // convert switch value from true/false to int
            _this.form.auto_up_on_schedule_end = 0;
          } else {
            _this.form.auto_up_on_schedule_end = 1;
          }

          var schedule = [];

          if (_this.schedule === '' || _this.schedule === null) {
            // schedule validator
            _this.$message.error('Schedule is Required');

            return;
          } else {
            schedule.push(moment(_this.schedule[0]).format('MMMM Do YYYY, h:mm:ss a'));
            schedule.push(moment(_this.schedule[1]).format('MMMM Do YYYY, h:mm:ss a'));
            _this.form.schedule = schedule;
            _this.form.schedule_start = moment(_this.schedule[0]).format('MMMM Do YYYY, h:mm:ss a');
            _this.form.schedule_end = moment(_this.schedule[1]).format('MMMM Do YYYY, h:mm:ss a');
          } // this.form.schedule = selected.schedule_start


          if (_this.form.message === '') {
            // message validator
            _this.$message.error('Message is Required');

            return;
          }

          if (_this.form.notification_display_datetime === '' || _this.form.notification_display_datetime === null) {
            // notification_display_datetime validator
            _this.$message.error('Notification display Date is Required');

            return;
          }

          if (_this.form.notification_message === '') {
            // notification_display message validator
            _this.$message.error('Notification Message is Required');

            return;
          }

          var id = Number(_this.form.id);

          _this.form.post('/maintenance/edit/' + id).then(function () {
            element_ui__WEBPACK_IMPORTED_MODULE_0__["Notification"].success({
              title: 'Success',
              message: 'Maintenance Schedule Updated!',
              duration: 4 * 1000
            });

            _this.handleClose();
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
    show: function show() {
      this.dialogEdit = true; // this.title = 'Edit Ticket #: ' + this.selected.ticket_no

      this.title = 'Edit Details';
    },
    handleClose: function handleClose() {
      this.$refs.ruleForm.resetFields();
      this.$emit('changed');
      this.dialogEdit = false;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Form_EditComponent_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Form/EditComponent.vue */ "./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue");
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
  name: "ViewComponent",
  components: {
    EditComponent: _Form_EditComponent_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      loading: false,
      search: '',
      currentComponent: null,
      passData: {},
      total: 0,
      data: [],
      enties: 10,
      options: [{
        value: 10,
        label: '10'
      }, {
        value: 25,
        label: '25'
      }, {
        value: 50,
        label: '50'
      }, {
        value: 100,
        label: '100'
      }],
      tabledata: [],
      forms: new Form({
        id: 0,
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
      listQuery: {
        page: 1,
        limit: 20
      },
      chunkedData: '',
      per_page: 10,
      page_number: 0
    };
  },
  filters: {
    moment: function (_moment) {
      function moment(_x) {
        return _moment.apply(this, arguments);
      }

      moment.toString = function () {
        return _moment.toString();
      };

      return moment;
    }(function (date) {
      return moment(date).format('lll');
    })
  },
  watch: {
    search: function search() {
      this.loading = true;

      if (this.search.length >= 1 || this.search.length === 0) {
        this.filterRecord();
      }
    }
  },
  created: function created() {
    // console.log('Component mounted.')
    this.loading = true;
    this.getRecords();
  },
  methods: {
    handleDelete: function handleDelete(row) {
      var _this = this;

      this.forms.fill(row);
      this.$confirm('Are you sure you want to delete this Maintenance Schedule?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(function () {
        _this.forms.get('/maintenance/delete/' + row.id).then(function () {
          _this.$message({
            type: 'success',
            message: 'Maintenance Schedule Deleted!'
          });

          _this.getRecords();
        })["catch"](function () {});
      })["catch"](function () {// this.$message({
        //   type: 'info',
        //   message: 'Delete canceled'
        // });
      });
    },
    filterTag: function filterTag(value, row) {
      console.log(value);
      return row.is_active === value;
    },
    filterTagAuto: function filterTagAuto(value, row) {
      console.log(value);
      return row.auto_up_on_schedule_end === value;
    },
    filterRecord: function filterRecord() {
      var _this2 = this;

      var newdata = [];

      if (this.search.length === 0) {
        this.tabledata = this.data;
      }

      this.tabledata.forEach(function (value, index) {
        if (value.ticket_no.includes(_this2.search) || value.message.includes(_this2.search)) {
          newdata.push(value);
        }
      });
      this.tabledata = newdata;
      this.loading = false;
    },
    handleEdit: function handleEdit(row) {
      var _this3 = this;

      this.passData = row;
      this.currentComponent = _Form_EditComponent_vue__WEBPACK_IMPORTED_MODULE_0__["default"];
      setTimeout(function () {
        return _this3.ex_call_modal();
      }, 1);
    },
    ex_call_modal: function ex_call_modal() {
      this.$refs.modalComponent.show();
    },
    emitChange: function emitChange() {
      this.currentComponent = null;
      this.getRecords();
    },
    getRecords: function getRecords() {
      var _this4 = this;

      var AjaxUrl = "/maintenance";
      axios.get(AjaxUrl).then(function (response) {
        _this4.data = response.data.data; // add data to the response
        // this.tabledata = this.data

        _this4.total = response.data.recordsTotal;

        _this4.chunkData(_this4.data);

        _this4.loading = false;
      });
    },
    chunkData: function chunkData(data) {
      this.loading = true;
      Object.defineProperty(Array.prototype, 'chunk', {
        writable: true,
        enumerable: true,
        configurable: true,
        value: function value(chunkSize) {
          var R = [];

          for (var i = 0; i < this.length; i += chunkSize) {
            R.push(this.slice(i, i + chunkSize));
          }

          return R;
        }
      }); // var number_of_chunk = (data.length / 10)

      this.page_number = '';
      var per_page = this.per_page;
      this.chunkedData = data.chunk(per_page);
      var page_number = this.chunkedData.length;
      this.page_number = page_number;
      console.log(this.page_number);
      this.tabledata = this.chunkedData[0];
      this.loading = false;
    },
    handlePageChange: function handlePageChange(val) {
      this.loading = true;
      console.log("current page:", val - 1);
      this.tabledata = this.chunkedData[val - 1];
      this.loading = false;
    },
    handleSizeChange: function handleSizeChange(val) {
      this.loading = true;
      this.per_page = val;
      this.loading = false;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=template&id=f64c5728&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=template&id=f64c5728&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************************************/
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
    "div",
    [
      _c(
        "el-dialog",
        {
          attrs: {
            title: _vm.title,
            visible: _vm.dialogEdit,
            width: "60%",
            top: "2vh"
          },
          on: {
            "update:visible": function($event) {
              _vm.dialogEdit = $event
            }
          }
        },
        [
          _c(
            "el-form",
            {
              ref: "ruleForm",
              staticClass: "demo-ruleForm",
              attrs: {
                model: _vm.selected,
                rules: _vm.rules,
                "label-width": "200px",
                "label-position": "right"
              }
            },
            [
              _c(
                "div",
                { staticClass: "clearfix" },
                [
                  _vm._v(
                    "\n        " + _vm._s(_vm.selected.schedule) + "\n        "
                  ),
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
                            { attrs: { label: "Ticket No." } },
                            [
                              _c("span", { staticClass: "modal-label" }, [
                                _vm._v(_vm._s(_vm.selected.ticket_no))
                              ])
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-form-item",
                            { attrs: { label: "Added By:" } },
                            [
                              _c("span", { staticClass: "modal-label" }, [
                                _vm._v(_vm._s(_vm.selected.useraddedby.name))
                              ])
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-form-item",
                            { attrs: { label: "Date Updated:" } },
                            [
                              _c("span", { staticClass: "modal-label" }, [
                                _vm._v(
                                  _vm._s(
                                    _vm._f("moment")(_vm.selected.updated_at)
                                  )
                                )
                              ])
                            ]
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
                            { attrs: { label: "Updated By:" } },
                            [
                              _c("span", { staticClass: "modal-label" }, [
                                _vm._v(_vm._s(_vm.selected.userupdatedby.name))
                              ])
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-form-item",
                            { attrs: { label: "Created At:" } },
                            [
                              _c("span", { staticClass: "modal-label" }, [
                                _vm._v(
                                  _vm._s(
                                    _vm._f("moment")(_vm.selected.created_at)
                                  )
                                )
                              ])
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
              ),
              _vm._v(" "),
              _c("el-divider"),
              _vm._v(" "),
              _c(
                "div",
                [
                  _c(
                    "el-form-item",
                    { attrs: { prop: "", required: "", label: "Schedule:" } },
                    [
                      _c("el-date-picker", {
                        attrs: {
                          format: "yyyy-MM-dd h:mm:ss A",
                          type: "datetimerange",
                          clearable: "",
                          "range-separator": "-",
                          "start-placeholder": "Start date",
                          "end-placeholder": "End date"
                        },
                        on: {
                          change: function($event) {
                            return _vm.setSchedule()
                          }
                        },
                        model: {
                          value: _vm.schedule,
                          callback: function($$v) {
                            _vm.schedule = $$v
                          },
                          expression: "schedule"
                        }
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "el-form-item",
                    {
                      attrs: { prop: "message", label: "Message", required: "" }
                    },
                    [
                      _c("el-input", {
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
                        label: "Notification Display Date:",
                        required: ""
                      }
                    },
                    [
                      _c("el-date-picker", {
                        attrs: {
                          type: "datetime",
                          format: "yyyy-MM-dd h:mm:ss A",
                          clearable: "",
                          placeholder: "Select date and time"
                        },
                        model: {
                          value: _vm.selected.notification_display_datetime,
                          callback: function($$v) {
                            _vm.$set(
                              _vm.selected,
                              "notification_display_datetime",
                              $$v
                            )
                          },
                          expression: "selected.notification_display_datetime"
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
                        label: "Notification Message:",
                        required: ""
                      }
                    },
                    [
                      _c("el-input", {
                        attrs: { type: "textarea", clearable: "" },
                        model: {
                          value: _vm.selected.notification_message,
                          callback: function($$v) {
                            _vm.$set(_vm.selected, "notification_message", $$v)
                          },
                          expression: "selected.notification_message"
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
                                  value: _vm.isactive,
                                  callback: function($$v) {
                                    _vm.isactive = $$v
                                  },
                                  expression: "isactive"
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
                                  value: _vm.auto_up_on_schedule_end,
                                  callback: function($$v) {
                                    _vm.auto_up_on_schedule_end = $$v
                                  },
                                  expression: "auto_up_on_schedule_end"
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
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass: "dialog-footer",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _c(
                "el-button",
                {
                  on: {
                    click: function($event) {
                      return _vm.handleClose()
                    }
                  }
                },
                [_vm._v("Cancel")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                {
                  attrs: { type: "primary" },
                  on: {
                    click: function($event) {
                      return _vm.handleSave(_vm.selected)
                    }
                  }
                },
                [_vm._v("Save")]
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=template&id=f26825f8&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=template&id=f26825f8&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
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
        _vm._v("Maintenance Management - Schedule List")
      ]),
      _vm._v(" "),
      _c(
        "el-col",
        { staticClass: "content-margin", attrs: { span: 24 } },
        [
          _c("el-card", { staticClass: "box-card layout-card" }, [
            _c(
              "div",
              {
                staticClass: "clearfix",
                attrs: { slot: "header" },
                slot: "header"
              },
              [
                _c(
                  "div",
                  {
                    staticClass: "search-input-suffix",
                    staticStyle: { width: "100%" }
                  },
                  [
                    _c(
                      "el-col",
                      { attrs: { span: 24 } },
                      [
                        _c("span", { staticClass: "search-input-label" }, [
                          _vm._v("Search:")
                        ]),
                        _vm._v(" "),
                        _c("el-input", {
                          staticClass: "search-input",
                          staticStyle: { "max-width": "300px" },
                          attrs: {
                            placeholder: "",
                            size: "small",
                            clearable: "",
                            "prefix-icon": "el-icon-search"
                          },
                          model: {
                            value: _vm.search,
                            callback: function($$v) {
                              _vm.search = $$v
                            },
                            expression: "search"
                          }
                        }),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticStyle: {
                              float: "right",
                              display: "inline-block"
                            }
                          },
                          [
                            _vm._v("\n              show\n              "),
                            _c(
                              "el-select",
                              {
                                staticStyle: { width: "70px" },
                                attrs: { placeholder: "Select", size: "small" },
                                on: {
                                  change: function($event) {
                                    return _vm.chunkData(_vm.data)
                                  }
                                },
                                model: {
                                  value: _vm.per_page,
                                  callback: function($$v) {
                                    _vm.per_page = $$v
                                  },
                                  expression: "per_page"
                                }
                              },
                              _vm._l(_vm.options, function(item) {
                                return _c("el-option", {
                                  key: item.value,
                                  attrs: {
                                    label: item.label,
                                    value: item.value
                                  }
                                })
                              }),
                              1
                            ),
                            _vm._v("\n              entries\n            ")
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
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "card-content" },
              [
                [
                  _c(
                    "el-table",
                    {
                      directives: [
                        {
                          name: "loading",
                          rawName: "v-loading",
                          value: _vm.loading,
                          expression: "loading"
                        }
                      ],
                      staticStyle: { width: "100%" },
                      attrs: { data: _vm.tabledata, border: "" }
                    },
                    [
                      _c("el-table-column", {
                        attrs: {
                          prop: "ticket_no",
                          label: "Ticket #",
                          width: "150"
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                _c(
                                  "el-link",
                                  {
                                    attrs: { type: "primary" },
                                    on: {
                                      click: function($event) {
                                        return _vm.handleEdit(scope.row)
                                      }
                                    }
                                  },
                                  [_vm._v(_vm._s(scope.row.ticket_no))]
                                )
                              ]
                            }
                          }
                        ])
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: { prop: "message", label: "Message" },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                _c(
                                  "el-popover",
                                  {
                                    attrs: {
                                      placement: "right",
                                      title: "Message",
                                      width: "600",
                                      trigger: "click",
                                      content: scope.row.message
                                    }
                                  },
                                  [
                                    _c(
                                      "el-link",
                                      {
                                        staticClass: "table_message_link",
                                        staticStyle: {
                                          "white-space": "nowrap",
                                          overflow: "ellipsis",
                                          "max-width": "400px",
                                          display: "block",
                                          cursor: "pointer"
                                        },
                                        attrs: { slot: "reference" },
                                        slot: "reference"
                                      },
                                      [_vm._v(_vm._s(scope.row.message))]
                                    )
                                  ],
                                  1
                                )
                              ]
                            }
                          }
                        ])
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "schedule_start",
                          sortable: "",
                          label: "Schedule Start",
                          width: "150"
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                _c("span", [
                                  _vm._v(
                                    _vm._s(
                                      _vm._f("moment")(scope.row.schedule_start)
                                    )
                                  )
                                ])
                              ]
                            }
                          }
                        ])
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "schedule_end",
                          sortable: "",
                          label: "Schedule End",
                          width: "150"
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                _c("span", [
                                  _vm._v(
                                    _vm._s(
                                      _vm._f("moment")(scope.row.schedule_end)
                                    )
                                  )
                                ])
                              ]
                            }
                          }
                        ])
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          filters: [
                            { text: "Active", value: "1" },
                            { text: "Inactive", value: 0 }
                          ],
                          "filter-method": _vm.filterTag,
                          "filter-placement": "bottom-end",
                          prop: "is_active",
                          label: "Status",
                          width: "100"
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                scope.row.is_active === "0" ||
                                scope.row.is_active === 0
                                  ? _c(
                                      "el-tag",
                                      {
                                        attrs: {
                                          type: "danger",
                                          size: "small",
                                          effect: "dark"
                                        }
                                      },
                                      [_vm._v("Inactive")]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                scope.row.is_active === "1" ||
                                scope.row.is_active === 1
                                  ? _c(
                                      "el-tag",
                                      {
                                        attrs: {
                                          type: "success",
                                          size: "small",
                                          effect: "dark"
                                        }
                                      },
                                      [_vm._v("Active")]
                                    )
                                  : _vm._e()
                              ]
                            }
                          }
                        ])
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          filters: [
                            { text: "Yes", value: "1" },
                            { text: "No", value: 0 }
                          ],
                          "filter-method": _vm.filterTagAuto,
                          prop: "auto_up_on_schedule_end",
                          "filter-placement": "bottom-end",
                          label: "Auto Up",
                          width: "80"
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                scope.row.auto_up_on_schedule_end === 0 ||
                                scope.row.auto_up_on_schedule_end === "0"
                                  ? _c(
                                      "el-tag",
                                      {
                                        attrs: {
                                          type: "danger",
                                          size: "small",
                                          effect: "dark"
                                        }
                                      },
                                      [_vm._v("No")]
                                    )
                                  : _vm._e(),
                                _vm._v(" "),
                                scope.row.auto_up_on_schedule_end === 1 ||
                                scope.row.auto_up_on_schedule_end === "1"
                                  ? _c(
                                      "el-tag",
                                      {
                                        attrs: {
                                          type: "success",
                                          size: "small",
                                          effect: "dark"
                                        }
                                      },
                                      [_vm._v("Yes")]
                                    )
                                  : _vm._e()
                              ]
                            }
                          }
                        ])
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          prop: "created_at",
                          sortable: "",
                          label: "Date Created",
                          width: "150"
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                _c("span", [
                                  _vm._v(
                                    _vm._s(
                                      _vm._f("moment")(scope.row.created_at)
                                    )
                                  )
                                ])
                              ]
                            }
                          }
                        ])
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: {
                          label: "Action",
                          fixed: "right",
                          width: "120"
                        },
                        scopedSlots: _vm._u([
                          {
                            key: "default",
                            fn: function(scope) {
                              return [
                                _c(
                                  "el-button-group",
                                  [
                                    _c(
                                      "el-button",
                                      {
                                        attrs: {
                                          type: "primary",
                                          size: "mini"
                                        },
                                        on: {
                                          click: function($event) {
                                            return _vm.handleEdit(scope.row)
                                          }
                                        }
                                      },
                                      [_c("i", { staticClass: "el-icon-edit" })]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "el-button",
                                      {
                                        attrs: { type: "danger", size: "mini" },
                                        on: {
                                          click: function($event) {
                                            return _vm.handleDelete(scope.row)
                                          }
                                        }
                                      },
                                      [
                                        _c("i", {
                                          staticClass: "el-icon-delete"
                                        })
                                      ]
                                    )
                                  ],
                                  1
                                )
                              ]
                            }
                          }
                        ])
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "div",
                    { staticStyle: { display: "block", margin: "20px auto" } },
                    [
                      _c("el-pagination", {
                        attrs: {
                          background: "",
                          total: _vm.total,
                          "page-sizes": [10, 25, 50, 100],
                          "page-size": _vm.per_page,
                          page: _vm.page_number,
                          limit: _vm.listQuery.limit,
                          layout: "total, prev, pager, next, jumper"
                        },
                        on: {
                          "size-change": _vm.handleSizeChange,
                          "update:page": function($event) {
                            _vm.page_number = $event
                          },
                          "update:limit": function($event) {
                            return _vm.$set(_vm.listQuery, "limit", $event)
                          },
                          "current-change": _vm.handlePageChange
                        }
                      })
                    ],
                    1
                  )
                ]
              ],
              2
            )
          ])
        ],
        1
      ),
      _vm._v(" "),
      _c(_vm.currentComponent, {
        ref: "modalComponent",
        tag: "component",
        attrs: { selected: _vm.passData },
        on: {
          changed: function($event) {
            return _vm.emitChange()
          }
        }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue":
/*!************************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _EditComponent_vue_vue_type_template_id_f64c5728_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=template&id=f64c5728&scoped=true& */ "./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=template&id=f64c5728&scoped=true&");
/* harmony import */ var _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EditComponent_vue_vue_type_template_id_f64c5728_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _EditComponent_vue_vue_type_template_id_f64c5728_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "f64c5728",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./EditComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=template&id=f64c5728&scoped=true&":
/*!*******************************************************************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=template&id=f64c5728&scoped=true& ***!
  \*******************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_f64c5728_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./EditComponent.vue?vue&type=template&id=f64c5728&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/Form/EditComponent.vue?vue&type=template&id=f64c5728&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_f64c5728_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditComponent_vue_vue_type_template_id_f64c5728_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ViewComponent_vue_vue_type_template_id_f26825f8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ViewComponent.vue?vue&type=template&id=f26825f8&scoped=true& */ "./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=template&id=f26825f8&scoped=true&");
/* harmony import */ var _ViewComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ViewComponent.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ViewComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ViewComponent_vue_vue_type_template_id_f26825f8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _ViewComponent_vue_vue_type_template_id_f26825f8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "f26825f8",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/MaintenanceManagement/ViewComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ViewComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=template&id=f26825f8&scoped=true&":
/*!**************************************************************************************************************************!*\
  !*** ./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=template&id=f26825f8&scoped=true& ***!
  \**************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewComponent_vue_vue_type_template_id_f26825f8_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./ViewComponent.vue?vue&type=template&id=f26825f8&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/MaintenanceManagement/ViewComponent.vue?vue&type=template&id=f26825f8&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewComponent_vue_vue_type_template_id_f26825f8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ViewComponent_vue_vue_type_template_id_f26825f8_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);