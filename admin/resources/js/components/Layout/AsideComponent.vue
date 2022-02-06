<template>
  <div>
    <!-- <NavbarComponent ref="navbarComponent" :route="currentRoute" :me="selected"  @changed="emitChange()"></NavbarComponent> -->
    <navbar-component></navbar-component>
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
<!-- {{ routes }} -->
      <transition name="fade" >
        <div v-if="show" class="flex-grow-1" style="flex-grow: 1 !important;">
            <ul class="menu-list grid d-flex flex-wrap border rounded mx-auto">
                <li v-for="(route, i) in routes" :key="i" @click="assignRoute(route.name)">
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

import NavbarComponent from './NavbarComponent.vue';
  export default {
    name: "AsideComponent",
    components: {
      NavbarComponent
    },
    props:{
      // selected: {
      //   required: true,
      //   type: Object
      // },
      // role: {
      //   required: true,
      //   type: String
      // },
      // permissions: {
      //   required: true,
      //   type: Array
      // }
    },
    data() {
      return {
        routes: this.$routers,
        show: true
      }
    },
    created () {
      console.log(this.routes, 'routes');
    },
  }
</script>

<style lang="scss" scoped>

</style>