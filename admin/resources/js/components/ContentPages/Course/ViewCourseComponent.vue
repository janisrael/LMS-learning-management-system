<template>
    <el-col :span="24">
        <el-col ref="contentMargin" :span="24" class="content-margin">
            <el-card class="box-card layout-card" shadow="never">
                <div slot="header" class="clearfix" style="text-align: center;">
                    <div class="search-input-suffix" style="width: 100%">
                        <el-col :span="24">
                            <el-input placeholder="Search" class="input-with-select search-input" clearable v-model="search" style="max-width: 600px;">
                                <template slot="prepend">
                                    <el-popover
                                        placement="bottom-start"
                                        trigger="click">
                                        <div class="filter-data">
                                            <div class="filter-data-wrapper">
                                                <el-select v-model="filteredAuthors" multiple placeholder="Author" size="mini" style="margin-right: 10px;" clearable>
                                                    <el-option
                                                    size="mini"
                                                    v-for="item in this_authors"
                                                    :key="item.id"
                                                    :label="item.last_name + ' ' + item.first_name"
                                                    :value="item.id">
                                                    </el-option>
                                                </el-select>
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
                </div>
                <transition name="fade">
                    <div v-if="show" class="card-content">
                        <el-row :gutter="10" style="margin-bottom: 10px;">
                            <el-col :span="24">
                                <el-col :xs="24" :sm="8" :md="8" :lg="6" :xl="6">
                                    <el-card shadow="hover" border class="course-card course-add-card">
                                        <div @click="handleAdd()">
                                            <div style="height:215px;">
                                                <i class="el-icon-plus"></i>
                                            </div>
                                        </div>
                                    </el-card>
                                </el-col>
                                <el-col v-for="(course, i) in this_courses" :key="i" :xs="24" :sm="8" :md="8" :lg="6" :xl="6">
                                    <div class="course-card course-add-card md-card md-card-chart md-theme-default" @click="manageCourse(course)">

                                        <div v-if="course.course_image_url === null" class="no-image"> 
                                          <i class="el-icon-picture-outline"></i>
                                        </div>
                                        <div :style="{'background-image': 'url(' + course.attachment_absolute_path + ')'}" class="md-card-header animated md-card-header-blue" data-header-animation="true">
                                          <div v-if="course.is_featured" class="featured">
                                            <i class="fa fa-star feature-star" aria-hidden="false"></i>
                                          </div>
                                        </div>
                                        <div class="course-item-actions" data-header-animation="true">
                                            <el-col :span="8" class="course-item-action-icon">
                                                <i class="fas fa-edit" @click="handleEdit(course, i)"></i>
                                            </el-col>
                                            <el-col :span="8" class="course-item-action-icon">
                                                <i class="el-icon-s-grid" @click="manageCourse(course, i)" style="font-size: 16px !important;"></i>
                                            </el-col>
                                            <el-col :span="8" class="course-item-action-icon">
                                                <i class="fas fa-trash-alt" @click="handleDelete(course, i)"></i>
                                            </el-col>
                                        </div>
                                        <div style="padding: 14px; text-align: left;" class="course-card-details-wrapper">
                                            <h5 class="card-title-course" style="">{{ course.name }}</h5>
                                            <div class="bottom clearfix " style="color: #000;">
                                                <!-- <span>Category</span> -->
                                                <el-button type="primary" plain class="button" size="mini">
                                                    <span v-if="course.category">{{ course.category.name }}</span>
                                                    <span v-else> --- </span> 
                                                    <!-- <i class="el-icon-success"></i> -->
                                                </el-button>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                            </el-col>
                        </el-row>
                    </div>
                </transition>
            </el-card>
        </el-col>
        <!-- <currentComponent :is="currentComponent" :selected="manageData" @change_close="ManageClose"/> -->
    </el-col>
</template>

<script>
import CreateCourseComponent from "./CreateCourseComponent.vue";
// import ManageCourseComponent from './ManageCourseComponent.vue'
import { Notification } from "element-ui";
import Sortable from 'sortablejs';
export default {
    name: "ViewCourseComponent",
    components: {
        CreateCourseComponent,
        // ManageCourseComponent
    },
    data() {
        return {
            loading: false,
            search: '',
            currentComponent: null,
            passData: {},
            manageData: {},
            data: [],
            roles_and_permission: this.$store.state.user,
            author_id: null,
            show: false,
            current_route: this.$route.name,
            filters: ['Featured', 'Global', 'Live','Active'],
            selectedfilters: ['Active'],
            filteredAuthors: [],
            no_image: ''
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
        this.show = true
    },
    methods: {
        ManageClose(value) {
          console.log('asdsd')
          this.currentComponent = null
        },
        handleShowFilter() {

        },
        manageCourse(course, i) {
          // console.log('manage')
          // this.manageData = course
          // this.currentComponent = ManageCourseComponent
            let value = {
                mode: 'manage',
                data: course
            }
            this.$emit('change', value)

        },
        handleAdd() {
            let value = {
                mode: 'add',
                data: this.current_route
            }
            this.$emit('change', value)
        },
        handleDelete(row, i) {
          let value = {
              data: row,
              index: i
          }

          this.$confirm('Are you sure you want to delete this Course?', 'Warning', {
              confirmButtonText: 'Confirm',
              cancelButtonText: 'Cancel',
              type: 'warning'
          }).then(() => {
              this.$store.dispatch('DeleteFunction', value)
              // this.forms.get('/maintenance/delete/' + row.id)
              //     .then((response) => {
              //         let stat = response.data.status;
              //         Notification[stat]({
              //             title: stat.charAt(0).toUpperCase() + stat.slice(1),
              //             message: response.data.message,
              //             duration: 4 * 1000
              //         });
              //         this.getRecords();
              //     }).catch(() => {})
          }).catch(() => {
              // this.$message({
              //   type: 'info',
              //   message: 'Delete canceled'
              // });
          });
        },
        handleEdit(row,i) {
          localStorage.removeItem('reactiveData')
          localStorage.removeItem('action')
          localStorage.removeItem('subscriptions')
          this.passData = row
          row.index = i
          let value = {
              mode: 'edit',
              data: row
          }
          this.$emit('change', value)
        },
        ex_call_modal() {
            this.$refs.modalComponent.show()
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

h5.card-title-course {
    font-weight: 400 !important;
    padding-top: 0px !important;
    text-transform: capitalize;
    padding-bottom: 0px !important;
    color: #4c4c4c;
    font-family: revert !important;
}

.course-card {
    margin-bottom: 10px;
    cursor: pointer;
    height: 215px;
    background-color: #fff !important;
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px;
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
