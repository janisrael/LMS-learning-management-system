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
                    <el-form-item prop="name" label="Name:" required>
                      <el-input type="input" v-model="selected.name" clearable></el-input>
                    </el-form-item>
                    <el-form-item prop="description" label="Description:" required>
                      <el-input type="input" v-model="selected.description" clearable></el-input>
                    </el-form-item>
                    <el-col :span="24" style="padding: 15px 0;">
                      <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                        <el-form-item label="is Active:">
                          <el-switch v-model="isactive"></el-switch>
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
    name: "CreateUserGroupComponent",
    data() {
      return {
        loading: false,
        schedule: [],
        dialogForm: false,
        title: '',
        selected: {},
        isactive: true,
        has_error: false,
        errors: [],
        error_details: {},
        error_title: '',
        form: new Form({
          name: '',
          description: '',
          is_active: ''
        }),
        ruleForm: {
          name: '',
          description: '',
          is_active: true
        },
        rules: {
          name: [
            { required: true, message: 'Name required'},
            { min: 3, message: 'Length should be more than 3'}
          ],
          description: [
            { required: true, message: 'Description required'}
          ],
        },
      }
    },
    created: function() {
      Fire.$on('AfterCreatedUserLoadIt',()=>{ //custom events fire on
        this.handleClose();
      });
    },
    methods: {
      closeAlert() {
        this.has_error = false
        this.errors = []
      },
      handleSave(selected) {
        this.$refs.ruleForm.validate((valid) => {
          if (valid) {
            this.form.fill(selected)
            if(this.isactive === false) { // convert switch value from true/false to int
              this.form.is_active = 0
            } else {
              this.form.is_active = 1
            }
            this.$Progress.start()
            this.form.post('/user-group/create')
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
          name: '',
          username: '',
          description: '',
          is_active: ''
        })
        this.$emit('changed')
      },
      show() {
        this.dialogForm = true
        // this.title = 'Edit Ticket #: ' + this.selected.ticket_no
        this.title = 'Add New User Group'
      },
    }
  }
</script>

<style scoped>

</style>
