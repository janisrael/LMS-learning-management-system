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
                        <el-button type="primary" plain @click="handleAddLesson('ruleForm')" size="small">
                          <span v-if="action === 'add'"> <i class="el-icon-plus"></i> Create Lesson</span>
                          <span v-if="action === 'edit'"> <i class="far fa-save"></i> Save Course</span>
                        </el-button>
                      </span>
                    </el-col>
                  </div>
                </div>
                <div class="card-content" style="padding: 10px 0px !important">
                  <template>
                    <el-form
                      ref="ruleForm"
                      :model="ruleForm"
                      :rules="rules"
                      class="demo-ruleForm"
                      label-width="200px"
                    >
                      <el-col :span="24" class="lesson-section" style="padding-top: 10px !important;">
                        <el-col :span="16">
                          <el-form-item label="Lesson Name" prop="name">
                            <el-input
                              ref="lessonName"
                              type="textarea"
                              v-model="ruleForm.name"
                              size="mini"
                            ></el-input>
                          </el-form-item>
                          <el-form-item
                            label="Course"
                            required
                            prop="course_id"
                            label-width="200px"
                          >
                            <el-select
                              ref="subsList"
                              v-model="ruleForm.course_id"
                              filterable
                              @change="getChapters(ruleForm.course_id)"
                              placeholder="Select Course"
                              style="width: 100%"
                            >
                              <el-option
                                v-for="course in this_courses"
                     
                                :key="course.id"
                                :label="course.name"
                                :value="course.id"
                                size="mini"
                              >
                              </el-option>
                            </el-select>
                          </el-form-item>
                          <el-form-item
                            label="Chapter"
                            prop="chapter_id"
                            label-width="200px"
                          >
                            <el-select
                              ref="chapterid"
                              v-model="ruleForm.chapter_id"
                              filterable
                              placeholder="Select Course"
                              style="width: 100%"
                            >
                              <el-option
                                v-for="chapter in chapters"
                                :key="chapter.id"
                                :label="chapter.name"
                                :value="chapter.id"
                                size="mini"
                              >
                              </el-option>
                            </el-select>
                          </el-form-item>
                          <el-form-item
                            label="Author"
                            prop="author_id"
                            label-width="200px"
                          >
                            <el-select
                              ref="authorid"
                              v-model="ruleForm.author_id"
                              filterable
                              required
                              placeholder="Select Author"
                              style="width: 100%"
                            >
                              <el-option
                                v-for="author in this_authors"
                                :key="author.id"
                                :label="author.last_name + ' ' + author.first_name"
                                :value="author.id"
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
                                  :path.sync="ruleForm.image_url"
                                  :action_from="'lesson'"
                                  style="width: 100%"
                                  @setAttachment="ruleForm.image_url = $event"
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
                                        'url(' + ruleForm.image_url + ')',
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
                                      :path.sync="ruleForm.image_url"
                                      :action_from="'lesson'" 
                                      style="width: 100%"
                                      @setAttachment="ruleForm.image_url = $event"
                                    />
                                  </div>
                                  <span v-if="ruleForm.mage_url" class="image-url">
                                      {{ ruleForm.image_url }}
                                  </span>
                              </div>
                            </div>

                          </el-form-item>
                        </el-col>
                      </el-col>
                      <el-col :span="24" style="background-color: rgba(181, 181, 181, .13); " class="lesson-section">
                        <span class="lesson-section-title">
                          Video
                          <i v-if="ruleForm.video_url === null || ruleForm.video_url === ''" class="el-icon-warning" style="color: #f56c6c"/>
                        </span>
                          <LessonVideoComponent @setVideo="setVideo" @setPreview="setPreview" :ruleForm="ruleForm"/>
                      </el-col>
                      <el-col :span="24" class="lesson-section">
                        <span class="lesson-section-title" style="background-color: #f3f6f9 !important;">
                        Resources
                        <i v-if="ruleForm.resources.length === 0" class="el-icon-warning" style="color: #f56c6c"/>
                        </span>
                        <LessonResourcesComponent @setResource="setResources"/>
                      </el-col>
                      <el-col :span="24" class="lesson-section" style="background-color: rgba(181, 181, 181, .13); padding-bottom: 15% !important">
                        <span class="lesson-section-title">
                          FAQ's
                          <i v-if="ruleForm.faqs.length === 0" class="el-icon-warning" style="color: #f56c6c"/>
                        </span>
                        <LessonFaqComponent @setFaqs="setFaqs"/>
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
import LessonVideoComponent from "./ContentParts/LessonVideoComponent.vue"
import LessonResourcesComponent from "./ContentParts/LessonResourcesComponent.vue"
import LessonFaqComponent from "./ContentParts/LessonFaqComponent.vue"
  export default {
    name: 'CreateLessonComponent',
    components: {
      UploaderComponent,
      LessonVideoComponent,
      LessonResourcesComponent,
      LessonFaqComponent
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
          course_id: '',
          is_live: 'true',
          is_active: 'true',
          is_global: 'false',
          is_featured: 'false',
          video_url: null,
          resources: [],
          faqs: []
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
        current_route: this.$route.name,
        chapters: [],
        activeName: 'video',
        videoData: {},
        resourceData: [],
        faqsData: []
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
        this_courses() {
          return this.$store.getters.allCourses;
        },
        this_categories() {
          return this.$store.getters.this_categories;
        },
        this_authors() {
          return this.$store.getters.allAuthors;
        }
    },
    methods: {
        setFaqs(value) {
          this.videoData = value
          this.faqsData = value
          this.ruleForm.faqs = this.faqsData
        },
        setResources(value) {
          this.resourceData = value
          this.ruleForm.resources = value
        },
        setPreview(value) {
          this.ruleForm.preview_url = value
        },
        setVideo(value) {
          this.ruleForm.video_url = value
        },
        handleClick(tab, event) {
          console.log(tab, event);
        },
        getChapters(id) {
          let result = this.$store.dispatch('GetChapters', id).then(response => {
            if(result) {
              this.chapters = this.$store.getters.this_chapters
            }
          })
        },
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
        handleAddLesson(formName, ruleForm) {
          // this.ruleForm.subs_list = this.subs_list
            this.$refs['ruleForm'].validate((valid) => {
              if (valid) {
                if(this.action === 'edit') {
                  this.$store.dispatch("EditLesson", this.ruleForm).then(response => {
                    if(response.request.status === 200){
                      this.$notify({
                        title: "Success",
                        message: "New Course Successfuly Updated",
                        type: "success",
                      });
                    }
                    this.removeCache()
                  }).catch(error => {
                    this.$notify({
                      title: "Error",
                      message: error,
                      type: "error",
                    });
                  })
                } else {
                 this.$store.dispatch("addtLesson", this.ruleForm).then(response => {
                    if(response.request.status === 200) {
                      this.$notify({
                        title: "Success",
                        message: "New Lesson Successfuly Added",
                        type: "success",
                      });
                    }
                 }).catch(error => {
                    this.$notify({
                      title: "Error",
                      message: error,
                      type: "error",
                    });
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
          this.$router.push({ name: 'Lessons', replace: true })
          this.removeCache()
        },
        removeCache() {
          localStorage.removeItem('reactiveData')
          localStorage.removeItem('action')
          localStorage.removeItem('subscriptions')
        }
    },
  }
</script>

<style lang="scss" scoped>

</style>