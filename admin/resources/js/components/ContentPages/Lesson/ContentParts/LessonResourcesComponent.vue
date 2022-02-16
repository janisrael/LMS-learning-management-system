<template>
  <div style="display: block; width: 90%; margin: 0 auto !important;">
    <el-col :span="24">  
      <el-col :span="20">
        <el-table
        :data="attachments"
        stripe
        border
        style="width: 100%">
        <el-table-column
          type="index"
          label="#"
          width="50">
        </el-table-column>
        <el-table-column
          prop="name"
          label="Name"
          width="180">
        </el-table-column>
        <el-table-column
          prop="path"
          label="Attachment">
        </el-table-column>
        <el-table-column
          prop="address"
          label="Action"
          fixed="right"
          width="120">
            <el-button-group size="tiny">
              <el-button type="primary" plain icon="el-icon-edit" size="tiny"></el-button>
              <el-button type="danger" plain icon="el-icon-delete" size="tiny"></el-button>
            </el-button-group>
        </el-table-column>
          
        </el-table>
      </el-col>
      <el-col :span="4">
        <!-- <el-button type="primary" size="small" plain @click="dialogVisible = true">Add Attachment</el-button> -->
        <div style="display: block; padding-left: 20px;">
          <PDFUploaderComponent
            :path.sync="path"
            :action_from="'lesson'" 
            style="width: 100%"
            @setAttachment="file_url = $event"
            @setFiles="setFiles">
          </PDFUploaderComponent>
        </div>
      </el-col>
    </el-col>
  </div>
</template>

<script>
import PDFUploaderComponent from '../../Tools/PDFUploaderComponent'
  export default {
    name: 'LessonResourcesComponent',
    components: {
      PDFUploaderComponent
    },
    data() {
      return {
        attachments: [],
        path: '',
        file_url:'',
        dialogVisible: false,
        attachment_name: ''
      }
    },
    computed: {
      file_lists() {
        return this.file_url
      }
    },
    watch: {
      attachments(newValue, oldValue) {
        console.log(newValue, oldValue,'watch')
        this.pushData(newValue)
      }
    },
    created () {
    
    },
    methods: {
      setFiles(value) {
        let attachment = {
          'name': value.name,
          'path': value.path
        }
        this.attachments.push(attachment)
      },
      pushData(data) {
        this.$emit('setResource', data)
      },
      open() {
        this.$prompt('Please Input Attachment Name', 'Tip', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          inputPattern: '',
          inputErrorMessage: 'Invalid Email'
        }).then(({ value }) => {
          this.$message({
            type: 'success',
            message: 'Your email is:' + value
          });
        }).catch(() => {
          this.$message({
            type: 'info',
            message: 'Input canceled'
          });       
        });
      }
    },
  }
</script>

<style scoped>

</style>