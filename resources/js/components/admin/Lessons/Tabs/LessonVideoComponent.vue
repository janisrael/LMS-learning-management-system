<template>
  <el-col :span="24">
    <template>
    <el-form ref="form" :model="form" label-width="170px">
        <el-form-item label="Video URL">
        <div>
            <el-input placeholder="Please input" v-model="video_url">
                <template slot="prepend">Http://</template>
            </el-input>
        </div>
        </el-form-item>
            <el-form-item label="Preview Video URL">
            <div>
                <el-input placeholder="Please input" v-model="p_video_url">
                <template slot="prepend">Http://</template>
                </el-input>
            </div>
        </el-form-item>
    
        <el-row>
            <el-col :span="24">
                <el-form-item style="float:right;">
                    <el-button type="primary" @click="onSubmit">Create</el-button>
                    <el-button @click="handleCancel()">Cancel</el-button>
                </el-form-item>
            </el-col>
        </el-row>
        </el-form>
    </template>
  </el-col>
</template>

<script>
export default {
  name: "LessonVideoComponent",
//   components: {
//     EditComponent,
//     CreateComponent
//   },
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
      video_url: '',
      p_video_url: '',
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
