<template>
  <div>
    <el-col :span="4" style="height: 100vh; margin-top: -20px;">
      <div class="chapter-list-left">
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
              <li class="timeline-inverted">
                  <!-- <div class="timeline-badge danger">
                      <i class="md-icon md-icon-font md-theme-default"
                      >card_travel
                      </i>
                  </div> -->
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <span class="badge badge-danger">
                      Lesson Title 1
                      </span>
                    </div>
                    <div class="timeline-body">
                        <p> Wifey made the best Father's Day meal ever. So thankful so happy so blessed. Thank you for making my family We just had fun with the “future” theme !!! It was a fun night all together ... The always rude Kanye Show at 2am Sold Out Famous viewing @ Figueroa and 12th in downtown. </p>
                    </div>
                    <h6>
                      <h6>
                      <i class="ti-time"></i> 
                      11 hours ago via Twitter 
                      </h6>
                    </h6>
                  </div>
              </li>

              <li class="timeline-inverted">
                  <!-- <div class="timeline-badge danger">
                      <i class="md-icon md-icon-font md-theme-default"
                      >card_travel
                      </i>
                  </div> -->
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <span class="badge badge-danger">
                      Lesson Title 2
                      </span>
                    </div>
                    <div class="timeline-body">
                        <p> Wifey made the best Father's Day meal ever. So thankful so happy so blessed. Thank you for making my family We just had fun with the “future” theme !!! It was a fun night all together ... The always rude Kanye Show at 2am Sold Out Famous viewing @ Figueroa and 12th in downtown. </p>
                    </div>
                    <h6>
                      <h6>
                      <i class="ti-time"></i> 
                      11 hours ago via Twitter 
                      </h6>
                    </h6>
                  </div>
              </li>

              <li class="timeline-inverted">
                  <!-- <div class="timeline-badge danger">
                      <i class="md-icon md-icon-font md-theme-default"
                      >card_travel
                      </i>
                  </div> -->
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <span class="badge badge-danger">
                      Lesson Title 3
                      </span>
                    </div>
                    <div class="timeline-body">
                        <p> Wifey made the best Father's Day meal ever. So thankful so happy so blessed. Thank you for making my family We just had fun with the “future” theme !!! It was a fun night all together ... The always rude Kanye Show at 2am Sold Out Famous viewing @ Figueroa and 12th in downtown. </p>
                    </div>
                    <h6>
                      <h6>
                      <i class="ti-time"></i> 
                      11 hours ago via Twitter 
                      </h6>
                    </h6>
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