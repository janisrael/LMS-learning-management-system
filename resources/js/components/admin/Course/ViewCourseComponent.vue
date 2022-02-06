<template>
  <el-col :span="24">
<!--    <el-col :span="24" class="page-content-title">Maintenance Management - Schedule List</el-col>-->
    <el-col ref="contentMargin" :span="24" class="content-margin">
      <el-card class="box-card layout-card" shadow="never">
        <div slot="header" class="clearfix">
          <div class="search-input-suffix" style="width: 100%">
            <el-col :span="24">
              <!-- <span class="search-input-label">Search:</span> -->
              <el-input
                placeholder=""
                class="input-with-select search-input"
                size="small"
                clearable
                v-model="search"
                style="max-width: 600px;">
                <el-select v-model="author_id" slot="prepend" placeholder="Select" @change="getRecords(author_id)" style="width: 170px;" clearable>
                    <el-option v-for="auth in this_authors" :key="auth.id" :label="auth.last_name + ' ' + auth.first_name" :value="auth.id"></el-option>
                </el-select>
                <el-button slot="append" icon="el-icon-search" @click="getRecords('1')"></el-button>
              </el-input>
              <el-button type="success" size="mini" @click="handleAdd()" style="float:right"><i class="el-icon-plus"></i> New Course</el-button>
            </el-col>
          </div>
        </div>
        <transition name="fade" >
          <div v-if="show" class="card-content">
            <el-row :gutter="10" style="margin-bottom: 10px;">
              <el-col :xs="24" :sm="8" :md="8" :lg="6" :xl="6" >
                <el-card shadow="hover" border class="course-card course-add-card" >
                  <div @click="handleAdd()">
                    <div style="height:215px;">
                      <i class="el-icon-plus"></i>
                    </div>
                  </div>
                </el-card>
              </el-col>
              <el-col v-for="(course, i) in this_courses" :key="i" :xs="24" :sm="8" :md="8" :lg="6" :xl="6">
                <transition name="fade" >
                <el-card :body-style="{ padding: '0px' }" shadow="hover" border class="course-card">
                  <div :style="{'background-image': 'url(' + course.attachment_absolute_path + ')'}" class="course-card-content-wrapper">
                    <div style="padding: 14px;" class="course-card-details-wrapper">
                      <span class="card-title-course">{{ course.name }}</span>
                      <div class="bottom clearfix">
                        <i class="fas fa-certificate"></i>
                        <el-button type="text" class="button">Operating</el-button>
                      </div>
                    </div>
                  </div>
                </el-card>
                </transition>
              </el-col>
            </el-row>
        </div>
        </transition>
      </el-card>
    </el-col>
  </el-col>
</template>

<script>
  import CreateCourseComponent from "./CreateCourseComponent.vue";
  import {Notification} from "element-ui";
  import Sortable from 'sortablejs';
export default {
  name: "ViewCourseComponent",
  components: {
    CreateCourseComponent
  },
  data() {
    return {
      loading: false,
      search: '',
      currentComponent: null,
      passData: {},
      total: 0,
      data: [],
      enties: 10,
      tabledata: [],

      listQuery: {
        page: 1,
        limit: 20
      },
      chunkedData: '',
      per_page: 10,
      page_number: 0,
      colwidth: '150',
      roles_and_permission: this.$store.state.user,
      meta: {
        total: 0,
        page: 0,
        per_page: 0
      },
      list: null,
      total: null,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 10
      },
      sortable: null,
      oldList: [],
      newList: [],
      author_id: null,
      show: false
      // authors: []
    }
  },
  filters: {
    moment: function (date) {
      return moment(date).format('lll');
    }
  },
  watch: {
    search: function() {
      this.loading = true
      if (this.search.length >= 1 || this.search.length === 0) {
        this.getRecords()
      }
    }
  },
  computed: {
    this_authors() {
      return this.$store.getters.allAuthors
    },
    this_courses() {
      return this.$store.getters.allCourses
    },
    this_componentname() {
      return this.$store.getters.componentName
    }
  },
  created: function() {
    // this.handleResize();
    this.loading = true
    this.loading = false
    this.listLoading = false
    this.show = true
    this.$store.dispatch('GetComponentName','All')
  },
  methods: {
    setSort() {
      const el = this.$refs.dragTable.$el.querySelectorAll('.el-table__body-wrapper > table > tbody')[0]
      this.sortable = Sortable.create(el, {
        ghostClass: 'sortable-ghost', // Class name for the drop placeholder,
        setData: function(dataTransfer) {
          // to avoid Firefox bug
          // Detail see : https://github.com/RubaXa/Sortable/issues/1012
          dataTransfer.setData('Text', '')
        },
        onEnd: evt => {
          const targetRow = this.data.splice(evt.oldIndex, 1)[0]
          this.data.splice(evt.newIndex, 0, targetRow)
          // for show the changes, you can delete in you code
          const tempIndex = this.newList.splice(evt.oldIndex, 1)[0]
          this.newList.splice(evt.newIndex, 0, tempIndex)
        }
      })
    },
    handleAdd() {
      let value = {
        mode: 'add',
        data: ''
      }
      this.$emit('change', value)
    },
    tableRowClassName({ row }) {
      if (row.status === 'yes') {
        return 'status-active'
      } else {
        return 'status-normal'
      }
    },
    handleDelete(row) {
      this.forms.fill(row)
      this.$confirm('Are you sure you want to delete this Maintenance Schedule?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(() => {
        this.forms.get('/maintenance/delete/' + row.id)
          .then((response)=> {
            let stat = response.data.status;
            Notification[stat]({
              title: stat.charAt(0).toUpperCase() + stat.slice(1),
              message: response.data.message,
              duration: 4 * 1000
            });
            this.getRecords();
          }).catch(() => {
        })
      }).catch(() => {
        // this.$message({
        //   type: 'info',
        //   message: 'Delete canceled'
        // });
      });
    },
    filterTagGlobal(value, row) {
      return row.is_global === value
    },
    filterTagFeatured(value, row) {
      return row.is_featured === value
    },
    filterTagActive(value, row) {
      return row.is_active === value
    },
    handleEdit(row) {
      this.passData = row
      let value = {
        mode: 'edit',
        data: row
      }
      this.$emit('change', value)
      // this.currentComponent = EditComponent
      // setTimeout(() => this.ex_call_modal(), 1)
    },
    ex_call_modal() {
      this.$refs.modalComponent.show()
    },
    chunkData(data) {
      this.loading = true
      Object.defineProperty(Array.prototype, 'chunk', {
        writable: true,
        enumerable: true,
        configurable: true,
        value: function(chunkSize) {
          let r = [];
          for (let i = 0; i < this.length; i += chunkSize)
            r.push(this.slice(i, i + chunkSize));
          return r;
        }
      });
      // var number_of_chunk = (data.length / 10)
      this.page_number = ''
      let per_page = this.per_page
      this.chunkedData = data.chunk(per_page)
      this.page_number = this.chunkedData.length
      this.tabledata = this.chunkedData[0]
      this.loading = false
    },
    handlePageChange(val) {
      this.loading = true
      this.tabledata = this.chunkedData[val - 1]
      this.loading = false
    },
    handleSizeChange(val) {
      this.loading = true
      this.per_page = val
      this.loading = false
    },
  }
}
</script>

<style scoped>
.el-card {
    border: 1px solid rgba(0, 0, 0, 0.125) !important;
    /* border: none !important; */
    background-color: transparent !important;
}

span.card-title-course {
  /* height: 45px; */
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: N;
  line-height: X;
  max-height: X*N;
  text-transform: uppercase;
  font-family: revert;
  color: rgb(0 0 0 / 70%);
  font-weight: 400;
}

.course-card {
  margin-bottom: 10px;
  cursor: pointer;
  height: 215px;
  background-color: #fff !important;
}

.course-add-card {
  height: 215px;
  text-align: center;
  background-color: transparent !important;
}

.course-add-card i {
  font-size: 30px;
  font-weight: 100;
  vertical-align: middle;
  display: inline-block;
  position: relative;
  top: 50%;
  transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -webkit-transform: translateY(-50%);
  -o-transform: translateY(-50%);
}


</style>
