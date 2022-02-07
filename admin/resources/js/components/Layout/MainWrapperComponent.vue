<template>
  <div>
    <aside-component></aside-component>
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
      routes: this.$routers,
    };
  },
  computed: {},
  created() {
    this.mapRoutes();
  },
  methods: {
    mapRoutes() {
      let new_route = [];
      this.routes.forEach((value, i) => {
        if (value.type === "page") {
          new_route.push(value);
        }
      });
      this.new_routes = new_route;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>