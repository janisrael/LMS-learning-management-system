<template>
<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="display: block;">
    <!-- Left navbar links -->

    <ul class="navbar-nav">
      <li class="nav-item">
        <a id="toogleclick" class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

      <!-- <el-page-header @back="goBack" :content="currentRoute">
        <i class="el-icon-back"></i>
      </el-page-header> -->
      <!-- <span style="font-size: 14px;color: #3031336e;font-weight: 200; padding-left: 5px;">  /  {{ this_componentName }} </span> -->

    <!-- Right navbar links -->
    
    <div class="navbar-right-wrapper">
      <i class="fas fa-bell"></i>
      <el-popover
        placement="bottom"
        width="400"
        trigger="click">
           <div class="md-layout-item md-medium-size-100 md-size-33">
             <div class="md-card md-card-profile md-theme-default"><div class="md-card-avatar"><img src="https://demos.creative-tim.com/vue-material-dashboard-pro/img/faces/marc.jpg" class="img"></div><div class="md-card-content"><h6 class="category text-gray">CEO / Co-Founder</h6><h4 class="card-title">Alec Thompson</h4><p class="card-description"> Don't be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is... </p><button type="button" class="md-button md-round md-theme-default md-success"><div class="md-ripple"><div class="md-button-content">Follow</div> </div></button></div></div>
          </div>
        <el-button slot="reference" size="mini"><i class="fas fa-user"></i> Jan</el-button>
      </el-popover>
    </div>
    <ul class="navbar-nav ml-auto">
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <img :src="hasAvatar() ? me.profile.avatar : '/img/user2-160x160.jpg'" class="user-image object-fit_cover" alt="User Image">
            &nbsp;&nbsp;test <i class="fas fa-caret-down"></i>
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
                <span >
                  <!-- {{ role.name }} -->
                  role
                </span>
              </p>
              <!-- <p v-if="hasGroupName()">
                ( {{ me.profile.group.name }} )
              </p> -->
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
    <!-- <component ref="modalComponent" :is="currentComponent" @changed="emitChange()"/> -->
  </nav>
</template>

<script>
  export default {
    name: 'NavbarComponent',
    props:{
      route: {
        required: false,
        type: String
      },
      me: {
        required: false,
        type: Object
      }
    },
    data() {
      return {
        loading: false
      }
    },
    methods: {
      handleLogout() {
        // axios.post('logout').then (res => {
        //   localStorage.removeItem('user_token');
        //   this.$router.go('/login');
        //   this.$router.push('login')
      // })
        this.$store.dispatch('handleLogout')
      },
      hasProfileName(){
        let flag = false;
        // if(this.me.hasOwnProperty('profile')){
        //   if(this.me.profile!=null && this.me.profile.hasOwnProperty('name')){
        //     flag = true;
        //   }
        // }
        return flag;
      },
      hasAvatar(){
        let flag = false;
        // if(this.hasProfileName()){
        //   if(this.me.profile.avatar!='' && this.me.profile.avatar!=null){
        //     flag = true;
        //   }
        // }
        return flag;
      }, 
    },
  }
</script>

<style lang="scss" scoped>
.el-page-header__content {
    font-size: 14px;
    color: #3031336e;
    font-weight: 200;
}
.navbar-right-wrapper {
  display: inline-block;
  float: right;
  padding: 10px;
  position: relative;
}
</style>