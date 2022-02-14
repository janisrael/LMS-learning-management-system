<template>
  <div>
    <el-col :span="4" style="height: 100vh; margin-top: -20px;">

      <ul class="chapter-item-selection grid d-flex flex-wrap rounded mx-auto">
          <li v-for="(chapter, i) in this_chapters.data" :key="i" :class="['chapter-selection menu-li route-li-' + i]">
              <a :class="{ active: i === activeId }" class="chapter-list-left m-link" @click="selectChapter(chapter, i)">
                <div><strong>{{ chapter.name }}</strong></div>
                <div>{{ chapter.description }}</div>
              </a>
          </li>
      </ul>
      <!-- <div v-for="(chapter, i) in this_chapters.data" :key="i" class="chapter-list-left active">
        <div><strong>{{ chapter.name }}</strong></div>
        <div>{{ chapter.description }}</div>
      </div> -->

    </el-col>
<!-- {{ this_chapters }} -->
    <el-col :span="20" style="height: 100vh;">

    <div class="search-input-suffix" style="width: 100%; text-align: center;">
      <el-col :span="24">
        <!-- <h4>{{ this_chapters.course }}</h4> -->
          <el-input placeholder="Search" class="input-with-select search-input" clearable v-model="search" style="max-width: 600px;">
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
        <span v-for="(chapter, index) in this_chapters.data" :key="index">
        <!-- <span> {{ chapter.name }}</span> -->
          <el-divider :id="['lesson_section_' + index]" content-position="left">{{ chapter.name }}:{{ chapter.description }}</el-divider>
          <!-- <el-divider></el-divider> -->
          <div class="md-card md-card-timeline md-theme-default md-card-plain">
            <ul class="timeline timeline-simple">
              <li v-for="(lesson, i) in chapter.lessons" :key="i" class="timeline-inverted">
              <!-- {{ i }} -->
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
                       {{ chapter.name }}
                      </h6>
                      </span>
                
                  </div>
              </li>
            </ul>
          </div>
          </span>
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
        chapters: this.$store.getters.this_lessons_by_chapter,
        this_selected: this.$store.getters.this_selected.data,
        activeId: 0,
        active: null,
        filters: ['Featured', 'Global', 'Live','Active'],
        selectedfilters: [],
        search: ''
      }
    },
    computed: {
      this_chapters() {
        return this.$store.getters.this_lessons_by_chapter
      }
    },
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
        let result = this.$store.dispatch('getLessonsByChapter', this.id).then(response => {
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
        // console.log(section_id)
        console.log(section_id)
        //  window.location.href = "#lesson_section_" + i;
        //  document.getElementById(section_id).scrollIntoView(true);
        var elmnt = document.getElementById(section_id);
        elmnt.scrollIntoView({behavior: "smooth", block: "start", inline: "start"});
  
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>