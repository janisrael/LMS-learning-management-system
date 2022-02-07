<template>
  <div>
    <div class="content-wrapper">
      <vue-page-transition name="fade-in-right">
        <router-view
          :route="currentRoute"
          :currentRoute_name="currentRoute_name"
        ></router-view>
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
import FooterComponent from "./FooterComponent";
export default {
  name: "ContentComponent",
  components: {
    FooterComponent,
  },
  props: {
    allowed_views: {
      required: false,
      type: Array,
    },
    userdetails: {
      required: false,
      type: Object,
    },
    routes: {
      required: true,
      type: Array,
    },
  },
  data() {
    return {
      routes: this.$routers,
      currentRoute: this.routes.path,
      currentRoute_name: this.routes.name,
      new_routes: [],
    };
  },
  created() {
    this.mapRoutes();
  },
  methods: {},
};
</script>

<style lang="scss" scoped>
</style>