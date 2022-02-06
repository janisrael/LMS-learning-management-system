<template>
  <div id="app">
    <layout-component></layout-component>
  </div>
</template>

<script>
import LayoutComponent from './components/layout/index'

export default {
  name: 'App',
  components: {
      LayoutComponent
  },
  data() {
    return {
      roles_and_permission :this.$store.getters
    }
  },
  mounted() {
    // this.$store.dispatch('createUserProduct', 1)
  },
  created() {
  
  }
}
</script>

<style>

</style>
