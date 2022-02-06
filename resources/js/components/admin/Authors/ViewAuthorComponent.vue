<template>
  <el-col :span="24">
<!--    <el-col :span="24" class="page-content-title">Maintenance Management - Schedule List</el-col>-->
    <el-col :span="24" class="content-margin">
      <el-card class="box-card layout-card">
        <div slot="header" class="clearfix">
          <div class="search-input-suffix" style="width: 100%">
            <el-col :span="24">
              <span class="search-input-label">Search:</span>
              <el-input
                placeholder=""
                class="search-input"
                size="small"
                clearable
                prefix-icon="el-icon-search"
                v-model="search"
                style="max-width: 300px">
              </el-input>
              <div style="display: inline-block;">
                show
                <el-select v-model="per_page" placeholder="Select" size="small" style="width: 70px;" @change="chunkData(data)">
                  <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                  </el-option>
                </el-select>
                entries
              </div>
              <el-button type="success" size="mini" @click="handleAdd()" style="float:right"><i class="el-icon-plus"></i> New Author</el-button>
            </el-col>
          </div>
        </div>
        <div class="card-content">
          <template>
            <el-table
              v-loading="loading"
              :data="tabledata"
              :row-class-name="tableRowClassName"
              border
              style="width: 100%">
              <el-table-column
                prop="ticket_no"
                label="Ticket #"
                :width="colwidth">
                <template slot-scope="scope">
                  <i v-if="scope.row.status === 'yes'" class="fa fa-caret-right" aria-hidden="true" style="color: #f56c6b;"></i>
                  <el-link type="primary" @click="handleEdit(scope.row)">{{ scope.row.ticket_no }}</el-link>
                </template>
              </el-table-column>
              <el-table-column
                prop="message"
                label="Name"
                min-width="450">
                <template slot-scope="scope">
                   <el-popover
                    placement="right"
                    title="Message"
                    width="600"
                    trigger="click">
                     <div style="display: block; width: 100%;">
                       <p class="popover-message">{{scope.row.message}}</p>
                     </div>
                    <el-link slot="reference" class="table_message_link" style="white-space:nowrap; text-overflow: ellipsis; max-width: 400px;display: block; cursor: pointer;">{{ scope.row.message }}</el-link>
                  </el-popover>
                </template>
              </el-table-column>
              <el-table-column
                :filters="[{ text: 'Active', value: '1' }, { text: 'Inactive', value: 0 }]"
                :filter-method="filterTag"
                filter-placement="bottom-end"
                prop="is_active"
                label="Status"
                width="100">
                <template slot-scope="scope">
                  <el-tag v-if="scope.row.is_active === '0' || scope.row.is_active === 0" type="danger" size="small" effect="dark">Inactive</el-tag>
                  <el-tag v-if="scope.row.is_active === '1' || scope.row.is_active === 1" type="success" size="small" effect="dark">Active</el-tag>
                </template>
              </el-table-column>
              <el-table-column
                label="Action"
                fixed="right"
                width="120">
                <template slot-scope="scope">
                  <el-button-group>
                    <el-button type="primary" size="mini" @click="handleEdit(scope.row)"><i class="el-icon-edit"></i></el-button>
                    <el-button type="danger" size="mini" @click="handleDelete(scope.row)"><i class="el-icon-delete"></i></el-button>
                  </el-button-group>
                </template>
              </el-table-column>
            </el-table>
            <div style="display: block; margin: 20px auto;">
              <el-pagination
                @size-change="handleSizeChange"
                background
                :total="total"
                :page-sizes="[10, 25, 50, 100]"
                :page-size="per_page"
                :page.sync="page_number"
                :limit.sync="listQuery.limit"
                layout="total, prev, pager, next, jumper"
                @current-change="handlePageChange"/>
            </div>
          </template>
        </div>
      </el-card>
    </el-col>
    <!-- <component ref="modalComponent" :is="currentComponent" :selected="passData" @changed="emitChange()"/> -->
  </el-col>
</template>

<script>
//   import EditComponent from './Form/EditComponent.vue'
  // import CreateQuizComponent from "./CreateQuizComponent.vue";
  import {Notification} from "element-ui";
export default {
  name: "ViewAuthorComponent",
  data() {
    return {
      loading: false,
      search: '',
      currentComponent: null,
      passData: {},
      total: 0,
      data: [],
      enties: 10,
      options: [
        {
          value: 10,
          label: '10'
        },
        {
          value: 25,
          label: '25'
        },
        {
          value: 50,
          label: '50'
        },
        {
          value: 100,
          label: '100'
        }
      ],
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
    this.handleResize();
    this.loading = true
    this.getRecords()
  },
  methods: {
    handleAdd() {
        this.$router.push('/course-management/create-new-course');
    //   this.currentComponent = CreateCourseComponent
    //   setTimeout(() => this.ex_call_modal(), 1)
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
    filterRecord() {
      let newdata = []
      if(this.search.length === 0) {
        this.tabledata = this.data
      }
      this.tabledata.forEach((value) => {
        if(value.ticket_no.includes(this.search) || value.message.includes(this.search)) {
          newdata.push(value)
        }
      })
      this.tabledata = newdata
      this.loading = false
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
    getRecords: function() {
      let AjaxUrl = "/maintenance";
      let now = new Date()
      axios.get(AjaxUrl)
        .then(response => {
          if(response.data.hasOwnProperty('status')){
            if(response.data.status === 'error') {
              this.$router.push({name: 'error.403'});
            } else {
              let stat = response.data.status;
              Notification[stat]({
                title: stat.charAt(0).toUpperCase() + stat.slice(1),
                message: response.data.message,
                duration: 4 * 1000
              });
            }
          } else {
            this.data = response.data.data; // add data to the response
            this.total = response.data.recordsTotal
            this.data.forEach((value, index) => {
              let d1 = new Date(value.schedule_start)
              let d2 = new Date(value.schedule_end)
              if(d1.getTime() <= now && d2.getTime() >= now) {
                // active.push(value)
                this.data[index]['status'] = 'yes'
              } else {
                this.data[index]['status'] = 'no'
              }
              this.data[index]['duration'] = this.getDuration(value.schedule_start, value.schedule_end)
            })
            this.chunkData(this.data)
            this.loading = false
          }
        })
        .catch( error => {
          // this.has_error = true
          // this.error_details = error.response.data
          // this.error_title = error.response.data.message
          // this.errors = error.response.data.errors
          // this.loading = false
          this.$Progress.finish()
        });
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
