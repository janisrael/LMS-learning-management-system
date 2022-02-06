<template>
  <div>
    <el-dialog
      :title="title"
      :visible.sync="dialogEdit"
      v-if="!busy&&Object.keys(selected.profile).length>0"
      width="60%"
      top="2vh"
      :before-close="handleClose"
      >

      <el-form :model="selected" ref="ruleForm" :rules="rules" label-width="170" label-position="left" class="demo-ruleForm">
        <template v-if="editing">
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

          <el-col :span="24"> 
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item label="Username:">
                <span class="modal-label">{{ selected.username }}</span>
              </el-form-item>
              <el-form-item label="Email:">
                <span class="modal-label">{{ selected.email }}</span>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
              <el-form-item label="Status:">
                <span class="modal-label">{{ selected.is_active ? 'Active' : 'Inactive' }}</span>
              </el-form-item>
              <el-form-item label="Roles">
                <span class="modal-label" v-for="item in selected.roles">{{ item.name }}</span>
              </el-form-item>
            </el-col>
          </el-col>

        </div>

        <el-divider></el-divider>

        <div>
          <el-col :span="24">
            <!-- <el-col :xs="24" :sm="24" :md="24" :lg="9" :xl="9">
              <el-form-item label="Can Edit Profile:">
                <el-switch v-model="can_edit_profile"></el-switch>
              </el-form-item>
            </el-col> -->
            <el-col :xs="24" :sm="24" :md="24" :lg="18" :xl="18">
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
                <el-select v-model="item" placeholder="Select" @change="getGroup(item)">
                  <el-option
                    v-for="item in groups"
                    :key="item.name"
                    :label="item.name"
                    :value="item">
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
        </template>

        <template v-else>
          <div style="text-align: center; margin: 1px; padding: 5px;">
            <img :src="selected.profile.avatar ? selected.profile.avatar : '/img/user2-160x160.jpg'" class="img-circle object-fit_cover" alt="User Image">
            <el-button v-if="can_edit_profile" class="float-right" type="primary" @click="handleEdit()"><i class="el-icon-edit"></i> Edit</el-button>
            <br><br>
          </div>
          <div>
            <table width="100%">
              <tr>
                <th width="18%">Username:</th>
                <td width="32%">{{ selected.username }}</td>
                <th width="18%">Email:</th>
                <td width="32%">{{ selected.email }}</td>
              </tr>
              <tr>
                <th>Status:</th>
                <td>
                  <el-tag v-if="selected.is_active === '0' || selected.is_active === 0" type="danger" size="small" effect="dark">Inactive</el-tag>
                  <el-tag v-if="selected.is_active === '1' || selected.is_active === 1" type="success" size="small" effect="dark">Active</el-tag>
                </td>
                <th>Role:</th>
                <td><span v-for="role in selected.roles">{{ role.name }}</span></td>
              </tr>
              <tr><td colspan="4">-</td></tr>
              <tr>
                <th>Name:</th>
                <td>{{ selected.profile.name }}</td>
                <th>Group:</th>
                <td>
                  {{ (selected.profile.group!='' && selected.profile.group!=null) ? selected.profile.group.name : '' }}
                </td>
              </tr>
              <tr>
                <th>Address:</th>
                <td colspan="3">{{ selected.profile.address }}</td>
              </tr>
              <tr>
                <th>Region:</th>
                <td>{{ selected.profile.region }}</td>
                <th>Mobile Number:</th>
                <td>{{ selected.profile.mobile_number }}</td>
              </tr>
              <tr>
                <th>Salesforce ID:</th>
                <td>{{ selected.profile.sf_id }}</td>
                <th>Employee ID:</th>
                <td>{{ selected.profile.employee_id }}</td>
              </tr>
              <tr>
                <th>Immediate Head:</th>
                <td>{{ selected.profile.immediate_head }}</td>
                <th>Job Title:</th>
                <td>{{ selected.profile.job_title }}</td>
              </tr>
              <tr>
                <th>Organization:</th>
                <td>{{ selected.profile.organization }}</td>
                <th>Branch:</th>
                <td>{{ selected.profile.branch }}</td>
              </tr>
              <tr><td colspan="4">-</td></tr>
              <tr>
                <th>Last Login At:</th>
                <td><span v-if="selected.last_login_at === '' || selected.last_login_at === null">--</span>
                <span v-else>{{ selected.last_login_at | moment }}</span></td>
                <th>Last Login IP:</th>
                <td><span v-if="selected.last_login_ip === '' || selected.last_login_ip === null">--</span>
                <span v-else>{{ selected.last_login_ip }}</span></td>
              </tr>
              <tr>
                <th>Date Updated:</th>
                <td><span>{{ selected.updated_at | moment }}</span></td>
                <th>Created At:</th>
                <td><span>{{ selected.created_at | moment }}</span></td>
              </tr>
            </table>
          </div>
        </template>

      </el-form>

      <span slot="footer" class="dialog-footer" v-if="editing">
        <el-button type="success" @click="handleBack()">Back</el-button>
        <el-button @click="handleClose()">Cancel</el-button>
        <el-button type="primary" @click="handleSave(selected)">Save</el-button>
      </span>

      

    </el-dialog>
  </div>
</template>

<script>
  import { Notification } from 'element-ui'
  export default {
  name: "ProfileComponent",
  props: {
    // selected: {
    //   required: true,
    //   type: Object
    // },
    // original: {
    //   required: true,
    //   type: Object
    // }
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
      groups: [],
      datagroup: [],
      form: new Form({
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
      }),
      rules: {
      },
      image: null,
      avatar: null,
      uploading: false,
      editing: false,
      user_group_id: '',
      group: '',
      can_edit_profile: false,
      original_avatar: '',
      avatar_name: '',
      busy: false,
      item: '',
      selected: {
        profile: {}
      }
    }
  },
  filters: {
    moment: function (date) {
      return moment(date).format('lll');
    }
  },
  created: function() {
    this.resetUserDetails();
    // this.validateProfileUpdate();
    // this.getGroups();
  },
  methods: {
    setData(){
      this.busy = true;
      if (this.selected.is_active === 0 || this.selected.is_active === false) {
        this.isactive = false
      } else {
        this.isactive = true
      }
      this.user_group_id = this.selected.profile.user_group_id;
      this.original_avatar = this.selected.profile.avatar;
      if(this.hasGroupName()){
        this.datagroup = this.selected.profile.group 
        this.item = this.selected.profile.group.name
      }
      this.getGroups();
      this.busy = false;
    },
    validateProfileUpdate(){
      this.busy = true;
      let profileUpdate = _.find(this.selected.permissions, {'key': 'profile_update'});
      if(profileUpdate){
        this.can_edit_profile = true;
      }
      this.setData();
      this.busy = false;
    },
    getGroup(value) {
      this.item = value.name
      this.datagroup = value
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
      this.error_title = ''
      this.errors = []
    },
    handleSave(selected){
      this.$refs.ruleForm.validate((valid) => {
        if (valid) {
          this.form.fill(selected.profile)
          this.uploading = true;

          if(this.datagroup.hasOwnProperty('id')){
            this.form.user_group_id = this.datagroup.id
          }
          this.form.avatar = this.avatar;
          var id = this.selected.profile.id;

          this.form.post('/profile/edit/' + id)
            .then((response) => {
              let stat = response.data.status;
              Notification[stat]({
                title: stat.charAt(0).toUpperCase() + stat.slice(1),
                message: response.data.message,
                duration: 4 * 1000
              })    
              this.$emit('changed');          
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
      this.title = 'Profile Account'
    },
    handleClose() {
      console.log("call handle close")
      this.resetUserDetails();
      // this.$refs.ruleForm.resetFields();
      this.uploading = false;
      if(!this.avatar){
        this.selected.profile.avatar = this.original_avatar;
      }
      // this.$emit('changed')
      this.dialogEdit = false
    },
    handleEdit(){
      this.editing = true;
    },
    handleBack(){
      this.resetUserDetails();
      this.editing = false;
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
    hasGroupName(){
      let flag = false;
        if(this.selected.profile.hasOwnProperty('group')){
          if(this.selected.profile.group!='' && this.selected.profile.group!=null){
            flag = true;
          }
        }
      return flag;
    },
    resetUserDetails(){
      this.busy = true;
      var AjaxUrl = "/user-info";
      axios.get(AjaxUrl)
        .then(response => {
          this.selected = response.data;
          console.log("selected",response.data);
          this.validateProfileUpdate();
          this.busy = false;
        }).catch(error => {
        console.log(error.response);
        this.busy = false;
      });
      this.busy = false;
    },
    // handleClose2(done) {
    //   this.$confirm('Are you sure to close this dialog?')
    //     .then(_ => {
    //       done();
    //     })
    //     .catch(_ => {});
    // }
  }
}
</script>

<style scoped>
</style>
