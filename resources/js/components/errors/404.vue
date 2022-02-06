<template>
  <el-col :span="24">
      <el-col :span="24" class="content-margin">
        <el-card class="box-card layout-card">
          <div class="card-content">
            <h1 class="mb-4 text-danger">Page Not Found</h1>
            <p>You are accessing a non-existent page.</p>
            <div class="links">
              <router-link :to="{ name: 'Dashboard' }">Go to dashboard</router-link>
            </div>
          </div>
        </el-card>
      </el-col>

  </el-col>
</template>

<script>
export default {
  name: 'not-found',

  layout: 'default'
}
</script>
