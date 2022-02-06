<template>
  <div>
    <footer class="main-footer">
      <strong>&copy; {{ new Date().getFullYear() }} <a href="/"></a>APP MNAME.</strong>
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
    name: 'FooterComponent'
  }
</script>

<style lang="scss" scoped>

</style>