<template>
  <div style="position: fixed; width: 100%; bottom:0; z-index: 1;">
    <footer class="main-footer">
      <strong>&copy; {{ new Date().getFullYear() }} <a href="/"></a>{{ app_name }}</strong>
      <div style="display: block; float: right; padding: 5px;">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>Last Logged in at </el-breadcrumb-item>
          <el-breadcrumb-item>192.168.1.1</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
    </footer>
  </div>
</template>

<script>
  export default {
    name: 'FooterComponent',
    data() {
      return {
        app_name: window.ENV.APP_NAME
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>