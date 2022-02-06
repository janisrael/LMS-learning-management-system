<template>
  <div>
    <el-dialog
      :title="title"
      :visible.sync="dialogForm"
      width="60%"
      top="2vh">
      <div class="clearfix">
        <el-col :span="24">
          <el-col :span="24" class="content-margin">
            <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                <el-row :gutter="20">
                  <el-col :span="24">
                    <transition name="el-fade-in">
                    <el-alert
                      v-if="has_error"
                      :title="error_title"
                      type="warning"
                      show-icon
                      @close="closeAlert"
                      class="error_message">
                        <span v-if="errors" v-for="err in errors">
                          <div v-for="er in err" style="color: #F56C6C"> {{ er }} </div>
                        </span>
                    </el-alert>
                    </transition>
                  </el-col>
                </el-row>
                <el-form :model="selected" ref="ruleForm" :rules="rules" label-width="200" class="demo-ruleForm">
                  <div>                    
                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="username" label="Username:" required>
                          <el-input type="input" v-model="selected.username" clearable></el-input>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="email" label="Email:" required>
                          <el-input type="email" v-model="selected.email" clearable></el-input>
                        </el-form-item>
                      </el-col>
                    </el-col>
                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="password" label="Password:" required>
                          <el-input type="password" v-model="selected.password" clearable></el-input>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="password_confirmation" label="Confirm Password:">
                          <el-input type="password" v-model="selected.password_confirmation" clearable></el-input>
                        </el-form-item>
                      </el-col>
                    </el-col>
                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item label="is Active:">
                          <el-switch v-model="isactive"></el-switch>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item label="Role">
                          <el-select v-model="selected.role_name" placeholder="Select">
                            <el-option
                              v-for="item in roles"
                              :key="item.name"
                              :label="item.name"
                              :value="item.name">
                            </el-option>
                          </el-select>
                        </el-form-item>
                      </el-col>
                    </el-col>

                    <el-col :span="24">
                      <hr>
                    </el-col>

                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item label="Can Edit Profile:">
                          <el-switch v-model="permissions.profile_update"></el-switch>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="avatar" label="Avatar:">
                          <!-- <el-input type="file" v-model="image" id="avatar" name="avatar" @change="avatarSelected($event)" accept="image/*" label="Image"></el-input> -->
                          <div class="input-file">
                            <el-input ref="file" type="file" v-model="image" id="avatar" style="display: none;" @change="avatarSelected($event)" accept="image/*" label="Image"></el-input>
                            <el-button slot="trigger" size="small" type="primary"  @click="openAttachment()">Click to upload</el-button>
                            <div slot="tip" class="el-upload__tip" v-if="!busy" style="line-height: 1.5;">{{ avatar_name ? avatar_name : '' }}</div> 
                          </div>
                        </el-form-item>
                      </el-col>
                    </el-col>

                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="15" :xl="15">
                        <el-form-item prop="name" label="Name:">
                          <el-input type="input" v-model="profile.name" clearable></el-input>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="9" :xl="9">
                        <el-form-item prop="user_group_id" label="Group:"><br>
                          <el-select v-model="profile.user_group_id" placeholder="Select">
                            <el-option
                              v-for="item in groups"
                              :key="item.name"
                              :label="item.name"
                              :value="item.id">
                            </el-option>
                          </el-select>
                        </el-form-item>
                      </el-col>
                    </el-col>

                    <el-col :span="24">
                      <el-form-item prop="address" label="Address:">
                        <el-input type="textarea" v-model="profile.address" clearable></el-input>
                      </el-form-item>
                    </el-col>

                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="sf_id" label="Salesforce ID:">
                          <el-input type="input" v-model="profile.sf_id" clearable></el-input>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="employee_id" label="Employee ID:">
                          <el-input type="input" v-model="profile.employee_id" clearable></el-input>
                        </el-form-item>
                      </el-col>
                    </el-col>

                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="region" label="Region:">
                          <el-input type="input" v-model="profile.region" clearable></el-input>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="mobile_number" label="Mobile Number:">
                          <el-input type="input" v-model="profile.mobile_number" clearable></el-input>
                        </el-form-item>
                      </el-col>
                    </el-col>

                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="immediate_head" label="Immediate Head:">
                          <el-input type="input" v-model="profile.immediate_head" clearable></el-input>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="job_title" label="Job Title:">
                          <el-input type="input" v-model="profile.job_title" clearable></el-input>
                        </el-form-item>
                      </el-col>
                    </el-col>

                    <el-col :span="24">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="organization" label="Organization:">
                          <el-input type="input" v-model="profile.organization" clearable></el-input>
                        </el-form-item>
                      </el-col>
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item prop="branch" label="Branch:">
                          <el-input type="input" v-model="profile.branch" clearable></el-input>
                        </el-form-item>
                      </el-col>
                    </el-col>

                  </div>
                </el-form>
            </el-col>
          </el-col>
        </el-col>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button size="medium" @click="handleClose(selected)">Close</el-button>
        <el-button type="primary" size="medium" @click="handleSave(selected)">Confirm</el-button>
      </span>
     </el-dialog>
  </div>
</template>

<script>
import { Notification } from 'element-ui'
  export default {
    name: "CreateUserComponent",
    data() {
      return {
        loading: false,
        schedule: [],
        dialogForm: false,
        title: '',
        selected: {},
        isactive: true,
        password_confirmation: '',
        password: '',
        has_error: false,
        errors: [],
        error_details: {},
        error_title: '',
        role: '',
        roles: [],
        groups: [],
        form: new Form({
          username: '',
          email: '',
          password: '',
          password_confirmation: '',
          is_active: '',
          permissions: {
            profile_update: false
          },
          role_name: '',
          profile: {
            name: '',
            sf_id: '',
            user_group_id: '',
            region: '',
            mobile_number: '',
            employee_id: '',
            immediate_head: '',
            job_title: '',
            organization: '',
            avatar: '',
            address: '',
            branch: ''
          }
        }),
        ruleForm: {
          username: '',
          email: '',
          password: '',
          password_confirmation: '',
          is_active: true,
          permissions: {
            profile_update: false,
          },
          profile: {
            name: '',
            sf_id: '',
            user_group_id: '',
            region: '',
            mobile_number: '',
            employee_id: '',
            immediate_head: '',
            job_title: '',
            organization: '',
            avatar: '',
            address: '',
            branch: ''            
          }
        },
        profile: {
          name: '',
          sf_id: '',
          user_group_id: '',
          region: '',
          mobile_number: '',
          employee_id: '',
          immediate_head: '',
          job_title: '',
          organization: '',
          avatar: '',
          address: '',
          branch: ''
        },
        permissions: {
          profile_update: false
        },
        rules: {
          // name: [
          //   { required: true, message: 'Name required'},
          //   { min: 3, message: 'Length should be more than 3'}
          // ],
          username: [
            { required: true, message: 'Username required'}
          ],
          email: [
            { type: 'email', required: true, message: 'Email required', trigger: 'blur' }
          ],
          password: [
            { required: true, message: 'Password required', trigger: 'blur' },
            { min: 6, message: 'Length should be more than 5 characters', trigger: 'blur' }
          ],
          password_confirmation: [
            { required: true, message: 'Confirm Password', trigger: 'blur' },
            { min: 6, message: 'Length should be more than 5 characters', trigger: 'blur' }
          ],
          role_id: [
            { required: true, message: 'Role is required', trigger: 'blur' },
          ]
        },
        avatar: null, 
        image: null,
        busy: false,
        avatar_name: ''
      }
    },
    created: function() {
      this.getRoles()
      this.getGroups()
      Fire.$on('AfterCreatedUserLoadIt',()=>{ //custom events fire on
        this.handleClose();
      });
    },
    methods: {
      getRoles() {
        var AjaxUrl = "/roles-management";
        axios.get(AjaxUrl)
          .then(response => {
            this.roles = response.data.data; // add data to the response
            // this.total = response.data.recordsTotal
            // this.chunkData(this.data)
            this.loading = false
          }).catch(error => {
          this.no_access = true
          this.no_access_msg = error.response.data.message
          this.loading = false
        })
      },
      getGroups() {
        var AjaxUrl = "/user-group";
        axios.get(AjaxUrl, {
          params: { 'is_active': 1 }
        }).then(response => {
            this.groups = response.data.data; // add data to the response
            this.loading = false
          }).catch(error => {
          this.no_access = true
          this.no_access_msg = error.response.data.message
          this.loading = false
        })
      },
      closeAlert() {
        this.has_error = false
        this.errors = []
      },
      handleSave(selected) {
        this.$refs.ruleForm.validate((valid) => {
          if (valid) {
            this.form.fill(selected)
            this.form.profile = this.profile;
            if(this.isactive === false) { // convert switch value from true/false to int
              this.form.is_active = 0
            } else {
              this.form.is_active = 1
            }
            let pass1 = selected.password
            let pass2 = selected.password_confirmation
            // this.form.role_id = this.role

            if(pass1 !== pass2) {
              // this.$message.error('Password did not Match!')
              this.has_error = true
              this.error_title = 'Password did not Match!'
              return
            }
            this.$Progress.start()
            this.form.password = selected.password
            this.form.profile.avatar = this.avatar;
            this.form.permissions = this.permissions;

            this.form.post('/user/create')
              .then( response =>{
                let stat = response.data.status;
                Notification[stat]({
                  title: stat.charAt(0).toUpperCase() + stat.slice(1),
                  message: response.data.message,
                  duration: 4 * 1000
                });
                this.$Progress.finish()
                this.handleClose(selected)
              })
              .catch( error => {
                var errormsg = error.response.data.message
                this.has_error = true
                this.error_details = error.response.data
                this.error_title = error.response.data.message
                this.errors = error.response.data.errors
                // this.$message.error(errormsg)
                this.$Progress.finish()
              })
          } else {
            console.log('error submit!!')
            return false;
          }
        });
      },
      handleClose(selected) {
        this.$refs.ruleForm.resetFields();
        // this.form = {}
        this.password = ''
        this.has_error = false
        this.errors = []
        this.selected = {}
        this.form = new Form({
          username: '',
          email: '',
          password: '',
          password_confirmation: '',
          is_active: '',
          profile: {
            name: '',
            sf_id: '',
            user_group_id: '',
            region: '',
            mobile_number: '',
            employee_id: '',
            immediate_head: '',
            job_title: '',
            organization: '',
            avatar: '',
            address: '',
            branch: ''
          }
        })
        this.$emit('changed')
      },
      show() {
        this.dialogForm = true
        // this.title = 'Edit Ticket #: ' + this.selected.ticket_no
        this.title = 'Add New User'
      },
      avatarSelected(e) {
        this.busy = true;
        const image = event.target.files[0];
        if(image){
          this.avatar_name = image.name;
          const reader = new FileReader()
          reader.readAsDataURL(image)
          reader.onload = e => {
              this.avatar = event.target.result
          }
        }
        this.busy = false;
      },
      openAttachment(){
        document.getElementById("avatar").click()
      }
    }
  }
</script>

<style scoped>

</style>
