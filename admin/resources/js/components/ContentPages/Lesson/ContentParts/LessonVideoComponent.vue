<template>
  <div style="display: block; width: 90%; margin: 0 auto !important;">
    <el-form ref="ruleForm4" label-width="120px" class="demo-ruleForm">
      <el-form-item label="Video Url">
       <el-input placeholder="Please input" v-model="ruleForm.video_url" size="medium" @change="handleAddVideo(ruleForm.video_url)">
          <template slot="prepend">Https://</template>
        </el-input>
      </el-form-item>
      <el-form-item label="Preview Url">
        <el-input placeholder="Please input" v-model="ruleForm.preview_url" size="medium" @change="handleAddPreview(ruleForm.preview_url)">
            <template slot="prepend">Https://</template>
          </el-input>
      </el-form-item>
   
    </el-form>
  </div>
</template>

<script>
  export default {
    name: 'LessonVideoComponent',
    props: {
      ruleForm: {
        required: false,

      }
    },
    data() {
      return {
        //  ruleForm: {
        //   video_url: '',
        //   preview_url: ''
        // },
         rules: {
          video_url: [
            { required: true, message: 'Please input Video URL', trigger: 'blur' }
          ],
          preview_url: [
            { required: true, message: 'Please input Preview URL', trigger: 'blur' }
          ],
        },
        video_url: '',
        preview_url: ''
      }
    },
    // computed: {
    //   new_ruleform_video() {
    //     return this.ruleForm.video_url
    //   },
    //   new_ruleform_image() {
    //     return this.ruleForm.preview_url
    //   }
    // },
    methods: {
      handleAddVideo(value) {
        // let newData = this.ruleForm
        this.$emit('setVideo', value)
      },
      handleAddPreview(value) {
        this.$emit('setPreview', value)
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>