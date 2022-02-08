<template>
  <div>
    <aside-component :routes="new_routes"></aside-component>
    <content-component :routes="new_routes"></content-component>
  </div>
</template>

<script>
import AsideComponent from "./AsideComponent";
import ContentComponent from "./ContentComponent";
export default {
  name: "MainWrapperComponent",
  components: {
    AsideComponent,
    ContentComponent,
  },
  data() {
    return {
      loading: false,
      new_routes: [],
      collected_routes: this.$routers,
    };
  },
  computed: {},
  created() {
    this.mapRoutes();
  },
  methods: {
    mapRoutes() {
      let routes = this.collected_routes
      this.new_routes = routes.filter(filter => {
          return filter.type === 'page' 
      });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>