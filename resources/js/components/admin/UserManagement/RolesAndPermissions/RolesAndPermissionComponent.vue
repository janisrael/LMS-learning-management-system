<template>
  <el-col :span="24">
    <el-col :span="24" class="content-margin">
      <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
        <el-card class="box-card layout-card">
          <div slot="header" class="clearfix" style="padding-top: 5px !important;">
            <span>Roles</span>
            <el-button type="success" size="mini" @click="handleAddRole()" style="float:right"><i class="el-icon-plus"></i></el-button>
          </div>
          <div class="card-content">
            <div v-if="no_access === false">
            <template>
              <el-table
                v-loading="loading"
                :data="data"
                highlight-current-row
                border
                style="width: 100%; cursor: pointer;"
                @row-click="handleSelect">
                <el-table-column
                  prop="name"
                  sortable
                  label="Name"
                  min-width="150">
                </el-table-column>
                <el-table-column
                  prop="guard_name"
                  label="Guard Name"
                  min-width="200">
                </el-table-column>
                <el-table-column
                  prop="created_at"
                  sortable
                  label="Date Created"
                  width="150">
                  <template slot-scope="scope">
                    <span>{{ scope.row.created_at | moment }}</span>
                  </template>
                </el-table-column>
                <el-table-column
                  prop="updated_at"
                  sortable
                  label="Date Updated"
                  width="150">
                  <template slot-scope="scope">
                    <span>{{ scope.row.updated_at | moment }}</span>
                  </template>
                </el-table-column>
                <el-table-column
                  label="Action"
                  fixed="right"
                  width="160">
                  <template slot-scope="scope">
                    <el-button-group>
                      <el-button type="success" size="mini" @click="handleSelect(scope.row)"><i class="far fa-eye"></i></el-button>
                      <el-button v-if="scope.row.name !== 'Super Admin'" type="primary" size="mini" @click="handleEditRole(scope.row, scope.$index)"><i class="el-icon-edit"></i></el-button>
                      <el-button v-if="scope.row.name !== 'Super Admin' && scope.row.name !== 'Admin'" type="danger" size="mini" @click="handleDeleteRole(scope.row, scope.$index)"><i class="el-icon-delete"></i></el-button>
                    </el-button-group>
                  </template>
                </el-table-column>
              </el-table>
            </template>
            </div>
            <div v-else>
              <el-tag type="danger">{{ no_access_msg }}</el-tag>
            </div>
          </div>
        </el-card>
      </el-col>
      <el-col v-if="permission_title" :span="16">
        <el-card class="box-card layout-card">
          <div slot="header" class="clearfix" style="padding-top: 5px !important;">
            <span>Permissions : <span style="color: #67C23A;">{{ permission_title }}</span></span>
<!--            <el-button type="danger" plain icon="el-icon-close" size="mini" style="float:right;" circle @click="handleClosePermissions()"></el-button>-->
            <!-- <el-button type="success" icon="el-icon-plus" size="mini" style="float:right;"  @click="handleAddPermissions()"></el-button> -->
          </div>
          <div  class="card-content">
            <div v-if="no_access === false">
            <template>
              <el-table
                v-loading="loading"
                :data="permissions"
                border
                style="width: 100%">
                
                <el-table-column
                  prop="attributes.is_allowed"
                  label="Allow"
                  min-width="80">
                  <template slot-scope="scope">
                    <el-switch v-model="scope.row.attributes.is_allowed" :disabled="scope.row.attributes.edit" class="permission_switch"></el-switch>
                  </template>
                </el-table-column>

                <el-table-column
                  prop="permission.label"
                  sortable
                  label="Label:"
                  width="250">
                </el-table-column>

                <el-table-column
                  prop="permission.name"
                  sortable
                  label="Access to:"
                  width="250">
                </el-table-column>

                <el-table-column
                  prop="permission.description"
                  sortable
                  label="Description:"
                  width="250">
                </el-table-column>

                <el-table-column
                  prop="permission.module"
                  sortable
                  label="Module:"
                  width="250">
                </el-table-column>

                <el-table-column
                  label="Action"
                  fixed="right"
                  width="90">
                  <template slot-scope="scope">
                    <span v-if="permission_title !== 'SuperAdmin'">
                    <el-button-group v-if="scope.row.attributes.edit === false">
                      <el-button :type="types[scope.$index]" size="mini" @click="handleEditPermission(scope.row, scope.$index, scope.row.attributes.edit = false)">Update</el-button>
                    </el-button-group>
                    <el-button-group v-else>
                      <el-button :type="types[scope.$index]" size="mini" @click="handleEditPermission(scope.row, scope.$index, scope.row.attributes.disabled === true)">Edit</el-button>
                    </el-button-group>
                    </span>
                  </template>
                </el-table-column>
                
              </el-table>
            </template>
            </div>
            <div v-else>
              <el-tag type="danger">{{ no_access_msg }}</el-tag>
            </div>
          </div>
        </el-card>
      </el-col>
    </el-col>
    <component ref="modalComponent" :is="currentComponent" :selected="passData" :type="type" :permissions="permissions" :roleId="my_role_id" @changed="emitChange()" @select_click="handleSelectAfterAddPermission()"/>
  </el-col>
</template>

<script>
import { Notification } from 'element-ui'
import RoleFormComponent from "./Form/RoleFormComponent";
import CreatePermissionComponent from "./Form/CreatePermissionComponent"
export default {
  name: "RolesAndPermissionComponent",
  components: {
    RoleFormComponent,
    CreatePermissionComponent
  },
  data() {
    return {
      tabledata: [],
      currentComponent: null,
      loading: false,
      colwidth: 200,
      ecolwidth: 200,
      data: [],
      total: 0,
      no_access: false,
      no_access_msg: '',
      permissions: [],
      types: [],
      btnupdate: 'Edit',
      disabled: true,
      passData: {},
      type: '',
      permission_title: '',
      form: new Form({
        name: '',
        guard_name: ''
      }),
      my_role_id: '',
      temp_row: {}
    }
  },
  filters: {
    moment: function (date) {
      return moment(date).format('lll');
    }
  },
  created() {
    this.getRecords()
    // this.types = 'primary'
  },
  methods: {
    handleAddPermissions() {
      this.currentComponent = CreatePermissionComponent
      this.passData = this.permissions
      setTimeout(() => this.ex_call_modal_permission(), 1)
    },
    ex_call_modal_permission() {
      this.$refs.modalComponent.show(this.my_role_id)
    },
    handleClosePermissions() {
      this.permissions = []
      this.permission_title = ''
    },
    emitChange() {
      this.currentComponent = null
      this.passData = {}
      this.type = ''
      this.getRecords()
    },
    handleAddRole() {
      this.type = 'add'
      this.currentComponent = RoleFormComponent
      setTimeout(() => this.ex_call_modal(), 1)
    },
    ex_call_modal() {
      this.$refs.modalComponent.show(this.permissions)
    },
    filterTag() {
      console.log('test')
    },
    handleEditRole(row,index) {
      this.type = 'edit'
      this.passData = row
      this.currentComponent = RoleFormComponent
      setTimeout(() => this.ex_call_modal(), 1)
    },
    handleDeleteRole(row, index) {
      this.$confirm('Are you sure you want to delete this Role?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(() => {
        var AjaxUrl = "/roles-management/delete/";
        axios.get(AjaxUrl + row.id)
          .then((response)=> {
            let stat = response.data.status;
            Notification[stat]({
              title: stat.charAt(0).toUpperCase() + stat.slice(1),
              message: response.data.message,
              duration: 4 * 1000
            });
            this.getRecords();
          }).catch(() => {
        })
      }).catch(() => {
        // this.$message({
        //   type: 'info',
        //   message: 'Delete canceled'
        // });
      });
    },
    handleEditPermission(row, index) {
      if(row.attributes.edit === false) {
        this.btnupdate = 'Update'
        this.permissions[index].attributes.edit = true
        this.types[index] = 'primary'
        this.handleUpdate(row, index)
      } else {
        this.btnupdate = 'Edit'
        this.types[index] = 'success'
        this.permissions[index].attributes.edit = false
      }
    },
    handleUpdate(row) {
      axios.put('/permission-management/edit/' + row.permission.id, {
          role_id: row.attributes.role_id,
          is_allowed: row.attributes.is_allowed
      })
        .then(function (response) {
          let stat = response.data.status;
          Notification[stat]({
            title: stat.charAt(0).toUpperCase() + stat.slice(1),
            message: response.data.message,
            duration: 4 * 1000
          });
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    handleSelectAfterAddPermission() {
      this.currentComponent = null
      this.passData = {}
      this.handleSelect(this.temp_row)
    },
    handleSelect(row) {
      this.temp_row = row
      this.my_role_id = row.id
      this.permission_title = row.name
      this.loading = true
      var AjaxUrl = "/roles-management/show/" + row.id;
      axios.get(AjaxUrl)
        .then(response => {
          var p = response.data.permissions // add data to the response
          var rp = response.data.permissionsInRole;
          let permissions = [];

          for(let i in p){
            permissions[i] = {
              permission: p[i],
              rolesInPermission: {},
              attributes: {
                edit: true,
                role_id: row.id,
                is_allowed: false
              }
            }
            
            let rolesInPermission = _.find(rp,{'id':p[i].id});
            if(rolesInPermission){
              permissions[i].rolesInPermission = rolesInPermission;
              permissions[i].attributes.is_allowed = true;
            }
          }

          this.permissions = permissions;
          this.loading = false
        }).catch(error => {
        this.loading = true
        this.permissions = []
        this.no_access = true
        this.no_access_msg = error.response
        this.loading = false
      })
    },
    getRecords() {
      var AjaxUrl = "/roles-management";
      axios.get(AjaxUrl)
        .then(response => {
          if(response.data.status === 'error') {
            this.$router.push({name: 'error.403'});
          } else {
            this.data = response.data.data; // add data to the response
            this.total = response.data.recordsTotal
          }
          this.loading = false
        }).catch(error => {
        this.no_access = true
        this.no_access_msg = error.response.data.message
        this.loading = false
      })
    },
  }

}
</script>

<style scoped>

</style>
