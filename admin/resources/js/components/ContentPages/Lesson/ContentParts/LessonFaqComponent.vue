<template>
  <div style="display: block; width: 90%; margin: 0 auto !important;">
    <el-col :span="24">  
      <el-col :span="20">
        <el-table
        :data="faqs"
        stripe
        border
        style="width: 100%">
        <el-table-column
          type="index"
          label="#"
          width="50">
        </el-table-column>
        <el-table-column
          prop="question"
          label="Question"
          width="180">
        </el-table-column>
        <el-table-column
          prop="answer"
          label="Answer">
        </el-table-column>
        <el-table-column
          prop="action"
          label="Action"
          fixed="right"
          width="120">
          <el-button-group>
            <el-button type="primary" plain icon="el-icon-edit" size="tiny"></el-button>
            <el-button type="danger" plain icon="el-icon-delete" size="tiny"></el-button>
          </el-button-group>
        </el-table-column>

        </el-table>
      </el-col>
      <el-col :span="4">
        <div style="display: block; padding-left: 20px;">
          <el-button 
            type="primary" 
            size="small" 
            plain 
            @click="dialogVisible = true">
            Add Question
          </el-button>
        </div>
      </el-col>
    </el-col>
     <el-dialog
      title="New Question"
      :visible.sync="dialogVisible"
      width="30%"
      :before-close="handleClose">
      <div>
      <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px" class="demo-ruleForm">
        <el-form-item label="Question" prop="question">
          <el-input v-model="ruleForm.question" style="text-transform: capitalize !important; "></el-input>
        </el-form-item>
        <el-form-item label="Answer" prop="answer">
          <el-input v-model="ruleForm.answer" type="textarea" style="text-transform: capitalize !important;"></el-input>
        </el-form-item>
      </el-form>
        <!-- <el-input placeholder="Question" v-model="question"></el-input>
        <el-input type="text" placeholder="Answer" v-model="answer"></el-input> -->
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">Cancel</el-button>
        <el-button type="primary" @click="submitForm('ruleForm')">Confirm</el-button>
      </span>
    </el-dialog>

  </div>
</template>

<script>
  export default {
    name: 'LessonFaqComponent',
    data() {
      return {
        faqs: [],
        question: '',
        answer: '',
        ruleForm: {
          'question': '',
          'answer': ''
        },
        rules: {
          question: [
            { required: true, message: 'Please input Question', trigger: 'blur' },
          ],
          answer: [
            { required: true, message: 'Please input Answer', trigger: 'blur' }
          ]
        },
        dialogVisible: false
      }
   },
   created() {
     
   },
   methods: {
      handleClose() {
        console.log('close')
        this.ruleForm = {}
        this.dialogVisible = false
      },
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            this.faqs.push(this.ruleForm)
            this.$emit('setFaqs', this.faqs)
            this.ruleForm = {}
            this.dialogVisible = false
          } else {
            console.log('error submit!!');
            return false;
          }
        })
      },
      resetForm(formName) {
        this.ruleForm = {}
        this.dialogVisible = false
      }
   },
  }
</script>

<style scoped>

</style>