<template>
    <el-col :span="24">
        <!--    <el-col :span="24" class="page-content-title">Maintenance Management - Schedule List</el-col>-->
        <el-col ref="contentMargin" :span="24" class="content-margin">
            <!-- {{ contentHeight }} -->
            <el-card class="box-card layout-card">
              <div slot="header" class="clearfix">
                  <div class="search-input-suffix" style="width: 100%">
                    <el-col :span="24">
                      <span class="page-header-title" @click="handleCancel()">
                         <el-page-header title="">
                            <i class="el-icon-back"></i>
                          </el-page-header>
                          <!-- Create New Course -->
                        </span>

                      <span class="page-header-btn-wrapper">
                        <el-button type="primary" plain @click="handleAddCourse('ruleForm')">
                          <span v-if="action === 'create'"> <i class="el-icon-plus"></i> Create Course</span>
                          <span v-if="action === 'edit'"> <i class="far fa-save"></i></span>
                        </el-button>
                        <!-- <el-button @click="handleCancel()">Cancel</el-button> -->
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
                          <el-form-item label="Description" prop="description">
                            <el-input
                              ref="courseDesc"
                              type="textarea"
                              v-model="ruleForm.description"
                              size="mini"
                            ></el-input>
                          </el-form-item>
                          <el-form-item label="Status">
                            <el-switch v-model="ruleForm.is_active" size="mini"></el-switch>
                            <span style="width: 80%; display: inline-block">
                              <el-alert
                                title="Status of the Course, Can turn Active or Inactive"
                                type="danger">
                              </el-alert>
                            </span>
                          </el-form-item>
                          <el-form-item label="Live Event">
                            <el-switch v-model="ruleForm.is_live" size="mini"></el-switch>
                            <span style="width: 80%; display: inline-block">
                              <el-alert
                                title="Turn on to make course as Live Event"
                                type="danger"
                              >
                              </el-alert>
                            </span>
                          </el-form-item>
        
                          <el-form-item label="Global Gallery">
                            <el-switch v-model="ruleForm.is_global" size="mini"></el-switch>
                            <span style="width: 80%; display: inline-block">
                              <el-alert
                                title="Turn on to add course to Global Gallery"
                                type="danger"
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
                                type="danger"
                              >
                              </el-alert>
                            </span>
                          </el-form-item>
                        </el-col>
                        <el-col :span="8">
                          <el-form-item label="" label-width="80px">

                            <div v-if="action === 'create'">
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
                              <div
                                v-if="
                                  ruleForm.course_image_url !== '' ||
                                  ruleForm.course_image_url !== null
                                "
                              >
                                <div
                                  class="edit-preview preview-show"
                                  @click="triggerUploader()"
                                  :style="{
                                    'background-image':
                                      'url(' + ruleForm.course_image_url + ')',
                                  }"
                                >
                                  <div class="edit-preview-container">
                                    <i class="fas fa-edit"></i>
                                  </div>
                                </div>
        
                                <div
                                  class="edit-preview-on preview-not-show"
                                  style="display: inline-block"
                                >
                                  <uploader-component
                                    ref="uploadFile"
                                    :path.sync="ruleForm.course_image_url"
                                    style="width: 100%"
                                    @setAttachment="ruleForm.course_image_url = $event"
                                  />
                                </div>
                              </div>
                              <div v-else>
                                <div
                                  class="edit-preview preview-not-show"
                                  @click="triggerUploader()"
                                  :style="{
                                    'background-image':
                                      'url(' + ruleForm.course_image_url + ')',
                                  }"
                                >
                                  <div class="edit-preview-container">
                                    <i class="fas fa-edit"></i>
                                  </div>
                                </div>
        
                                <div
                                  class="edit-preview-on preview-show"
                                  style="display: inline-block"
                                >
                                  <uploader-component
                                    ref="uploadFile"
                                    :path.sync="ruleForm.course_image_url"
                                    style="width: 100%"
                                    @setAttachment="ruleForm.course_image_url = $event"
                                  />
                                </div>
                              </div>
                            </div>
                            <span v-if="ruleForm.course_image_url" class="image-url">{{
                              ruleForm.course_image_url
                            }}</span>
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
        },
        action: {
            required: false,
            type: String,
            default: "create",
        },
    },
    data() {
        return {
            ruleForm: {
                name: '',
                description: '',
                is_live: false,
                is_active: false,
                is_global: false,
                is_featured: false,
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
        };
    },
    created: function() {
        // this.handleResize();
        this.loading = true;
        if (this.action !== "create") {
            this.populate();
        }
    },
    computed: {
        this_subscriptions() {
            return this.$store.getters.allSubscriptions;
        },
    },
    mounted() {},
    methods: {
        handleSave(row) {},
        triggerUploader() {
            this.$refs.uploadFile.show();
        },
        populate() {
            this.ruleForm = this.selected;
            let subs = [];
            this.ruleForm.subscriptions.forEach((value, index) => {
                subs.push(value.id);
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
                    this.$store.dispatch("AddCourse", this.ruleForm);
                    this.$notify({
                        title: "Success",
                        message: "New Course Successfuly Added",
                        type: "success",
                    });

                    // this.resetForm(formName);

                    //   })
                } else {
                    console.log("error submit!!");
                    return false;
                }
            });
        },
        handleCancel() {
          console.log('BACK')
            let value = {
                mode: "back",
                data: "",
            };
            this.$emit("change", value);
        },
    },
};
</script>

<style scoped>

</style>
