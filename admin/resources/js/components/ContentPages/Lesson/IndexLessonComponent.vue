<template>
  <div>
     <!-- {{ this.$store.getters.this_lessons }} -->

     {{ this_lessons }}
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
  export default {
    name: 'IndexLessonComponent',
    data() {
      return {
        lessons: []
      }
    },
    computed: {
      this_lessons() {
        return this.$store.getters.this_lessons
      }
    },
    created () {
      // this.getdLessons()
      
    },
    mounted () {
      this.getdLessons()
    },
    methods: {
      // ...mapActions(['getLessons']),
      getdLessons() {
      //   console.log('asdasd')
      //   // this.add()
      let id = 1
      let res = this.$store.dispatch('getLessons')
      if(res) {
        this.lessons = this.this_lessons
      }
      //   // .then(response => {
      //   //   this.lessons = this.$store.getters.this_lessons
      //   // })
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>