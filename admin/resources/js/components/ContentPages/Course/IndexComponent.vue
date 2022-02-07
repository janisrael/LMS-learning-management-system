<template>
  <div>
    <transition name="component-fade" mode="out-in">
      <component :is="thisComponent" @change="changeComponent" :action="action" :selected="data"></component>
    </transition>
  </div>
</template>

<script>
  import ViewCourseComponent from './ViewCourseComponent.vue'
  import CreateCourseComponent from './CreateCourseComponent'
  export default {
    name: 'IndexCourseComponent',
    components: {
      ViewCourseComponent,
      CreateCourseComponent
    },
    data() {
      return {
        loading: false,
        thisComponent: null,
        data: {},
        action: 'create'
      }
    },
    created () {
      this.loadPrimaryComponent()
      // this.$store.dispatch('GetComponentName','Create Course')
    },
    methods: {
      loadPrimaryComponent() {
        this.thisComponent = ViewCourseComponent
      },
      changeComponent(value) {
        console.log(value)
        if(value.mode === 'add') {
          this.thisComponent = null
          this.data = {}
          this.action = 'create'
          this.thisComponent = CreateCourseComponent
        }
        if(value.mode === 'back') {
          this.thisComponent = null
          this.data = {}
          this.action = 'create'
          this.thisComponent = ViewCourseComponent
        }
        if(value.mode === 'edit') {
          this.thisComponent = null
          this.data = value.data
          this.action = 'edit'
          this.thisComponent = CreateCourseComponent
        }
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>