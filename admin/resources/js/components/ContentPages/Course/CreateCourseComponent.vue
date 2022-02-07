<template>
  <el-col :span="24">
<!--    <el-col :span="24" class="page-content-title">Maintenance Management - Schedule List</el-col>-->
    <el-col ref="contentMargin" :span="24" class="content-margin">
      <!-- {{ contentHeight }} -->
      <el-card class="box-card layout-card">
        <!-- <div slot="header" class="clearfix">
          <div class="search-input-suffix" style="width: 100%">
            <el-col :span="24">
              <span class="search-input-label">Create New Course</span>
            
            </el-col>
          </div>
        </div> -->
        <div class="card-content">
          <template>
            <el-form ref="form" :model="form" :rules="rules" class="demo-ruleForm" label-width="200px">
              <el-col :span="24">
                <el-col :span="16">
                  <el-form-item label="Course Name" prop="name">
                    <el-input ref="courseName" type="textarea" v-model="form.name" size="mini"></el-input>
                  </el-form-item>
                  <el-form-item label="Subscription Products" label-width="200px">

                    <el-select ref="subsList" v-model="subs_list" filterable multiple placeholder="please select products" style="width: 100%;">
                      <el-option v-for="subs in this_subscriptions" :key="subs.id" :label="subs.name" :value="subs.id" size="mini">
                      </el-option>
                    </el-select>
                  </el-form-item>
                  <el-form-item label="Description" prop="description">
                    <el-input  ref="courseDesc" type="textarea" v-model="form.description" size="mini"></el-input>
                  </el-form-item>
                  <el-form-item label="Status">
                      <el-switch v-model="form.is_active" size="mini"></el-switch>
                      <span style="width: 80%; display: inline-block;"> 
                          <el-alert
                              title="Status of the Course, Can turn Active or Inactive"
                              type="info">
                          </el-alert>
                      </span>
                  </el-form-item>
                  <el-form-item label="Live Event">
                      <el-switch v-model="form.is_live" size="mini"></el-switch>
                      <span style="width: 80%; display: inline-block;"> 
                          <el-alert
                              title="Turn on to make course as Live Event"
                              type="info">
                          </el-alert>
                      </span>
                  </el-form-item>

                  <el-form-item label="Global Gallery">
                      <el-switch v-model="form.is_global" size="mini"></el-switch> 
                      <span style="width: 80%; display: inline-block;"> 
                          <el-alert
                              title="Turn on to add course to Global Gallery"
                              type="info">
                          </el-alert>
                      </span>
                  </el-form-item>
                  <el-form-item label="Featured">
                      <el-switch v-model="form.is_featured" size="mini"></el-switch>
                      <span style="width: 80%; display: inline-block;"> 
                          <el-alert
                              title="Turn on to add course to Global Gallery"
                              type="info">
                          </el-alert>
                      </span>
                  </el-form-item>
                </el-col>
                <el-col :span="8">
                  <el-form-item label="" label-width="80px">
                    <div v-if="action === 'create'">
                        <div class="edit-preview-on preview-show" style="display: inline-block;">
                          <uploader-component 
                            ref="uploadFile" 
                            :path.sync="form.course_image_url" 
                            style="width: 100%" 
                            @setAttachment="form.course_image_url = $event"/>
                        </div>
                    </div>
                    <div v-else>
                      <div v-if="form.course_image_url !== '' || form.course_image_url !== null">
                          <div class="edit-preview preview-show" @click="triggerUploader()" 
                            :style="{'background-image': 'url(' + form.course_image_url + ')'}">
                              <div class="edit-preview-container">
                                <i class="fas fa-edit"></i>
                              </div>
                          </div>
                    
                          <div class="edit-preview-on preview-not-show" style="display: inline-block;">
                            <uploader-component 
                              ref="uploadFile" 
                              :path.sync="form.course_image_url" 
                              style="width: 100%" 
                              @setAttachment="form.course_image_url = $event"/>
                          </div>
                      </div>
                      <div v-else>
                          <div class="edit-preview preview-not-show" @click="triggerUploader()" 
                          :style="{'background-image': 'url(' + form.course_image_url + ')'}">
                              <div class="edit-preview-container">
                                <i class="fas fa-edit"></i>
                              </div>
                          </div>
                    
                          <div class="edit-preview-on preview-show" style="display: inline-block;">
                            <uploader-component 
                              ref="uploadFile" 
                              :path.sync="form.course_image_url" 
                              style="width: 100%" 
                              @setAttachment="form.course_image_url = $event"/>
                          </div>
                      </div>
                    </div>
                    <span v-if="form.course_image_url">{{ form.course_image_url }}</span>
                  </el-form-item>
                </el-col>
              </el-col>
              <el-col :span="24">
                  <el-form-item style="float:right;">
                      <el-button type="primary" @click="handleAddCourse('form')">
                        <span v-if="action === 'create'">
                          Create
                        </span>
                        <span v-if="action === 'edit'">
                          Save
                        </span>
                      </el-button>
                      <el-button @click="handleCancel()">Cancel</el-button>
                  </el-form-item>
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
import {Notification} from "element-ui";
import UploaderComponent from '../Tools/UploaderComponent'
export default {
  name: "CreateCourseComponent",
  components: {
    UploaderComponent
  },
  props: {
    selected: {
      required: false,
      type: Object
    },
    action: {
      required: false,
      type: String,
      default: 'create'
    }
  },
  data() {
    return {
    form: {
      name: '',
      subs_list: '',
      products: [],
      is_live: false,
      is_active: false,
      is_global: false,
      is_featured: false,
      contentHeight: ''
    },
    rules: {
        name: [
          { required: true, message: 'Please input Course name', trigger: 'blur' }
          // { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' }
        ],
        subs_list: [
          { required: true, message: 'Please select Atleast one Subscription Product', trigger: ['blur', 'change'] }
        ],
        description: [
          { required: true, message: 'Please input Course Description', trigger: 'blur' }
        ]
      },
    loading: false,
    data: [],
    roles_and_permission: this.$store.state.user,

    new_data: {},
    dialogImageUrl: '',
    dialogVisible: false,
    disabled: false,
    subscriptions: [],
    subs_list: []
  }
},
  created: function() {
    // this.handleResize();
    this.loading = true
    // this.getSubscriptions()
          // console.log(this.$refs.contentMargin.clientHeight. asdasd)
    // this.$store.dispatch('GetComponentName')
    if(this.action !== 'create') {
      this.populate()
    }
  },
  computed: {
    this_subscriptions() {
      return this.$store.getters.allSubscriptions
    }
  },
  mounted () {
 
    let box = document.querySelector('.content-margin');
    let width = box.offsetWidth;
    let height = box.offsetHeight;
    console.log(height)
  },
  methods: {
    handleSave(row) {
   
    },
    // getSubscriptions() {
    //   let url = "/subscriptions";
    //   axios.get(url)
    //     .then(response => {
    //       let collection= response.data.subscription_products
    //       this.total = response.data.meta.total
   
    //       this.subscriptions = collection
      
    //       this.loading = false
    //     })
    //     .catch( error => {
    //       console.log(error)
    //     });
    // },
    triggerUploader() {
      this.$refs.uploadFile.show();
    },
    populate() {
      this.form = this.selected
      let subs = []
      this.form.subscriptions.forEach((value, index) => {
        subs.push(value.id)
      })
      this.form['subs_list'] = subs
      this.subs_list = subs
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
    validateFieds(value) {
      if(this.form.name === '') {
          this.$notify({
            title: 'Error',
            message: 'Course Name is Requried!',
            type: 'error'
          });
   
          // this.$refs.courseName.$el.focus()
          this.$nextTick(() => this.$refs.courseName.focus())
          this.$nextTick(() => this.$refs.courseName.blur())
          return false
      }
      if(this.subs_list.length === 0) {
          this.$notify({
            title: 'Error',
            message: 'Please select at least 1 subscription!',
            type: 'error'
          });
    

          this.$nextTick(() => this.$refs.subsList.focus())
          this.$nextTick(() => this.$refs.subsList.blur())
          return false
      }

      if(this.form.description === '') {
          this.$notify({
            title: 'Error',
            message: 'Please Input Description!',
            type: 'error'
          });

          this.$nextTick(() => this.$refs.courseDesc.focus())
          this.$nextTick(() => this.$refs.courseDesc.blur())
          return false
      }
      return true
    },
    handleAddCourse(formName) {
      this.image_url = this.form.course_image_url
      let validated = this.validateFieds()
      if(validated === false) {
        return
      }
      this.$refs[formName].validate((valid) => {
        if (valid) {
          let url = 'courses'
         this.form.subs_list = this.subs_list
          axios.post(url, this.form).then(res => {
            console.log(res.data.status)
            if(res.data.status === 'error') {
              res.data.data.errors.name.forEach((value, index) => {
                this.$notify({
                  title: res.data.data.messages,
                  message: value,
                  type: 'error'
                })
                // this.$refs.uploadFile.removeFile()
              })
              
            } else {
              this.$notify({
                title: 'Success',
                message: 'New Course Successfuly Added',
                type: 'success'
              });
              this.resetForm(formName)
            }
   
          }).catch(error => {
              this.$notify({
              title: 'Error',
              message: error,
              type: 'error'
            });
           
          })
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    handleCancel() {
      let value = {
        mode: 'back',
        data: ''
      }
      this.$emit('change',value)
    },
  }
}
</script>

<style scoped>

</style>
