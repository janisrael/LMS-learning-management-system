<template>
  <el-col :span="24">
<!--    <el-col :span="24" class="page-content-title">Maintenance Management - Schedule List</el-col>-->
    <el-col :span="24" class="content-margin">
      <el-card class="box-card layout-card">
        <div slot="header" class="clearfix">
          <div class="search-input-suffix" style="width: 100%">
            <el-col :span="24">
              <span class="search-input-label">Create New Lesson</span>
            
              <!-- <el-button type="success" size="mini" @click="handleAdd()" style="float:right"><i class="el-icon-plus"></i> Create</el-button> -->
            </el-col>
          </div>
        </div>
        <div class="card-content">
          <template>
            <el-tabs v-model="editableTabsValue" type="card" @tab-click="handleClick()">
                <el-tab-pane
                v-for="(item, index) in editableTabs"
                :key="index"
                :label="item.title"
                :name="item.name"
                  >   
                <!-- {{item.content}} -->
                 <component ref="modalComponent" :is="currentComponent" />
            </el-tab-pane>
            </el-tabs>
        
          </template>
        </div>
      </el-card>
    </el-col>

  </el-col>
</template>

<script>
import LessonContentComponent from './Tabs/LessonContentComponent.vue'
import LessonVideoComponent from './Tabs/LessonVideoComponent.vue'
import LessonResourcesComponent from './Tabs/LessonResourcesComponent.vue'
import LessonFAQComponent from './Tabs/LessonFaqComponent.vue'
import {Notification} from "element-ui";
export default {
  name: "CreateLessonComponent",
  components: {
    LessonContentComponent,
    LessonVideoComponent,
    LessonResourcesComponent,
    LessonFAQComponent
  },
  data() {
    return {
    form: {
        name: '',
        status: true,
        products: [],
        live: false,
        global: false,
        featured: false,
        description: '',
        desc: ''
    },
        editableTabsValue: 'content',
        editableTabs: [{
          title: 'Content',
          name: 'content',
          content: 'content desc'
        }, {
          title: 'Video',
          name: 'video',
          content: 'video desc'
        },
         {
          title: 'Resources',
          name: 'resources',
          content: 'resources desc'
        },
         {
          title: 'FAQ`s',
          name: 'faqs',
          content: 'faqs desc'
        }
    ],
        tabIndex: 2,
      loading: false,
      search: '',
      currentComponent: LessonContentComponent,
      passData: {},
      total: 0,
      data: [],
      enties: 10,
      tabledata: [],
      forms: new Form({
        id: 0,
        schedule: '',
        schedule_start: '',
        schedule_end: '',
        message : '',
        notification_display_datetime: '',
        notification_message: '',
        auto_up_on_schedule_end: '',
        action_id: '',
        is_active: '',
        updated_by: '',
        added_by: ''
      }),
      listQuery: {
        page: 1,
        limit: 20
      },
      chunkedData: '',
      per_page: 10,
      page_number: 0,
      colwidth: '150',
      roles_and_permission: this.$store.state.user
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
        this.filterRecord()
      }
    }
  },
  created: function() {
    // this.handleResize();
    this.loading = true
    // this.getRecords()
  },
  methods: {
    handleClick() {
        console.log(this.editableTabsValue)
        this.currentComponent = null
        if(this.editableTabsValue === 'content') {
            this.currentComponent = LessonContentComponent
        }
        if(this.editableTabsValue === 'video') {
            this.currentComponent = LessonVideoComponent
        }
        if(this.editableTabsValue === 'resources') {
            this.currentComponent = LessonResourcesComponent
        }
        if(this.editableTabsValue === 'faqs') {
            this.currentComponent = LessonFAQComponent
        }
    },
    onSubmit() {

    },
    handleCancel() {
      this.$router.push('/lesson-management/all-lessons');
    },
    handleAdd() {
      this.currentComponent = CreateComponent
      setTimeout(() => this.ex_call_modal(), 1)
    },
    handleResize() {
      // console.log(window.innerWidth);
      let windowWidth = window.innerWidth
      if(windowWidth <= 768) {
        this.colwidth = '180'
      }
      // this.window.height = window.innerHeight;
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
    filterTag(value, row) {
      return row.is_active === value
    },
    filterTagAuto(value, row) {
      return row.auto_up_on_schedule_end === value
    },
    handleEdit(row) {
      this.passData = row
      this.currentComponent = EditComponent
      setTimeout(() => this.ex_call_modal(), 1)
    },
    ex_call_modal() {
      this.$refs.modalComponent.show()
    },
    emitChange() {
      this.currentComponent = null
      this.getRecords()
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
    getDuration(start, end) {
      // var end = end
      // var start = start
      let newend = new Date(end);
      let newstart = new Date(start);
      // var timeint = x - y
      let diff = Math.abs(newend - newstart);  // difference in milliseconds

      this.milisec = diff
      let days = Math.floor(diff / (1000 * 60 * 60 * 24));
      let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      let seconds = Math.floor((diff % (1000 * 60)) / 1000);

      // console.log(hours, minutes, seconds)
      this.curDays = days
      this.curHours = hours
      this.curMin = minutes
      this.curSec = seconds

      return days + 'd: ' + hours + 'h: ' + minutes + 'm: ' + seconds + 's'
    }
  }
}
</script>

<style scoped>

</style>
