<template>
  <div>
    <footer class="main-footer">
      <strong>&copy; {{ new Date().getFullYear() }} <a href="/"></a>{{ appname }}.</strong>
      <div style="display: block; float: right; padding: 5px;">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>Last Logged in at {{ me.prev_log_in }}</el-breadcrumb-item>
          <el-breadcrumb-item>{{ me.last_login_ip }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
    </footer>
  </div>
</template>

<script>
  export default {
    name: 'FooterComponent'
  }
</script>

<style lang="scss" scoped>

</style>