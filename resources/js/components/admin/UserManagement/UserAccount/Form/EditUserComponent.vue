<template>
  <div>
    <el-dialog
      :title="title"
      :visible.sync="dialogEdit"
      width="60%"
      top="2vh">
      <el-form :model="selected" ref="ruleForm" :rules="rules" label-width="170" label-position="left" class="demo-ruleForm">
        <div class="clearfix">
          <transition name="el-fade-in">
          <el-alert
            v-if="has_error"
            :title="error_title"
            type="warning"
            show-icon
            @close="closeAlert"
            class="error_message"
            style="margin-top: -5px !important;">
            <span v-if="errors">
              <span v-for="(err, index) in errors" :key="index">
                <div v-for="(er, indexerr) in err" :key="indexerr" style="color: #F56C6C"> {{ er }} </div>
              </span>
            </span>
          </el-alert>
          </transition>
          <el-col :span="24"> 
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item label="Last Login At:">
                <span v-if="selected.last_login_at === '' || selected.last_login_at === null" class="modal-label">--</span>
                <span v-else class="modal-label">{{ selected.last_login_at | moment }}</span>
              </el-form-item>
              <el-form-item label="Date Updated:">
                <span class="modal-label">{{ selected.updated_at | moment }}</span>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item label="Last Login IP:">
                <span v-if="selected.last_login_ip === '' || selected.last_login_ip === null" class="modal-label">--</span>
                <span v-else class="modal-label">{{ selected.last_login_ip }}</span>
              </el-form-item>
              <el-form-item label="Created At:">
                <span class="modal-label">{{ selected.created_at | moment }}</span>
              </el-form-item>
            </el-col>
          </el-col>
        </div>

        <el-divider></el-divider>

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
              <el-form-item prop="" label="Password:">
                <el-input type="password" v-model="selected.password" clearable></el-input>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="password_confirmation" label="Confirm Password:" label-width="200">
                <el-input type="password" v-model="selected.password_confirmation" clearable></el-input>
              </el-form-item>
            </el-col>
          </el-col>
          <el-col :span="24">
            <el-col :span="12">
              <el-form-item label="Is Active:">
                <el-switch v-model="isactive"></el-switch>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item label="Role">
                <el-select v-model="role_name" placeholder="Select">
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
        </div>
        
        <div>
          <el-col :span="24">
            <hr>
          </el-col>
          
          <el-col :span="24">
            <el-col :xs="24" :sm="24" :md="24" :lg="9" :xl="9">
              <el-form-item label="Can Edit Profile:">
                <el-switch v-model="permissions.profile_update"></el-switch>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="9" :xl="9">
              <el-form-item prop="avatar" label="Avatar:">
                <!-- <el-input type="file" v-model="image" id="avatar" name="avatar" @change="avatarSelected($event)" accept="image/*" label="Image"></el-input> -->
                <div class="input-file">
                  <el-input ref="file" type="file" v-model="image" id="avatar" style="display: none;" @change="avatarSelected($event)" accept="image/*" label="Image"></el-input>
                  <el-button slot="trigger" size="small" type="primary"  @click="openAttachment()">Click to upload</el-button>
                  <div slot="tip" class="el-upload__tip" v-if="!busy" style="line-height: 1.5;">{{ avatar_name ? avatar_name : '' }}</div>      
                </div>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="6" :xl="6" style="text-align: center;">
              <span>
                <img :src="selected.profile.avatar ? selected.profile.avatar : '/img/user2-160x160.jpg'" class="img-circle object-fit_cover" alt="User Image">
              </span>
            </el-col>
          </el-col>

          <el-col :span="24">
            <el-col :xs="24" :sm="24" :md="24" :lg="15" :xl="15">
              <el-form-item prop="name" label="Name:">
                <el-input type="input" v-model="selected.profile.name" clearable></el-input>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="9" :xl="9">
              <el-form-item prop="user_group_id" label="Group:"><br>
                <el-select v-model="selected.profile.user_group_id" placeholder="Select">
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
              <el-input type="textarea" v-model="selected.profile.address" clearable></el-input>
            </el-form-item>
          </el-col>

          <el-col :span="24">
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="sf_id" label="Salesforce ID:">
                <el-input type="input" v-model="selected.profile.sf_id" clearable></el-input>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="employee_id" label="Employee ID:">
                <el-input type="input" v-model="selected.profile.employee_id" clearable></el-input>
              </el-form-item>
            </el-col>
          </el-col>

          <el-col :span="24">
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="region" label="Region:">
                <el-input type="input" v-model="selected.profile.region" clearable></el-input>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="mobile_number" label="Mobile Number:">
                <el-input type="input" v-model="selected.profile.mobile_number" clearable></el-input>
              </el-form-item>
            </el-col>
          </el-col>

          <el-col :span="24">
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="immediate_head" label="Immediate Head:">
                <el-input type="input" v-model="selected.profile.immediate_head" clearable></el-input>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="job_title" label="Job Title:">
                <el-input type="input" v-model="selected.profile.job_title" clearable></el-input>
              </el-form-item>
            </el-col>
          </el-col>

          <el-col :span="24">
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="organization" label="Organization:">
                <el-input type="input" v-model="selected.profile.organization" clearable></el-input>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item prop="branch" label="Branch:">
                <el-input type="input" v-model="selected.profile.branch" clearable></el-input>
              </el-form-item>
            </el-col>
          </el-col>

        </div>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="handleClose(selected)">Cancel</el-button>
        <el-button type="primary" @click="handleSave(selected)">Save</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
  import { Notification } from 'element-ui'
  export default {
  name: "EditUserComponent",
  props: {
    selected: {
      required: true,
      type: Object
    }
  },
  data() {
    return {
      dialogEdit: false,
      title: '',
      password: '',
      confirm_password: '',
      isactive: false,
      // auto_up_on_schedule_end: false,
      newData: {},
      has_error: false,
      error_title: '',
      errors: [],
      roles: [],
      groups: [],
      item: '',
      permissions: {
        profile_update: false
      },
      form: new Form({
        id: '',
        username: '',
        email: '',
        action_id: '',
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
          branch: '',
          address: ''
        }
      }),
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
        ]
      },
      image: null,
      avatar: null,
      uploading: false,
      avatar_name: '',
      busy: false,
      role_name: ''
    }
  },
  filters: {
    moment: function (date) {
      return moment(date).format('lll');
    }
  },
  created: function() {
    if (this.selected.is_active === 0 || this.selected.is_active === false) {
      this.isactive = false
    } else {
      this.isactive = true
    }
    let role_name = '';
    let roles = this.selected.roles;
    for(let r in roles){
      if(r!='chunk'){
        role_name = roles[r].name;
      }
    }
    this.role_name = role_name;
    this.getRoles()
    this.getGroups()
    this.fetchPermissions()
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
    fetchPermissions(){
      let roles = this.selected.roles;
      let profileUpdatePermission = _.find(this.selected.permissions,{'key':'profile_update'});

      let profile_update = false;
      
      for(let r in roles){
        let permissions = roles[r].permissions;
        let hasAll = _.find(permissions,{'name':'*.*,create,view,update,delete,restore,force_delete'});
        let hasProfileUpdate = _.find(permissions,{'key':'profile_update'});
        if(hasAll || hasProfileUpdate){
          profile_update = true;
        }
      }
      
      if(profileUpdatePermission){
        profile_update = true;
      }

      this.permissions.profile_update = profile_update;
    },
    closeAlert() {
      this.has_error = false
      this.error_title = ''
      this.errors = []
    },
    handleSave(selected){
      this.$refs.ruleForm.validate((valid) => {
        if (valid) {
          this.form.fill(selected)
          this.uploading = true;
          if (this.isactive === false) { // convert switch value from true/false to int
            this.form.is_active = 0
          } else {
            this.form.is_active = 1
          }

          // if (this.form.name === '') { // message validator
          //   this.$message.error('Name is Required');
          //   return
          // }
          if (this.form.username === '') { // notification_display_datetime validator
            this.$message.error('User Name is Required');
            return
          }
          if (this.form.email === '') { // notification_display message validator
            this.$message.error('Email is Required');
            return
          }
          this.form.password = selected.password
          this.form.role_name = this.role_name
          this.form.password_confirmation = selected.password_confirmation
          this.form.profile.avatar = this.avatar;
          this.form.permissions = this.permissions;
          var id = Number(this.form.id)

          this.form.post('/user/edit/' + id)
            .then((response) => {
              let stat = response.data.status;
              Notification[stat]({
                title: stat.charAt(0).toUpperCase() + stat.slice(1),
                message: response.data.message,
                duration: 4 * 1000
              });
              this.handleClose()
            })
            .catch(error => {
              this.has_error = true
              this.error_title = error.response.data.message
              this.errors = error.response.data.errors
            })
        } else {
          console.log('error submit!!')
          return false;
        }
      })
    },
    show() {
      this.dialogEdit = true
      this.title = 'Edit User Details'
    },
    handleClose(selected) {
      this.$refs.ruleForm.resetFields();
      this.uploading = false;
      this.$emit('changed')
      this.dialogEdit = false
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
    },
  }
}
</script>

<style scoped>
</style>
