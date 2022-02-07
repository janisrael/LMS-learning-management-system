<template>
  <div>
    <aside-component></aside-component>
    <content-component></content-component>
  </div>
</template>

<script>
import AsideComponent from './AsideComponent'
import ContentComponent from './ContentComponent'
  export default {
    name: 'MainWrapperComponent',
    components: {
      AsideComponent,
      ContentComponent
    },
    data() {
      return {
        loading: false,
  
      }
    },
    computed: {

    },
    created () {

    },
    methods: {
     
    },
  }
</script>

<style lang="scss" scoped>

</style>