<template>
  <div>
    <el-col :span="4" style="background-color:#fff; height: 100vh; margin-top: -20px;">
      Chapters
      <div>
      Chapter 1
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
      </ul>
    </div>
    
          <!-- <el-card class="box-card layout-card" shadow="never">
            <el-col :span="18">
                <el-button type="success" plain size="small">
                  Add New Lesson
                </el-button>
                <el-tabs tab-position="top" >
                  <el-tab-pane label="Lessons">
                    <el-table
                      ref="multipleTable"
                      class="manageCourseTable"
                      highlight-current-row
                      @current-change="handleCurrentChange"
                      :data="this_selected.lessons"
                      border
                      style="width: 100%">
                      <el-table-column
                        type="selection"
                        width="55">
                      </el-table-column>
                      <el-table-column
                        prop="name"
                        label="Lesson Title"
                        width="180">
                      </el-table-column>
                      <el-table-column
                        prop="description"
                        label="Description"
                        width="180">
                      </el-table-column>
                      <el-table-column
                        prop="chapter.name"
                        label="Chapter"
                        width="180">
                      </el-table-column>
                      <el-table-column
                        prop="is_active"
                        label="Status"
                        width="100">
                      </el-table-column>
                      <el-table-column
                        prop="video_url"
                        label="Video">
                      </el-table-column>
                      <el-table-column
                        prop="image_url"
                        label="Image">
                      </el-table-column>
                      <el-table-column
                        label="Action"
                        width="200">
                          <el-button type="success" plain size="small">
                              <i class="fas fa-edit" @click="handleEdit(course, i)"></i>
                          </el-button>
                          <el-button type="success" plain size="small">
                              <i class="el-icon-s-grid" @click="manageCourse(course, i)"></i>
                          </el-button>
                          <el-button type="success" plain size="small">
                              <i class="fas fa-trash-alt" @click="handleDelete(course, i)"></i>
                          </el-button>
                      </el-table-column>
                    </el-table>
                  </el-tab-pane>
                  <el-tab-pane label="Unassigned Lessons">Unassigned Lessons</el-tab-pane>
                </el-tabs>
            </el-col>
            <el-col :span="6" style="padding: 10px;">
              <el-button type="success" plain size="small">
                  Add New Chapter
              </el-button>
              <span style="padding: 5px 0; display: block; font-weight: 500;">Chapters</span>
              <el-table
                  ref="singleTable"
                  class="chapterTable"
                  highlight-current-row
                  @current-change="handleCurrentChange"
                  :data="chapters"
                  border
                  style="width: 100%">
                  <el-table-column
                    type="selection"
                    width="55">
                  </el-table-column>
                  <el-table-column
                    prop="name"
                    label="Chapter Name"
                    width="180">
                  </el-table-column>
                  <el-table-column
                    prop="description"
                    label="Description"
                    width="180">
                  </el-table-column>
                  <el-table-column
                    prop="is_active"
                    label="Status"
                    width="100">
                  </el-table-column>
                  <el-table-column
                    label="Action"
                    fixed="right"
                    width="200">
                      <el-button type="success" plain size="small">
                          <i class="fas fa-edit" @click="handleEdit(course, i)"></i>
                      </el-button>
                      <el-button type="success" plain size="small">
                          <i class="el-icon-s-grid" @click="manageCourse(course, i)"></i>
                      </el-button>
                      <el-button type="success" plain size="small">
                          <i class="fas fa-trash-alt" @click="handleDelete(course, i)"></i>
                      </el-button>
                  </el-table-column>
                </el-table>
            </el-col>
          </el-card> -->
        </el-col>
    </el-col>
    <!-- <el-drawer
      :title="selected.name"
      :visible.sync="drawer"
      direction="ltr"
      size="100%"
      :before-close="handleClose"> -->
      <!-- <span>{{ selected.lessons }}</span> -->
   <!-- {{ this_selected }} -->
        
      </el-col>
    
    <!-- </el-drawer> -->
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