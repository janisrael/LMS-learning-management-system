<template>
  <div style="display: block; padding-top: 30px; max-width: 80%;">
    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
      <el-form-item label="Video Url" prop="ruleForm.video_url">
       <el-input placeholder="Please input" v-model="ruleForm.video_url" size="medium">
          <template slot="prepend">Https://</template>
        </el-input>
      </el-form-item>
      <el-form-item label="Preview Url" prop="ruleForm.preview">
        <el-input placeholder="Please input" v-model="ruleForm.preview_url" size="medium">
            <template slot="prepend">Https://</template>
          </el-input>
      </el-form-item>
      <!-- <el-form-item>
        <el-button type="primary" @click="submitForm('ruleForm')">Create</el-button>
        <el-button @click="resetForm('ruleForm')">Reset</el-button>
      </el-form-item> -->
    </el-form>
  </div>
</template>

<script>
  export default {
    name: 'LessonVideoComponent',
    data() {
      return {
         ruleForm: {
          video_url: '',
          preview_url: ''
        },
         rules: {
          video_url: [
            { required: true, message: 'Please input Video URL', trigger: 'blur' }
          ],
          preview_url: [
            { required: true, message: 'Please input Preview URL', trigger: 'blur' }
          ],
        }
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>