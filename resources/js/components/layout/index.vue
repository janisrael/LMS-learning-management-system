<template>
  <div v-loading="loading" >
    <span style="float:right; display: none;">{{ isIdle }}</span>
    <component 
      ref="asideComponent" 
      :is="asideNullComponent" 
      :route="currentRoute"
      :role="this_roles"
      :permissions="this_permissions"
      :selected="this_userinfo">
      </component>
    <component 
      :is="contentNullComponent" 
      :allowed_views="allowed_views_by_permission" 
      :userdetails="this_userinfo"></component>
    <div id="sidebar-overlay" @click="toogleEvent()"></div>
      <el-dialog
        title="Session Timeout"
        :visible.sync="dialogVisible"
        width="30%"
        :before-close="handleLogout">
        <span>You have been idling for so long!</span>
        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="handleLogout()">Close</el-button>
        </span>
      </el-dialog>
  </div>
</template>
<script>

import AsideComponent from "./AsideComponent";
import ContentComponent from "./ContentComponent";
import IdleVue from "idle-vue";
export default {
  name: "LayoutComponent",
  components: {
    AsideComponent,
    ContentComponent
  },
  computed: {
    isIdle() {
      if(this.$store.state.idleVue.isIdle === true) {
        setTimeout(() => this.handleLogout(), 3000)
        return this.$store.state.idleVue.isIdle
      }
      else {
        return this.$store.state.idleVue.isIdle
      }
    }
  },

  watch: {
    currentRoute: function (newQuestion, oldQuestion) {
      this.assignRoute()
    }
  },
  data() {
    return {
      loading: false,
      dialogVisible: false,
      currentRoute: '',
      userDetails: {},
      permissions: [],
      this_roles: '',
      url: window.ENV.APP_URL,
      countDown : 0,
      allowed_views_by_permission: [],
      this_userinfo: [],
      this_permissions: [],
      asideNullComponent: null,
      contentNullComponent: null
    }
  },
  created: function () {
    this.loading = true;
    this.getUserInfo()
    this.currentRoute = this.$route.path
  },
  methods: {
    async getUserInfo() {
      await this.$store.dispatch('GetInfo', 'permissions').then((response) => {
        console.log(response)
        if(response) {
          this.this_userinfo = response.data
          this.this_permissions = response.data.permissions
          this.this_roles = response.data.roles[0].name
          this.$store.dispatch('GetAuthors', 'ok')
          this.$store.dispatch('GetSubscriptions', 'ok')
          this.$store.dispatch('GetCourses', { term: '', author_id: 1 })
          this.$store.dispatch('GetComponmentState', true)
          this.asideNullComponent = AsideComponent
          this.contentNullComponent = ContentComponent
          this.setAllowedViews()
          this.loading = false;
        }
      })
    },
    handleLogout() {
      var AjaxUrl = "/logout";
      axios.post(AjaxUrl)
        .then(response => {
          window.location.href = this.url + '/login'
        })
    },
    toogleEvent() {
      setTimeout(() => this.getEvent(), 1)
    },
    getEvent() {
      this.$refs.asideComponent.toogleAside()
    },
    assignRoute() {
      this.currentRoute = this.$route.path
    },
    setAllowedViews: function() {
      let permissions = this.permissions
      let allowed_views = []
      permissions.forEach((value, index) => {
        if(value.guard_name !== '-') {
          allowed_views.push(value.name)
        }
      })
      this.allowed_views_by_permission = allowed_views
    }
  }
}
</script>

<style scoped>

</style>
