<template>
  <div>
 
    <el-col :span="4" style="height: 100vh; margin-top: -20px;" class="chapter-menu" :class="{ moveclass: windowTop > 50 }">
      <ul class="chapter-item-selection grid d-flex flex-wrap rounded mx-auto">
          <li v-for="(chapter, i) in this_chapters.data" :key="i" :class="['chapter-selection menu-li route-li-' + i]">
              <a :class="{ active: i === activeId }" class="chapter-list-left m-link" @click="selectChapter(chapter, i)">
                <span class="chapter-title" style="font-size: 14px !important; font-weight: 600 !important;">{{ chapter.name }}</span>
                <span class="chapter-sub">{{ chapter.description }}</span>
              </a>
          </li>
      </ul>
    </el-col>
    <el-col :span="18" style="height: 100vh; float:right !important;">
    <div class="search-input-suffix" style="width: 100%; text-align: center;">
      <el-col :span="24">
      {{ this_id }} {{ windowTop }}
        <!-- <h4>{{ this_chapters.course }}</h4> -->
       <!-- {{ this.$store.getters.this_selected }} -->
          <el-input :placeholder="moveclass" class="input-with-select search-input" clearable v-model="search" style="max-width: 600px;">
              <template slot="prepend">
                  <el-popover
                      placement="bottom-start"
                      trigger="click">
                      <div class="filter-data">
                          <div class="filter-data-wrapper">
                              <!-- <el-select v-model="filteredAuthors" multiple placeholder="Author" size="mini" style="margin-right: 10px;" clearable>
                                  <el-option
                                  size="mini"
                                  v-for="item in this_authors"
                                  :key="item.id"
                                  :label="item.last_name + ' ' + item.first_name"
                                  :value="item.id">
                                  </el-option>
                              </el-select> -->
                                <el-checkbox-group v-model="selectedfilters" size="mini">
                                  <el-checkbox v-for="filter in filters" :label="filter" :key="filter">
                                  </el-checkbox>
                                  <el-button type="success" plain>
                                    OK
                                  </el-button>
                                  <el-button type="success" plain>
                                    Clear
                                  </el-button>
                              </el-checkbox-group>
                          </div>
                      </div>
                      <el-button slot="reference">
                          <i class="el-icon-s-unfold search-filter-icon"></i>
                      </el-button>
                  </el-popover>
              </template>
              <el-button slot="append" icon="el-icon-search" @click="getRecords('1')"></el-button>
          </el-input>
      </el-col>
  </div>
      <el-col :span="24" style="padding: 10px;">
        <span v-for="(chapter, index) in this_chapters.data" :key="index" class="chapter-title-wrapper">
          <span :id="['lesson_section_' + index]" content-position="left">
            <span class="chapter-title">{{ chapter.name }}</span>: 
            <span class="chapter-sub">{{ chapter.description }}</span>
          </span> 
          <div class="md-card md-card-timeline md-theme-default md-card-plain">
            <ul class="timeline timeline-simple">
              <li v-for="(lesson, i) in chapter.lessons" :key="i" class="timeline-inverted">
                  <div class="timeline-panel">
                    <div class="lesson-resources-wrapper">
                        <el-col :span="8" class="lesson-media-wrapper lesson-media" :class="{ enabled: lesson.video_url !== null }">
                          <el-popover
                            ref="popover"
                            placement="left-start"
                            title="Warning"
                            width="300"
                            trigger="hover"
                            class="manage-course-popover"
                            content="Lesson Video is not properly setup!">
                            <div class="status-badge" slot="reference">
                              <i v-if="lesson.video_url === null || lesson.preview_url === null" class="fa fa-exclamation-triangle warning" aria-hidden="true"></i>
                              <!-- <i v-else class="fa fa-check good" aria-hidden="true"></i> -->
                            </div>
                          </el-popover>
                          <i class="el-icon-picture"/>
                          <h5 style="font-weight: 400 !important; color: #959595;">Video</h5>
                        </el-col>
                        <el-col :span="8" class="lesson-media-wrapper lesson-media" :class="{ enabled: lesson.resources_status !== 0 }">
                          <div class="status-badge">
                            <i v-if="lesson.resources_status === 0" class="fa fa-exclamation-triangle warning" aria-hidden="true"></i>
                            <!-- <i v-else class="fa fa-check good" aria-hidden="true"></i> -->
                          </div>
                          <i class="fa fa-file" aria-hidden="true"></i>
                            <h5 style="font-weight: 400 !important; color: #959595;">Resources</h5>
                        </el-col>
                        <el-col :span="8" class="lesson-media-wrapper" :class="{ enabled: lesson.faqs_status !== 0 }">
                          <div class="status-badge">
                            <i v-if="lesson.faqs_status === 0" class="fa fa-exclamation-triangle warning" aria-hidden="true"></i>
                            <!-- <i v-else class="fa fa-check good" aria-hidden="true"></i> -->
                          </div>
                          <i class="fa fa-comment" aria-hidden="true"></i>
                          <h5 style="font-weight: 400 !important; color: #959595;">FAQ</h5>
                        </el-col>
                    </div>
                    <div class="timeline-heading">
                      <h4 class="card-title-course" style="color: #636363 !important; font-weight: 400 !important;">{{ lesson.name }}</h4>
                    </div>
                    <div class="timeline-body">
                      <span class="lesson-li-body"> {{ lesson.description }}</span>
                    </div>
                    <!-- <span class="badge badge-danger">
                      <h6>
                       {{ chapter.name }}
                      </h6>
                    </span> -->
                </div>
              </li>
            </ul>
          </div>
          </span>
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
      }
    },
    data() {
      return {
        drawer: false,
        id: this.$store.state.v_id,
        chapters: this.$store.getters.this_lessons_by_chapter,
        this_selected: this.$store.getters.this_selected.data,
        activeId: 0,
        active: null,
        filters: ['Featured', 'Global', 'Live','Active'],
        selectedfilters: [],
        search: '',
        windowTop: 0,
        moveclass: null,
        enabled: null
      }
    },
    mounted() {
      window.addEventListener("scroll", this.onScroll);
    },
    beforeDestroy() {
      window.removeEventListener("scroll", this.onScroll);
    },
    computed: {
      this_chapters() {
        return this.$store.getters.this_lessons_by_chapter
      },
      this_id() {
        return this.$store.getters.this_v_id
      }
    },
    created () {
      // if(localStorage.getItem('selected_id') === null || !localStorage.getItem('selected_id')) {
      //   localStorage.setItem('selected_id', parseInt(this.$store.getters.this_selected.data.id))
      // }
      
      this.getChapters()
    },
    methods: {
      show(value) {
        this.id = value
      },
      onScroll(e) {
        this.windowTop = e.target.documentElement.scrollTop;
        // if(this.windowTop >= 60) {
          // console.log('yes')
        // }
        // console.log({ top: this.windowTop });
      },
      setCurrent(row) {
        // this.$refs.chapterTable.setCurrentRow(row);
        this.$refs.multipleTable.setCurrentRow(row);
      },
      handleCurrentChange(val) {
        this.currentRow = val;
      },
      getChapters() {
// console.log(this.this_id , 'sdfs')
        let result = this.$store.dispatch('getLessonsByChapter', localStorage.getItem('selected_id')).then(response => {
          if(result) {
            this.chapters = this.$store.getters.this_lessons_by_chapter
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
      },
      selectChapter(value, i) {
        this.activeId = i
        var section_id = 'lesson_section_' + i
        var elmnt = document.getElementById(section_id);
        elmnt.scrollIntoView({behavior: "smooth", block: "start", inline: "start"});
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>