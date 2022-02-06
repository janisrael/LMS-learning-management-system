<template>
  <el-dialog
    :title="title"
    :visible.sync="dialogForm"
    width="43%"
    top="2vh">
    <div class="clearfix">
      <el-col :span="24">
        <el-col :span="24" class="content-margin">
          <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
            <el-form :model="selected" ref="ruleForm" :rules="rules" label-width="200" class="demo-ruleForm">
              <div>
                <el-form-item prop="name" label="Module Name:" required>
<!--                  <el-input type="input" v-model="selected.name" clearable></el-input>-->
                  <el-select v-model="selected.name" placeholder="Select Module to Add Permission" filterable clearable style="width: 500px;">
                    <el-option
                      v-for="item in available_permission"
                      :key="item.name"
                      :label="item.name"
                      :value="item.name">
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="Access Level:" required>
                  <div>
                    <el-checkbox-group v-model="access">
                      <el-checkbox-button label="Create" v-model="create">Create</el-checkbox-button>
                      <el-checkbox-button label="Read" v-model="read">Read</el-checkbox-button>
                      <el-checkbox-button label="Update" v-model="update">Update</el-checkbox-button>
                      <el-checkbox-button label="Delete" v-model="del">Delete</el-checkbox-button>
                    </el-checkbox-group>
<!--                    <el-checkbox v-model="create" size="small" label="Create" border></el-checkbox>-->
<!--                    <el-checkbox v-model="read" size="small" label="Read" border></el-checkbox>-->
<!--                    <el-checkbox v-model="update" size="small" label="Update" border></el-checkbox>-->
<!--                    <el-checkbox v-model="del" size="small" label="Delete" border></el-checkbox>-->
                  </div>
                </el-form-item>
              </div>
              <el-alert
                title="warning alert"
                type="warning"
                description="Module Name, this is where you want to add access to your specific role. Example: Role 'Admin' can Access 'User Accounts' with the permissions 'create, read, update and delete'"
                show-icon>
              </el-alert>
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
</template>

<script>
import {Notification} from "element-ui";

export default {
  name: "CreatePermissionComponent",
  props: {
    permissions: {
      required: true,
      type: Array
    },
    roleId: {
      type: String
    }
  },
  data() {
    return {
      dialogForm: false,
      loading: false,
      title: '',
      selected: {},
      rules: {
        name: [
          { required: true, message: 'Module Name required'}
        ]
      },
      form: new Form({
        name: '',
        guard_name: ''
      }),
      my_role_id: '',
      create: true,
      read: true,
      update: true,
      del: true,
      routes: this.$routers,
      available_permission: [],
      access: [],
      role: this.$store.state.roles[0].name
    }
  },
  created() {
    this.filterRoutes()
    console.log(this.role)
  },
  methods: {
    handleClose() {
      this.$emit('select_click')
    },
    filterRoutes() {
      var parents = []
      this.routes.reduce((ids, thing) => {
        if (thing.is_title === true) {
          if(this.role.toLowerCase() === 'superadmin') {
            parents.push(thing);
          } else {
            if(thing.name.toLowerCase() !== 'roles and permissions' && thing.name.toLowerCase() !== 'user accounts') {
              parents.push(thing);
            }
          }
        // if (thing.is_title === true) {

        }
      }, []);

      // console.log("this.routes",this.routes)
      // console.log("this.parents",parents)
      console.log("this.permissions",this.permissions)

      this.permissions.forEach((value, index) => {
          let removeIndex = parents.map(item => item.name.toLowerCase())
            .indexOf(value.permission.name.toLowerCase());
          parents.splice(removeIndex, 1);
      })
      this.available_permission = parents
    },
    getAvailablePermission(){
      var AjaxUrl = "/roles-management/show/" + row.id;
      axios.get(AjaxUrl)
        .then(response => {
          var per = []
          per = response.data // add data to the response
          per.forEach((value, index) => {
            per[index]['edit'] = true
          })
          this.permissions = per
          this.loading = false
        }).catch(error => {
        this.loading = true
        this.permissions = []
        this.no_access = true
        this.no_access_msg = error.response
        this.loading = false
      })
    },
    handleSave(selected) {

      this.$refs.ruleForm.validate((valid) => {
        if (valid) {
          this.form.fill(selected)
          let access_lvl = ''
          this.access.forEach((value, index) => {
            if(value === 'Create') {
              access_lvl = access_lvl + 'c'
            } else if(value === 'Read') {
              access_lvl = access_lvl + 'r'
            } else if(value === 'Update') {
              access_lvl = access_lvl + 'u'
            } else if(value === 'Delete') {
              access_lvl = access_lvl + 'd'
            }
          })
          if(access_lvl === '') {
            access_lvl = '-'
          }

          console.log(access_lvl)
          this.form.name = selected.name.toLowerCase()
          this.form.guard_name = access_lvl
          this.form.role_id = this.my_role_id
          this.form.post('/permission-management/create')
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
              // this.has_error = true
              // this.error_details = error.response.data
              // this.error_title = error.response.data.message
              // this.errors = error.response.data.errors
              // this.$message.error(errormsg)
              this.$Progress.finish()
            })
        } else {
          console.log('error submit!!')
          return false;
        }
      });
    },
    show(value) {
      this.my_role_id = value
      this.dialogForm = true
      this.title = 'Add Permission to this Role'
    }
  }
}
</script>

<style scoped>

</style>
