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
import FooterComponent from './FooterComponent'
  export default {
    name: 'ContentComponent',
    components: {
      FooterComponent
    }
  }
</script>

<style lang="scss" scoped>

</style>