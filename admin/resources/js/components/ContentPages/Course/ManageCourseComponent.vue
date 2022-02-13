<template>
  <div>
    <el-col :span="4" style="height: 100vh; margin-top: -20px;">
      <div class="chapter-list-left active">
        <div><strong>Chapter 1</strong></div>
        <div>This is the description</div>
      </div>

      <div class="chapter-list-left">
        <div><strong>Chapter 2</strong></div>
        <div>This is the description</div>
      </div>

      <div class="chapter-list-left">
        <div><strong>Chapter 3</strong></div>
        <div>This is the description</div>
      </div>

      <div class="chapter-list-left">
        <div><strong>Chapter 4</strong></div>
        <div>This is the description</div>
      </div>
    </el-col>

    <el-col :span="20" style="height: 100vh;">
      <el-col :span="24" style="padding: 10px;">

        <div class="md-card md-card-timeline md-theme-default md-card-plain">
            <ul class="timeline timeline-simple">
              <li v-for="(lesson, i) in this_selected.lessons" :key="i" class="timeline-inverted">
                  <div class="timeline-panel">
                    <div class="lesson-resources-wrapper">
                        <el-col :span="8" class="lesson-media-wrapper lesson-media">
                          <i class="el-icon-picture"/>
                          <h5 style="font-weight: 400 !important;">Video</h5>
                        </el-col>
                        <el-col :span="8" class="lesson-media-wrapper lesson-media">
                          <i class="fa fa-file" aria-hidden="true"></i>
                            <h5 style="font-weight: 400 !important;">Resources</h5>
                        </el-col>
                        <el-col :span="8" class="lesson-media-wrapper">
                          <i class="fa fa-comment" aria-hidden="true"></i>
                          <h5 style="font-weight: 400 !important;">FAQ</h5>
                        </el-col>
                    </div>
                    <div class="timeline-heading">
                      <h4 class="card-title-course" style="color: black !important; font-weight: 400 !important;">{{ lesson.name }}</h4>
                    </div>
                    <div class="timeline-body">
                        <span class="lesson-li-body"> {{ lesson.description }}</span>
                    </div>
                   
                      <span class="badge badge-danger">
                      <h6>
                       {{ lesson.chapter.name }}
                      </h6>
                      </span>
                
                  </div>
              </li>
            </ul>
          </div>
        </el-col>
      </el-col>
    </el-col>
  </div>
</template>

<script>
  export default {
    name: 'ManageCourseComponent',
    props: {
      selected: {
        required: false,
        type: Object
      },
    },
    data() {
      return {
        drawer: false,
        id: 1,
        chapters: this.$store.getters.this_chapters,
        this_selected: this.$store.getters.this_selected.data,
      }
    },
    // computed: {
    //   this_chapters() {
    //     return this.$store.getters.this_chapters
    //   }
    // },
    created () {
      this.drawer = true;
      this.getChapters()
    },
    methods: {
      setCurrent(row) {
        // this.$refs.chapterTable.setCurrentRow(row);
        this.$refs.multipleTable.setCurrentRow(row);
      },
      handleCurrentChange(val) {
        this.currentRow = val;
      },
      getChapters() {
        let result = this.$store.dispatch('GetChapters', this.id).then(response => {
          if(result) {
            this.chapters = this.$store.getters.this_chapters
          }
        })
      },
      handleClose(done) {
        this.$confirm('Are you sure you want to close this?', 'Title', {
          confirmButtonText: 'Confirm',
          cancelButtonText: 'Cancel',
          type: 'warning'
          }).then(() => {
            this.$emit("change_close", 'asd');
            this.drawer = false
                
          }).catch(() => {
            // this.$message({
            //   type: 'info',
            //   message: 'Delete canceled'
            // });          
          });
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>