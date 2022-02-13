<template>
    <div>
        <!-- <NavbarComponent ref="navbarComponent" :route="currentRoute" :me="selected"  @changed="emitChange()"></NavbarComponent> -->
        <navbar-component :route="currentRoute"></navbar-component>
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-image: url('../../img/bg.svg?v=1620469277'), linear-gradient( 141deg, #1781d0 0%, #1f81b6 51%, #2d7cb0 100%) !important;">
            <a href="/" class="brand-link logo">
            <span class="logo-mini" @click="assignRoute('Dashboard')"><b>S</b>C2</span>
            <span class="logo-lg" @click="assignRoute('Dashboard')">
            <span class="brand-text font-weight-light">
              <span class="logo-name-first">E</span>
              <span class="logo-name-second">LEARNING</span>
              <span class="logo-name-third">ADMIN</span></span>
            </span>
          </a>
    
            <transition name="fade">
                <div class="flex-grow-1" style="flex-grow: 1 !important;">
                    <ul class="menu-list grid d-flex flex-wrap border rounded mx-auto">
                        <li v-for="(route, i) in routes" :key="i" :class="['menu-li route-li-' + i]">
                            <a :class="{ active: i === activeId }" class="m-link" @click="assignRoute(route, i, route.id)" :to="route.path" :href="'#' + route.path">
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
    props: {
        routes: {
            required: true,
        
        }
    },
    data() {
        return {
            currentRoute: this.$route,
            current_index: null,
            active: null,
            activeId: 0
        }
    },
    methods: {
      assignRoute(route, i, id) {
        this.activeId = i
        this.currentRoute = route
        this.$router.push({ path: '/course-management/create', replace: true })
      }
    },
}
</script>

<style lang="scss" scoped>

</style>