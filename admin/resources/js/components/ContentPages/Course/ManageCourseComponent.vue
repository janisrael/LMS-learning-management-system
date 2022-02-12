<template>
  <div>
    <el-drawer
      :title="selected.name"
      :visible.sync="drawer"
      direction="ltr"
      size="100%"
      :before-close="handleClose">
      <!-- <span>{{ selected.lessons }}</span> -->
   
        <el-col :span="24" style="padding: 10px;">
          <el-card class="box-card layout-card" shadow="never">
            <el-col :span="18">
                <el-button type="success" plain size="small">
                  Add New Lesson
                </el-button>
                <el-tabs tab-position="top" style="height: 200px;">
                  <el-tab-pane label="Lessons">
                    <el-table
                      ref="multipleTable"
                      class="manageCourseTable"
                      highlight-current-row
                      @current-change="handleCurrentChange"
                      :data="selected.lessons"
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
          </el-card>
        </el-col>
        </el-col>
    
    </el-drawer>
  </div>
</template>

<script>
  export default {
    name: 'ManageCourseComponent',
    props: {
      selected: {
        required: true,
        type: Object,
        currentRow: null
      },
    },
    data() {
      return {
        drawer: false,
        id: this.selected.id,
        chapters: this.$store.getters.this_chapters
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