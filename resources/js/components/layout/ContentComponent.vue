<template>
  <div>
      <div class="content-wrapper">
        <transition name="fade" mode="out-in">
          <router-view :route="currentRoute" :allowed_views="allowed_views" :userdetails="userdetails" :currentRoute_name="currentRoute_name"></router-view>
        </transition>
        <vue-progress-bar></vue-progress-bar>
      </div>
      <transition name="fade" mode="out-in" duration="1000">
        <div v-if="get_computedstate === true">
         <FooterComponent :me="userdetails"></FooterComponent>
        </div>
      </transition>
    </div>
</template>

<script>
import FooterComponent from "./FooterComponent";
export default {
  name: "ContentComponent",
  components: {
    FooterComponent
  },
  props: {
    allowed_views: {
      required: true,
      type: Array
    },
    userdetails: {
      required: true,
      type: Object
    }
  },
  computed: {
    get_computedstate() {
      return this.$store.getters.componentState
    }
  },
  data() {
    return  {
      currentRoute: this.$route.fullpath,
      currentRoute_name: 'none-none',
      newdata: this.userdetails,
      show: false
    }
  },
  created() {
    // this.$testx = this.selected
    this.getRouteName()
    this.handleResize()
  },
  methods: {
    handleResize() {
      // console.log(window.innerWidth);
      let windowWidth = window.innerHeight
   
      if(windowWidth <= 768) {
        this.colwidth = '180'
      }
      // this.window.height = window.innerHeight;
    },
    getRouteName() {
      var str =this.$route.path
      var x = str.substring(str.lastIndexOf('/')+1)
      var res = x.replace("-", " ");
      this.currentRoute_name = res
    }
  }
}
</script>

<style scoped>

</style>
