<template>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->

    <ul class="navbar-nav">
      <li class="nav-item">
        <a id="toogleclick" class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

      <el-page-header @back="goBack" :content="currentRoute">
        <i class="el-icon-back"></i>
      </el-page-header>
      <span style="font-size: 14px;color: #3031336e;font-weight: 200; padding-left: 5px;">  /  {{ this_componentName }} </span>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <img :src="hasAvatar() ? me.profile.avatar : '/img/user2-160x160.jpg'" class="user-image object-fit_cover" alt="User Image">
            &nbsp;&nbsp;{{ me.username }} <i class="fas fa-caret-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header" style="padding: 20px; background-color: #343a40;">
            <!-- Logged in as
            <span v-for="role in me.roles">
              {{ role.name }}
            </span> -->
            <img :src="hasAvatar() ? me.profile.avatar : '/img/user2-160x160.jpg'" class="img-circle object-fit_cover" alt="User Image">
              <p style="margin-bottom: 0; font-size: 17px; color: #fff;" v-if="hasProfileName()">
                  {{ me.profile.name }}
              </p>
              <p style="font-size: 13px; margin-top: 0; color: #a0e047;">
                <!-- {{ me.role.name }} -->
                <span v-for="role in me.roles" :key="role.name">
                  {{ role.name }}
                </span>
              </p>
              <p v-if="hasGroupName()">
                ( {{ me.profile.group.name }} )
              </p>
          </span>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" @click="handleProfile()" style="text-align: center; background-color: #9fd346; color: #ffffff;">
            <span type="primary"><i class="fas fa-user-circle"></i> Profile</span>
          </a>
          <a class="dropdown-item" @click="handleLogout()" style="text-align: center;" >
            <span type="primary"><i class="fas fa-sign-out-alt"></i> Logout</span>
          </a>
        </div>
      </li>
    </ul>
    <component ref="modalComponent" :is="currentComponent" @changed="emitChange()"/>
  </nav>
</template>

<script>
  import ProfileComponent from "./ProfileComponent";
  export default {
  name: "NavBarComponent",
  components: {
    ProfileComponent
  },
  props:{
    route: {
      required: true,
      type: String
    },
    me: {
      required: true,
      type: Object
    }
  },
  data() {
    return {
      currentRoute: this.$route.name,
      url: window.ENV.APP_URL,
      currentComponent: null,
      // this_componentName: this.$store.state.v_component_name
    }
  },
  computed: {
    this_componentName() {
      return this.$store.getters.componentName
    }
  },
  methods: {
    goBack() {

    },
    toogleEvent() {
      const elem = document.getElementById('toogleclick');
      elem.click();
    },
    handleProfile(){
      this.currentComponent = ProfileComponent;
      setTimeout(() => this.ex_call_modal(), 1)
    },
    handleLogout() {
      var AjaxUrl = "/logout";
      axios.post(AjaxUrl)
      .then(response => {
        window.location.href = this.url + '/login'
      })
    },
    ex_call_modal() {
      this.$refs.modalComponent.show()
    },
    hasProfileName(){
      let flag = false;
      if(this.me.hasOwnProperty('profile')){
        if(this.me.profile!=null && this.me.profile.hasOwnProperty('name')){
          flag = true;
        }
      }
      return flag;
    },
    hasGroupName(){
      let flag = false;
      if(this.hasProfileName()){
        if(this.me.profile.hasOwnProperty('group')){
          if(this.me.profile.group!='' && this.me.profile.group!=null){
            flag = true;
          }
        }
      }
      return flag;
    },
    hasAvatar(){
      let flag = false;
      if(this.hasProfileName()){
        if(this.me.profile.avatar!='' && this.me.profile.avatar!=null){
          flag = true;
        }
      }
      return flag;
    }, 
    emitChange() {
      console.log("emit changed")
      this.$emit('changed');
      this.currentComponent = null
      // this.getRecords()
    }
  },
}
</script>

<style scoped>
.el-page-header__content {
    font-size: 14px;
    color: #3031336e;
    font-weight: 200;
}
</style>
