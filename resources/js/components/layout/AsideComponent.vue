<template>
  <div>
    <NavBarComponent ref="navbarComponent" :route="currentRoute" :me="selected"  @changed="emitChange()"></NavBarComponent>
    <aside class="main-sidebar sidebar-dark-primary elevation-4" 
      style="background-image: url('../../img/bg.svg?v=1620469277'), linear-gradient( 141deg, #1781d0 0%, #1f81b6 51%, #2d7cb0 100%) !important;"
      >
      <a href="/" class="brand-link logo">
        <span class="logo-mini" @click="assignRoute('Dashboard')"><b>S</b>C2</span>
        <span class="logo-lg" @click="assignRoute('Dashboard')">
          <span class="brand-text font-weight-light"><span style="font-weight: 600; padding-left: 5px; rgb(140 208 255) !important;">E</span><span>LEARNING</span>
          <span style="color: #03558f !important;
          font-size: 14px !important;
          font-weight: 500 !important;">ADMIN</span></span>
        </span>
      </a>
      <transition name="fade" >
        <div v-if="show" class="flex-grow-1" style="flex-grow: 1 !important;">
            <ul class="menu-list grid d-flex flex-wrap border rounded mx-auto">
                <li v-for="(route, i) in this_route" :key="i" @click="assignRoute(route.name)">
                  <a class="m-link" :to="route.path" :href="'#' + route.path">
                    <span v-html="route.icon"></span>
                    <span>{{ route.name }}</span>
                  </a>
                </li>
            </ul>
        </div>
      </transition>
    </aside>
  </div>
</template>
<script>

import NavBarComponent from "./NavBarComponent";
export default {
  name: "AsideComponent",
  props:{
    selected: {
      required: true,
      type: Object
    },
    role: {
      required: true,
      type: String
    },
    permissions: {
      required: true,
      type: Array
    }
  },
  components: {
    NavBarComponent
  },
  data() {
    return {
      loading: false,
      currentRoute: this.$route.name,
      routes: this.$routers,
      this_route: [],
      show: false
    }
  },
  created() {
    this.mapRoutes()
  },
  methods: {
    ex_show() {
      this.show = true
    },
    mapRoutes() {
      this.loading = true
      let this_route = []
      this.routes.forEach((value, index) => {
        if(value.type) {
          if(value.type !== '') {
            this_route.push(value)
          }
        }
      })
      this.this_route = this_route
      this.loading = false
      setTimeout(() => this.ex_show(), 500)
    },
    toogleAside(){
      this.$refs.navbarComponent.toogleEvent()
    },
    assignRoute(link) {
      this.currentRoute = link
    },
    emitChange() {
      this.$emit('changed');
    }
  }
}
</script>

<style scoped>

</style>
