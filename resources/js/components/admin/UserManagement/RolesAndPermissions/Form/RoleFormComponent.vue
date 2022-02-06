<template>
  <div>
    <el-dialog
      :title="title"
      :visible.sync="dialogForm"
      width="60%"
      top="2vh">
      <el-row :gutter="20">
        <el-col :span="24" class="alert-container">
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
      <el-form :model="selected" ref="ruleForm" :rules="rules" label-width="200px" label-position="right" class="demo-ruleForm">
        <div>
          <el-form-item prop="name" label="Role Name:" required>
            <el-input v-model="selected.name" :disabled="type==='add' ? false:true" clearable></el-input>
          </el-form-item>
          <el-form-item prop="guard_name" label="Guard Name:" required>
<!--            <el-input v-model="selected.guard_name" clearable></el-input>-->
              <el-select v-model="selected.guard_name" placeholder="Select">
                <el-option
                  v-for="item in guard_names"
                  :key="item.value"
                  :label="item.value"
                  :value="item.value">
                </el-option>
              </el-select>
          </el-form-item>
          <hr>
          
          <p><b style="color: #67C23A; font-size: 17px;">Permissions:</b></p>
          <el-checkbox style="background-color: #e6ffda;" v-model="checkAll" label="Select/Deselect ALL" border size="medium" @change="togglePermission('all','-','-',$event)"></el-checkbox>
          <br><br>
          <template v-for="(groups, module_name) in modules" v-if="!loading">
            <el-checkbox @change="togglePermission('module',module_name,'-',$event)" v-model="groups.checked">{{module_name}}</el-checkbox><br>
            <template v-for="(items, group_name) in groups.data">
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <el-checkbox @change="togglePermission('group',module_name,group_name,$event)" v-model="items.checked">{{group_name}}</el-checkbox><br>
              <template v-for="item in items.data">
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <el-checkbox v-model="item.checked">{{item.data.name}}</el-checkbox><br>
                <!--  v-model="permissions[item.id]" -->
              </template>
            </template>
          </template>
        </div>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="handleClose()">Cancel</el-button>
        <el-button type="primary" @click="handleSave(selected)">Save</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import {Notification} from "element-ui";

export default {
  name: "AddRoleComponent",
  props: {
    selected: {
      required: false,
      type: Object
    },
    type: {
      required: true,
      type: String
    }
  },
  data() {
    return {
      dialogForm: false,
      loading: false,
      title: '',
      has_error: false,
      currentRoute: 'Dashboard',
      routes: this.$routers,
      newroute: {},
      errors: [],
      error_details: {},
      error_title: '',
      permissions: [],
      modules: [],
      checkAll: false,
      guard_names: [
        {
          value: 'web',
          label: 'web'
        },
        {
          value: 'api',
          label: 'api'
        },
      ],
      rules: {
        name: [
          { required: true, message: 'Name required'},
          { min: 3, message: 'Length should be more than 3'}
        ],
        guard_name: [
          { required: true, message: 'Guard Name required'}
        ]
      },
      form: new Form({
        name: '',
        guard_name: '',
        permissions: []
      })
    }
  },
  created() {
    this.mapRoutes();
    this.getPermissions();
    console.log("created")
  },
  methods: {
    mapRoutes() {
      this.loading = true
      let parentRoute = []
      this.routes.forEach((value, index) => {
        if(value.group !== 'default') {
          parentRoute.push(value)
        }
      })
      // get all parent route unique
      var parents = []
      var userrole = 'SuperAdmin' // static
      parentRoute.reduce((ids, thing) => {
        if (thing.type === 'parent') {
          thing['visible'] = !(userrole === 'Admin' && thing.group === 'usermanagement');
          parents.push(thing);
        }
      }, []);
      var newroute = []
      var item = []
      parents.forEach((pvalue, indexa) => {
        parentRoute.forEach((value, index) => {
          if(value.group === pvalue.group && value.type === 'child' && value.is_title === true) {
            item.push(value)
          }
        })
        var newproute = { parentname: pvalue, children: item }
        item = []
        newroute.push(newproute)
      })

      var filteredRoute = []
      newroute.forEach((value, index) => {
        value.children.forEach((item, index) => {
          filteredRoute.push(item.name.toLowerCase())
        })

      })
      this.loading = false
      this.newroute = filteredRoute

      console.log(this.newroute)
    },
    handleSave(selected) {
      let permissions = [];
      let modules = this.modules;
      for(let m in modules){
        let groups = modules[m].data;
        for(let g in groups){
          let items = groups[g].data;
          for(let i in items){
            let item = items[i].data;
            if(item){
              if(items[i].checked===true){
                permissions.push(item.name);
              }
            }
          }
        }
      }

      if (this.type === 'add') {
        this.$refs.ruleForm.validate((valid) => {
          if (valid) {
            this.$Progress.start()
            this.form.fill(selected)
            console.log(selected)
            this.form.post('/roles-management/create',
              {
                data: {
                  name: selected.name,
                  guard_name: selected.guard_name,
                  permissions: permissions
                }
              })
              .then( response => {
                let stat = response.data.status;
                Notification[stat]({
                  title: stat.charAt(0).toUpperCase() + stat.slice(1),
                  message: response.data.message,
                  duration: 4 * 1000
                });
                // Fire.$emit('AfterCreatedUserLoadIt'); //custom events
                this.$Progress.finish()
                this.handleClose(selected)
              })
              .catch((error) => {
                this.errors = error.response.data.errors
                this.error_title = error.response.data.message
                this.has_error = true
                console.log(error.response.data)
                const h = this.$createElement;
                Notification.error({
                  title: 'Error',
                  message: this.errors ? this.errors.name[0] : '',
                  duration: 4 * 1000
                })
                this.$Progress.finish()
              })
          }
        })
      } else {
        this.$refs.ruleForm.validate((valid) => {
          if (valid) {
            this.$Progress.start()
            this.form.fill(selected)
            var id = Number(selected.id)
            this.form.id = selected.id
            this.form.permissions = permissions;
            console.log("update id",id);
            this.form.put('/roles-management/edit/' + id)
              .then( response => {
                let stat = response.data.status;
                Notification[stat]({
                  title: stat.charAt(0).toUpperCase() + stat.slice(1),
                  message: response.data.message,
                  duration: 4 * 1000
                });
                this.$Progress.finish()
                this.handleClose()
              })
              .catch((error) => {
                this.errors = error.response.data.errors
                this.error_title = error.response.data.message
                this.has_error = true
                const h = this.$createElement;
                this.$message({
                  showClose: true,
                  message: h('p', null, [
                    h('span', null, 'Invalid! '),
                    h('i', { style: 'color: red' }, error.response.data.messages )
                  ]),
                  type: 'error'
                })
                this.$Progress.finish()
              })
          }
        })
      }
    },
    handleClose() {
      this.$refs.ruleForm.resetFields()
      form: new Form({
        name: '',
        guard_name: '',
      }),
        this.$emit('changed')
      this.dialogForm = false
    },
    show() {
      if(this.type === 'add') {
        this.title = 'Add New Roles'
      } else {
        this.title = 'Edit Role'
      }
      this.dialogForm = true
    },
    getPermissions(){
      this.modules = [];
      let id = '-';
      if(this.type !== 'add') {
        id = this.selected.id;
      }
      console.log("my id is",id);
      this.loading = true
      var AjaxUrl = "/permission-management/show/"+id
      axios.get(AjaxUrl)
        .then(response => {
          console.log("respoes",response)
          this.modules = response.data.data;
          this.loading = false
        }).catch(error => {
        this.loading = true
        this.modules = [];
        this.loading = false
      })
    },
    togglePermission(type, module_name, group_name, e){
      this.loading = true;
      let checked = event.target.checked;
      if(type=='group'){
        let items = this.modules[module_name]['data'][group_name]['data'];
        for(let i in items){
          items[i].checked = checked;
        }        
      }
      if(type=='module'){
        let groups = this.modules[module_name]['data'];
        for(let g in groups){
          groups[g].checked = checked;
          for(let i in groups[g].data){
            let item = groups[g].data[i];
            item.checked = checked;
          }
        }
      }
      if(type=='all'){
        let modules = this.modules;
        for(let m in modules){
          modules[m].checked = checked;
          let groups = modules[m].data;
          for(let g in groups){
            groups[g].checked = checked;
            for(let i in groups[g].data){
              let item = groups[g].data[i];
              item.checked = checked;
            }
          }
        }
      }
      this.loading = false;
    },
  }
}
</script>

<style scoped>

</style>
