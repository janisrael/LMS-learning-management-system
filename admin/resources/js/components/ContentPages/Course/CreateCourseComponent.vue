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
                      <!-- {{ this.$store.getters.this_selected }} {{ action }} -->
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
                            <el-switch
                              v-model="ruleForm.is_featured"
                              size="mini"
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
                is_live: true,
                is_active: true,
                is_global: false,
                is_featured: false,
                subscriptions: [],
                category_id: null
            },
            rules: {
                name: [{
                        required: true,
                        message: "Please input Course name",
                        trigger: "blur",
                    },
                    // { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' }
                ],
                subs_list: [{
                    required: true,
                    message: "Please select Atleast one Subscription Product",
                    trigger: ["blur", "change"],
                }, ],
                description: [{
                    required: true,
                    message: "Please input Course Description",
                    trigger: "blur",
                }, ],
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
            action: this.$store.getters.this_selected.mode,
            this_selected: this.$store.getters.this_selected.data
        };
    },
    computed: {
      // this_selected() {
      //   return this.$store.getters.this_selected
      // }
    },
    created: function() {
        // this.handleResize();
        this.loading = true;
        if (this.action === "edit") {
            this.populate();
        }
    },
    computed: {
        this_subscriptions() {
            return this.$store.getters.allSubscriptions;
        },
        this_categories() {
            return this.$store.getters.this_categories;
        }
    },
    mounted() {},
    methods: {
        handleSave(row) {},
        triggerUploader() {
            this.$refs.uploadFile.show();
        },
        populate() {
            this.ruleForm = this.this_selected;
            let subs = [];
            this.ruleForm.subscriptions.forEach((value, index) => {
                subs.push(value.subscription_id);
            });
            this.ruleForm.is_active = this.ruleForm.is_active === 1 ? true : false
            this.ruleForm.is_featured = this.ruleForm.is_featured === 1 ? true : false
            this.ruleForm.is_global = this.ruleForm.is_featured === 1 ? true : false
            this.ruleForm.is_live = this.ruleForm.is_live === 1 ? true : false

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
                      }).catch(error => {
                        console.log('error')
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
        },
    },
};
</script>

<style scoped>

</style>
