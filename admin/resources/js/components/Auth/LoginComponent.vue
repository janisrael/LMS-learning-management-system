<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                  <el-form ref="form" :model="form" label-width="120px">
                    <el-form-item label="Email">
                      <el-input v-model="form.email"></el-input>
                    </el-form-item>
                    <el-form-item label="Password">
                      <el-input v-model="form.password"></el-input>
                    </el-form-item>
                   
          
                  </el-form>
                      <el-button type="primary" @click="handleSubmit()">signin</el-button>
                      <el-button @click="removeToken()">Cancel</el-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapActions } from 'vuex'
  export default {
    name: 'LoginComponent',
    data() {
      return {
        form: {
          email: 'mFWtYzXQB4@gmail.com',
          password: 'password'
        }
      }
    },
    computed: {
      my_user() {
        return this.$store.getters.this_user
      },
      my_token() {
        return this.$store.getters.this_token
      }
    },
    created () {
      console.log('asdasdffgg')
      this.$store.dispatch('attempt', localStorage.user_token)
      // this.handleSubmit()
    },
    methods: {
      ...mapActions({
        signIn: 'api/v1/user/login'
        // : 'api/v1/user/login'
      }),
      handleSubmit() {
        
        console.log('asd')
        this.$store.dispatch('signIn', this.form)
      },
      removeToken() {
        axios.post('logout').then (res => {
          localStorage.removeItem('user_token');
          this.$router.go('/login');
        })
      }
    }
  }
</script>
