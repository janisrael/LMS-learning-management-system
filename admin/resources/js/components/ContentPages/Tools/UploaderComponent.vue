<template>
  <div >
    <el-col :span="24">
      <!-- <el-upload
        v-if="!avatar"
        id="customUploader"
        ref="upload"
        :action="fileUploadPath"
        :on-change="checkFile"
        :on-success="setList"
        :on-remove="removeFile"
        :file-list="fileList"
        :on-error="checkError"
        :multiple="false"
        :headers="headers"
        :auto-upload="false"
        :before-remove="beforeRemove"
        class="upload-demo"
        drag>
        <i class="el-icon-upload" />
        <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
        <div slot="tip" class="el-upload__tip">pdf files with a size less than 3mb</div>
      </el-upload> -->
      <el-upload
        v-if="avatar"
        ref="upload"
        :auto-upload="false"
        :action="fileUploadPath"
        :on-change="checkFile"
        :on-success="setList"
        :on-remove="removeFile"
        :file-list="fileList"
        :on-error="checkError"
        :multiple="false"
        :show-file-list="true"
        list-type="picture-card"
        :limit="1"
        class="avatar-uploader">
          <div ref="triggerButon" class="el-upload__text"></div>
          <i slot="default" class="el-icon-plus"></i>
          <div slot="file" slot-scope="{file}">
            <img
              class="el-upload-list__item-thumbnail"
              :src="file.url" alt=""
            >
            <span class="el-upload-list__item-actions">
              <span
                class="el-upload-list__item-preview"
                @click="handlePictureCardPreview(file)"
              >
                <i class="el-icon-zoom-in"></i>
              </span>
              <span
                v-if="!disabled"
                class="el-upload-list__item-delete"
                @click="removeFile(file)"
              >
                <i class="el-icon-delete"></i>
              </span>
            </span>
          </div>
      </el-upload>
      <span>{{ file }}</span>
      <el-dialog :visible.sync="dialogVisible">
        <img width="100%" :src="dialogImageUrl" alt="">
      </el-dialog>
      
    </el-col>
  </div>
</template>

<script>
export default {
  name: 'UploaderComponent',
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
      default: true
    }
  },
  data() {
    return {
      headers: null,
      acceptedFileTypes: ['application/pdf'],
      avatarAcceptedTypes: ['image/png', 'image/jpg', 'image/jpeg'],
      multipleUpload: false,
      fileList: [],
      fileUploadPath: 'https://lms-admin.app/api/uploads/file',
      saving: false,
      allowed: false,
      attachment_path: this.path,
      file_size_limit: 2097152,
      dialogImageUrl: '',
      dialogVisible: false,
      disabled: false,
      file: ''
    }
  },
  created: function() {
    this.headers = this.$store.getters.headers
    if (this.attachment_path) {
      this.fileList = [{ name: this.attachment_path }]
    }
    if (this.uploadPath) {
      this.fileUploadPath = this.uploadPath
    }
  },
  methods: {
    show() {
      this.$refs.triggerButon.click()
    },
    handleRemove(file) {
      console.log(file);
      console.log(this.fileList)
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handleDownload(file, fileList) {
      console.log(file, fileList);
    },
    handleEditFile(file) {
      console.log(this.$refs.upload)
      setTimeout(() => {
       
          this.$refs.sampleButton.$el.click();
      }, 300);
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
    removeFile() {
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

    submitFile() {
      // this.$refs.upload.submit()
      // this.$emit('setUrl', this.file)
    }
  }
}
</script>
<style scoped>

</style>