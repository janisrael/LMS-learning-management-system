<template>
  <div>
    <transition name="component-fade" mode="out-in">
      <component :is="componentName"></component>
    </transition>
  </div>
</template>

<script>
import LoginComponent from '../Auth/LoginComponent'
import MainWrapperComponent from './MainWrapperComponent'

  export default {
    components: {
      LoginComponent,
      MainWrapperComponent
    
    },
    name: 'Index',
    computed: {
      componentName() {
        return this.$store.getters.this_component_name
      }
    },
    data() {
      return {
        routes: this.$routers,
        currentComponent: null,
        allowed_views_by_permission: [],
        currentComponent: null,
        // componentName: null
      }
    },
    created () {
      this.checkState()
    },
    methods: {
      checkState() {
    
        if(localStorage.getItem("user_token") === null) {
           this.$store.dispatch('attempt')
        } else {
          this.$store.dispatch('attempt')
        }
      }
      // setAllowedViews: function() {
      //   let permissions = this.permissions
      //   let allowed_views = []
      //   permissions.forEach((value, index) => {
      //     if(value.guard_name !== '-') {
      //       allowed_views.push(value.name)
      //     }
      //   })
      //   this.allowed_views_by_permission = allowed_views
      // }
    }
  }

</script>

<style lang="scss" scoped>

</style>