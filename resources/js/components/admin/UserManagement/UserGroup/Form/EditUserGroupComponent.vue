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
        </div>
        
        <div>
          <el-form-item prop="name" label="Name:" required>
            <el-input type="input" v-model="selected.name" clearable></el-input>
          </el-form-item>
          <el-form-item prop="description" label="Description:" required>
            <el-input type="input" v-model="selected.description" clearable></el-input>
          </el-form-item>
          <el-col :span="24">
            <el-col :span="12">
              <el-form-item label="Is Active:">
                <el-switch v-model="isactive"></el-switch>
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
  name: "EditUserGroupComponent",
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
      isactive: false,
      newData: {},
      has_error: false,
      error_title: '',
      errors: [],
      form: new Form({
        id: '',
        name: '',
        description: '',
        is_active: '',
      }),
      rules: {
        name: [
          { required: true, message: 'Name required'},
          { min: 3, message: 'Length should be more than 3'}
        ],
        description: [
          { required: true, message: 'Description required'}
        ]
      }
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
  },
  methods: {
    closeAlert() {
      this.has_error = false
      this.error_title = ''
      this.errors = []
    },
    handleSave(selected){
      this.$refs.ruleForm.validate((valid) => {
        if (valid) {
          this.form.fill(selected)

          if (this.isactive === false) { // convert switch value from true/false to int
            this.form.is_active = 0
          } else {
            this.form.is_active = 1
          }

          if (this.form.name === '') { // message validator
            this.$message.error('Name is Required');
            return
          }
          if (this.form.description === '') { // notification_display_datetime validator
            this.$message.error('Description Name is Required');
            return
          }
          var id = Number(this.form.id)

          this.form.post('/user-group/edit/' + id)
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
      this.title = 'Edit User Group Details'
    },
    handleClose(selected) {
      this.$refs.ruleForm.resetFields();
      this.$emit('changed')
      this.dialogEdit = false
    }
  }
}
</script>

<style scoped>

</style>
