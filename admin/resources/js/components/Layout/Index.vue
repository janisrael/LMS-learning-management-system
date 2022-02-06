<template>
  <div>

    <div v-if="this.$store.getters.this_login_state === false">
      <login-component></login-component>
    </div>
    <div  v-if="this.$store.getters.this_login_state === true">
      <aside-component></aside-component>
      <content-component></content-component>
    </div>
  </div>
</template>

<script>
import LoginComponent from '../Auth/LoginComponent'
import DashboardComponent from './DashboardComponent.vue'
import AsideComponent from './AsideComponent'
import ContentComponent from './ContentComponent'
// import FooterComponent from './FooterComponent'

  export default {
    components: {
      LoginComponent,
      DashboardComponent,
      AsideComponent,
      ContentComponent,
      // FooterComponent,
    
    },
    name: 'Index',
    data() {
      return {
        routes: this.$routers,
        currentComponent: null
      }
    },
    computed: {

    },
    created () {

    },
    methods: {
  
    }
  }

</script>

<style lang="scss" scoped>

</style>