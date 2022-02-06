<template>
  <div>
      <div class="content-wrapper">
          <vue-page-transition name="fade-in-right">
            <router-view :route="currentRoute" :currentRoute_name="currentRoute_name"></router-view>
          </vue-page-transition>
        <vue-progress-bar></vue-progress-bar>
      </div>
      <transition name="fade" mode="out-in" duration="1000">
        <div>
          <FooterComponent :me="userdetails"></FooterComponent>
        </div>
      </transition>
    </div>
</template>

<script>
import FooterComponent from './FooterComponent'
  export default {
    name: 'ContentComponent',
    components: {
      FooterComponent
    },
    props: {
      allowed_views: {
        required: false,
        type: Array
      },
      userdetails: {
        required: false,
        type: Object
      }
    },
    data() {
      return {
        routes: this.$routers,
        currentRoute: this.$route.fullpath,
        currentRoute_name: 'Courses',
        new_routes: []
      }
    },
    created () {
      this.mapRoutes()
    },
    methods: {
      mapRoutes() {
        // let new_route = []
        // this.routes.forEach((value, i) => {
        //   if(value.type === 'page') {
        //     new_route.push(value)
        //   }
        // })
        // this.new_routes = new_route
        // console.log(this.new_routes)
        
          // var str =this.$route.path
          // var x = str.substring(str.lastIndexOf('/')+1)
          // var res = x.replace("-", " ");
          // if(res !== 'login') {
          //  this.currentRoute_name = res
          // } else {
          //   console.log(res, 'kkk')
        
          // } 
        }
    },
  }
</script>

<style lang="scss" scoped>

</style>