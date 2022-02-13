<template>
    <el-col :span="24">
        <el-col ref="contentMargin" :span="24" class="content-margin">
            <el-card class="box-card layout-card">
              <div slot="header" class="clearfix">
                  <div class="search-input-suffix" style="width: 100%">
                    <el-col :span="24">
                      <span class="page-header-title" @click="handleCancel()">
                         <el-page-header title="">
                            <i class="el-icon-back"></i>
                          </el-page-header>
                        </span>
                      <span class="page-header-btn-wrapper">
                        <el-button type="primary" plain @click="handleAddCourse('ruleForm')" size="small">
                          <span v-if="action === 'add'"> <i class="el-icon-plus"></i> Create Course</span>
                          <span v-if="action === 'edit'"> <i class="far fa-save"></i> Save Course</span>
                        </el-button>
                      </span>
                    </el-col>
                  </div>
                </div>
                <div class="card-content">
                    <template>
                    <el-form
                      ref="ruleForm"
                      :model="ruleForm"
                      :rules="rules"
                      class="demo-ruleForm"
                      label-width="200px"
                    >
                      <el-col :span="24">
                        <el-col :span="16">
                          <el-form-item label="Course Name" prop="name">
                            <el-input
                              ref="courseName"
                              type="textarea"
                              v-model="ruleForm.name"
                              size="mini"
                            ></el-input>
                          </el-form-item>
                          <el-form-item
                            label="Subscription Products"
                            label-width="200px"
                          >
                            <el-select
                              ref="subsList"
                              v-model="subs_list"
                              filterable
                              multiple
                              placeholder="please select products"
                              style="width: 100%"
                            >
                              <el-option
                                v-for="subs in this_subscriptions"
                                :key="subs.id"
                                :label="subs.name"
                                :value="subs.id"
                                size="mini"
                              >
                              </el-option>
                            </el-select>
                          </el-form-item>
                          <el-form-item
                            label="Category"
                            label-width="200px"
                          >
                            <el-select
                              ref="category"
                              v-model="ruleForm.category_id"
                              filterable
                              placeholder="please select category"
                              style="width: 100%"
                            >
                              <el-option
                                v-for="cat in this_categories"
                                :key="cat.id"
                                :label="cat.name"
                                :value="cat.id"
                                size="mini"
                              >
                              </el-option>
                            </el-select>
                          </el-form-item>
                          <el-form-item label="Description" prop="description">
                            <el-input
                              ref="courseDesc"
                              type="textarea"
                              v-model="ruleForm.description"
                              size="mini"
                            ></el-input>
                          </el-form-item>
                          <el-form-item label="Active">
                            <el-switch v-model="ruleForm.is_active" size="mini"></el-switch>
                            <span style="width: 80%; display: inline-block">
                              <el-alert
                                title="Status of the Course, if set to Inactive will not be visible to all client. default: Active"
                                type="info"
                                :closable="false">
                              </el-alert>
                            </span>
                          </el-form-item>
                          <el-form-item label="Live Event">
                            <el-switch v-model="ruleForm.is_live" size="mini"></el-switch>
                            <span style="width: 80%; display: inline-block">
                              <el-alert
                                title="Turn on to make course as Live Event"
                                type="info"
                                :closable="false"
                              >
                              </el-alert>
                            </span>
                          </el-form-item>
                          <el-form-item label="Global Gallery">
                            <el-switch v-model="ruleForm.is_global" size="mini"></el-switch>
                            <span style="width: 80%; display: inline-block">
                              <el-alert
                                title="Turn on to add course to Global Gallery"
                                type="info"
                                :closable="false"
                              >
                              </el-alert>
                            </span>
                          </el-form-item>
                          <el-form-item label="Featured">
                            <el-switch v-model="ruleForm.is_featured === 'true' ? true : false" size="mini"
                            ></el-switch>
                            <span style="width: 80%; display: inline-block">
                              <el-alert
                                title="Turn on to add course to Global Gallery"
                                type="info"
                                :closable="false"
                              >
                              </el-alert>
                            </span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="8">
                          <el-form-item label="" label-width="80px">

                            <div v-if="action === 'add'">
                              <div
                                class="edit-preview-on preview-show"
                                style="display: inline-block"
                              >
                                <uploader-component
                                  ref="uploadFile"
                                  :path.sync="ruleForm.form"
                                  style="width: 100%"
                                  @setAttachment="ruleForm.course_image_url = $event"
                                />
                              </div>
                            </div>
                   
                            <div v-else>
                              <div>
                                  <div
                                    class="edit-preview preview-on"
                                    @click="triggerUploader()"
                                    :style="{
                                      'background-image':
                                        'url(' + ruleForm.course_image_url + ')',
                                    }">
                                  <div class="edit-preview-container">
                                      <i class="el-icon-upload"></i>
                                    </div>
                                  </div>
        
                                  <div
                                    class="edit-preview-on preview-not-show"
                                    style="display: inline-block">
                                    <uploader-component
                                      ref="uploadFile"
                                      :path.sync="ruleForm.course_image_url"
                                      style="width: 100%"
                                      @setAttachment="ruleForm.course_image_url = $event"
                                    />
                                  </div>
                                  <span v-if="ruleForm.course_image_url" class="image-url">
                                      {{ ruleForm.course_image_url }}
                                  </span>
                              </div>
                            </div>

                          </el-form-item>
                        </el-col>
                      </el-col>
                      
                    </el-form>
            </template>
  
        </div>
      </el-card>
    </el-col>
    <!-- <component ref="modalComponent" :is="currentComponent" :selected="passData" @changed="emitChange()"/> -->
  </el-col>
</template>

<script>
import { Notification } from "element-ui";
import UploaderComponent from "../Tools/UploaderComponent";

export default {
    name: "CreateCourseComponent",
    components: {
        UploaderComponent,
    },
    props: {
        selected: {
            required: false,
            type: Object,
        }
    },
    data() {
      return {
        ruleForm: {
          name: '',
          description: '',
          is_live: 'true',
          is_active: 'true',
          is_global: 'false',
          is_featured: 'false',
          subscriptions: [],
          category_id: null
        },
        rules: {
          name: [{
                required: true,
                message: "Please input Course name",
                trigger: "blur",
            }
          ],
          subs_list: [{
            required: true,
            message: "Please select Atleast one Subscription Product",
            trigger: ["blur", "change"],
          }],
          description: [{
            required: true,
            message: "Please input Course Description",
            trigger: "blur",
          }]
        },
        loading: false,
        data: [],
        roles_and_permission: this.$store.state.user,
        new_data: {},
        dialogImageUrl: "",
        dialogVisible: false,
        disabled: false,
        subscriptions: [],
        subs_list: [],
        action: localStorage.getItem('action'),
        this_selected: this.$store.getters.this_selected.data,
        current_route: this.$route.name
      };
    },
    created: function() {
      // this.handleResize();
      console.log(this.this_selected)
      this.loading = true;
      let curr_route = this.current_route.toLowerCase()
      if(curr_route.includes('edit')) {
        // this.action = localStorage.setItem('state_action', 'edit')
        if(!localStorage.getItem('reactiveData') || localStorage.getItem('reactiveData') === 'undefined') {
          this.action = 'edit'
          localStorage.setItem('action', 'edit')
          localStorage.setItem('reactiveData', JSON.stringify(this.this_selected))
          localStorage.setItem('subscriptions', JSON.stringify(this.this_selected.subscriptions))
          let data = JSON.parse(localStorage.getItem('reactiveData'))
          let subs = JSON.parse(localStorage.getItem('subscriptions'))
          this.populate(data, subs);
        } else {
          localStorage.setItem('action', 'edit')
          let data = JSON.parse(localStorage.getItem('reactiveData'))
          let subs = JSON.parse(localStorage.getItem('subscriptions'))
          this.populate(data, subs);
        }
      } else {
        this.action = 'add'
        localStorage.setItem('action', 'add')
      }
    },
    watch: {
      ruleForm: {
        handler: function(after, before) {
        let curr_route = this.current_route.toLowerCase()
      
        if(curr_route.includes('edit')) {
          if(localStorage.getItem('reactiveData') || localStorage.getItem('reactiveData') !== 'undefined') {
            localStorage.removeItem('reactiveData')

            localStorage.setItem('state_action', 'edit')
            localStorage.setItem('reactiveData', JSON.stringify(this.ruleForm))
          } else {
            localStorage.setItem('reactiveData', JSON.stringify(this.ruleForm))
            localStorage.removeItem('state_action')
            localStorage.setItem('state_action', 'edit')
          }
          }
        },
        deep: true
      } 
    },
    computed: {
        this_subscriptions() {
            return this.$store.getters.allSubscriptions;
        },
        this_categories() {
            return this.$store.getters.this_categories;
        },
    },
    mounted() {},
    methods: {
        handleSave(row) {},
        triggerUploader() {
          this.$refs.uploadFile.show();
        },
        populate(data, subscriptions) {
          this.ruleForm = data
          let subs = [];
          this.ruleForm.subscriptions.forEach((value, index) => {
            subs.push(value.subscription_id);
          });
          this.ruleForm["subs_list"] = subs;
          this.subs_list = subs;
        },
        resetForm(formName) {
          this.$refs[formName].resetFields();
        },
        handleRemove(file) {
          console.log(file);
        },
        handlePictureCardPreview(file) {
          this.dialogImageUrl = file.url;
          this.dialogVisible = true;
        },
        handleAddCourse(formName, ruleForm) {
          this.ruleForm.subs_list = this.subs_list
            this.$refs['ruleForm'].validate((valid) => {
              if (valid) {
                if(this.action === 'edit') {
                  let result = this.$store.dispatch("EditCourse", this.ruleForm).then(response => {
                    this.$notify({
                      title: "Success",
                      message: "New Course Successfuly Updated",
                      type: "success",
                    });
                    this.removeCache()
                  }).catch(error => {
                    console.log('error')
                    this.$notify({
                      title: "Error",
                      message: 'Invalid Data',
                      type: "error",
                    });
                  })
                
                } else {
                  let result = this.$store.dispatch("AddCourse", this.ruleForm)
                  .then(response => {
                    this.$notify({
                      title: "Success",
                      message: "New Course Successfuly Added",
                      type: "success",
                    });
                  }).catch(error => {
                    console.log('adding error')
                  })
                  
                }
              } else {
                console.log("error submit!!");
                return false;
              }
          });
        },
        handleCancel() {
          let value = {
            mode: "back",
            data: "back",
          };
          console.log(value ,'BACK')
          this.$emit("change", value);
          this.$router.push({ name: 'Courses', replace: true })
          this.removeCache()
        },
        removeCache() {
          localStorage.removeItem('reactiveData')
          localStorage.removeItem('action')
          localStorage.removeItem('subscriptions')
        }
    },
};
</script>

<style scoped>

</style>
