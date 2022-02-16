<template>
  <div>
    <el-upload
      class="upload-pdf"
      ref="upload"
      :action="fileUploadPath"
      :on-preview="handlePreview"
      :on-remove="handleRemove"
      :on-change="checkFile"
      :on-success="setList"
      :before-upload="beforeUpload"
      :before-remove="beforeRemove"
      multiple
      :limit="5"
      :on-exceed="handleExceed"
      :headers="headers"
      :file-list="fileList">
      <el-button size="small" plain type="primary">Add Attachment</el-button>
      <div slot="tip" class="el-upload__tip">PDF files, size less than 10mb</div>
    </el-upload>
    <el-dialog
      title="New Attachment"
      :visible.sync="dialogVisible"
      width="30%"
      :before-close="handleClose">
      <div>
        <el-input placeholder="Please Attachnment Name" v-model="attachment_name" style="text-transform: capitalize;"></el-input>
          <!-- <PDFUploaderComponent
          :path.sync="path"
          style="width: 100%"
          @setAttachment="file_url = $event"
          @setFiles="setFiles">
        </PDFUploaderComponent> -->
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button @click="handleCloseDialog()">Cancel</el-button>
        <el-button type="primary" @click="pushAttachment()">Confirm</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
  export default {
    name: 'PDFUploaderComponent',
    props: {
      path: {
        type: String,
        default: ''
      },
      uploadPath: {
        type: String,
        default: ''
      },
      avatar: {
        type: Boolean,
        default: false
      },
      action_from: {
        type: String
      }
    },
    data() {
      return {
        headers: null,
        acceptedFileTypes: ['application/pdf'],
        avatarAcceptedTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        multipleUpload: false,
        fileList: [],
        fileUploadPath: 'https://e-learning-admin.app/api/v1/uploads/file',
        saving: false,
        allowed: false,
        attachment_path: this.path,
        file_size_limit: 10097152,
        dialogImageUrl: '',
        dialogVisible: false,
        disabled: false,
        file: '',
        dialogVisible: false,
        attachment_name: ''
      }
    },
    created () {
      if(this.action_from === 'lesson') {
        this.fileUploadPath = 'https://e-learning-admin.app/api/v1/uploads/file/lessons/resources'
      }
    },
    methods: {
      handlePreview() {
        console.log('close')
      },
      handleRemove() {
      console.log('close')
      },
      handleExceed(file) {
          console.log(file)
      },
      handleClose() {
        this.attachment_name = ''
        this.dialogVisible = false
      },
      handleChange(file, fileList) {
        this.fileList = fileList.slice(-3);
      },
      checkError(err, file, fileList) {
        console.log(err)
        Notification.error({
          title: 'Error',
          message: 'Unable to upload the file at the moment.',
          duration: 4 * 1000
        })
      },
      beforeRemove(file, fileList) {
        return this.$confirm(`Remove ${file.name} ?`)
      },
      removeFile(file) {
        console.log(this.fileList)
        this.attachment_path = ''
        this.fileList = []
        this.$emit('setAttachment', '')
      },
      setList(response, file, fileList) {
        console.log(file.name)
        if (this.allowed) {
          this.fileList = [file]
          this.attachment_path = response.path
          this.$emit('setAttachment', response.path)
         
        }
      },
      pushAttachment() {
        let value = {
          'path': this.attachment_path ,
          'name': this.attachment_name
        }
        this.$emit('setFiles', value)
        this.fileList = []
        this.dialogVisible = false
      },
      handleCloseDialog() {
        this.fileList = []
        this.attachment_name = ''
        this.attachment_path = ''
        this.dialogVisible = false
      },
      beforeUpload(file) {
        this.dialogVisible = true
      },
      checkFile(file, fileList) {
        this.file = file.name
        var types = []
        if (this.avatar) {
          types = this.avatarAcceptedTypes
        } else {
          types = this.acceptedFileTypes
        }
        if (!this.avatar) {
          this.file_size_limit = 3145728
        }
        if (file.size > this.file_size_limit) {
          this.fileList = []
          this.$message.error(`The file you uploaded exceeds the file size limit.`)
          this.$refs.upload.abort()
          this.allowed = false
        } else if (types.indexOf(file.raw.type) < 0) {
          this.$message.error(`The file type you uploaded is not allowed.`)
          this.$refs.upload.abort()
          this.fileList = []
          this.allowed = false
        } else {
          this.headers = this.$store.getters.headers
          this.allowed = true
          // this.$refs.upload.submit()
          this.$refs.upload.submit()
        }
      },
    },
  }
</script>

<style scoped>

</style>