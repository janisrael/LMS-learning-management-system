<template>
  <div>
    dash
    <el-button @click="logout()">logout</el-button>
  </div>
</template>

<script>
  export default {
    name: 'DashboardComponent',
    methods: {
      logout() {
        axios.post('logout').then (res => {
          localStorage.removeItem('user_token');
          this.$router.go('/login');
        })
        
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>