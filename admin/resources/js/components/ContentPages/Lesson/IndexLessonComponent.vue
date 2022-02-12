<template>
     <div>
        <transition name="component-fade" mode="out-in">
            <component :is="thisComponent" @change="changeComponent" :act="action" :selected="selected_data"></component>
        </transition>
    </div>
</template>

<script>
import CreateLessonComponent from './CreateLessonComponent'
import ViewLessonComponent from './ViewLessonComponent'
  export default {
    name: 'IndexLessonComponent',
    components: {
      ViewLessonComponent,
      CreateLessonComponent
    },
    data() {
      return {
        lessons: [],
        thisComponent: null,
        selected_data: {},
        action: ''
      }
    },
    computed: {
      this_lessons() {
        return this.$store.getters.this_lessons
      }
    },
    created () {
      // this.getdLessons()
      this.loadPrimaryComponent()
    },
    mounted () {
      
    },
    methods: {
      loadPrimaryComponent() {
        this.thisComponent = ViewLessonComponent
      },
      changeComponent(value) {
        console.log(value, 'emited')
        this.action = value.mode
        this.selected_data = value.data
        if (value.mode === 'add') {
          this.thisComponent = null
          // this.data = {}
          // this.action = 'create'
          this.$store.dispatch("SetSelected", value);
          this.thisComponent = CreateLessonComponent
          this.$router.push({ name: 'New Lesson', replace: true })
            
        }
        if (value.mode === 'back') {
          this.thisComponent = null
          // this.data = {}
          // this.action = 'back'
          this.$store.dispatch("SetSelected", value);
          this.thisComponent = ViewLessonComponent
        }
        if (value.mode === 'edit') {
          this.thisComponent = null
          // this.data = value.data
          this.$store.dispatch("SetSelected", value);
          this.thisComponent = CreateLessonComponent 
        
          this.$router.push({ name: 'Edit Lesson', replace: true })
      
        }
      },
    },
  }
</script>

<style lang="scss" scoped>

</style>