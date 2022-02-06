<template>
  <el-col :span="24">
    <template>
    <el-form ref="forms" :model="forms">
        <el-row>
          <el-form-item >
          <el-col :span="24" style="text-align: center;">
            <el-card v-if="resource.length === 0" class="box-card">   
              <div class="card-content" style="padding-top:20px; width: 100%; font-size: 20px; cursor:pointer;" @click="handleAdd()">
                <span ><i class="el-icon-plus"></i> Add Resource</span>
              </div>
            </el-card>
            <div v-else v-for="(re, index) in resource" :key="index">
              <el-card class="box-card">
                {{ re.name }}
              </el-card>
            </div>
          </el-col>
          </el-form-item>
        </el-row>
        <el-row>
            <el-col :span="24">
                <el-form-item style="float:right;">
                    <el-button type="primary" @click="onSubmit">Create</el-button>
                    <el-button @click="handleCancel()">Cancel</el-button>
                </el-form-item>
            </el-col>
        </el-row>
      </el-form>
      <el-dialog
        title="Add Resource"
        :visible.sync="addDialog"
        width="40%">
          <el-row>
            <el-form ref="form" :model="form" label-width="120px">
              <el-col :span="24">
                <el-col :xs="24" :sm="24" :md="24" :lg="24" :xl="24">
                  <el-form-item label="Name:" required>
                    <el-input type="textarea" v-model="textarea" clearable></el-input>
                  </el-form-item>
                </el-col>
              </el-col>
              <el-col :xs="24" :sm="24" :md="24" :lg="12" :xl="12">
                <el-form-item prop="avatar" label="Attachment:">
                  <!-- <el-input type="file" v-model="image" id="avatar" name="avatar" @change="avatarSelected($event)" accept="image/*" label="Image"></el-input> -->
                  <div class="input-file">
                    <el-input ref="file" type="file" v-model="image" id="avatar" @change="avatarSelected($event)" style="display:none;" accept="pdf/*" label="Image"></el-input>
                    <el-button slot="trigger" size="small" type="primary"  @click="openAttachment()">Click to upload</el-button>
                    <div slot="tip" class="el-upload__tip" v-if="!busy" style="line-height: 1.5;">{{ avatar_name ? avatar_name : '' }}</div> 
                  </div>
                </el-form-item>
              </el-col>
            </el-form>
          </el-row>
        <span slot="footer" class="dialog-footer">
          <el-button @click="addDialog = false">Cancel</el-button>
          <el-button type="primary" @click="addDialog = false">Confirm</el-button>
        </span>
      </el-dialog>


    </template>
  </el-col>
</template>

<script>
export default {
  name: "LessonResourcesComponent",
//   components: {
//     EditComponent,
//     CreateComponent
//   },
  data() {
    return {
    form: new Form( {
        name: '',
        status: true,
        products: [],
        live: false,
        global: false,
        featured: false,
        description: '',
        desc: '',
        avatar: ''
    }),
        ruleForm: {
          username: '',
          email: '',
          password: '',
          password_confirmation: '',
          is_active: true,
          permissions: {
            profile_update: false,
          },
          profile: {
            name: '',
            sf_id: '',
            user_group_id: '',
            region: '',
            mobile_number: '',
            employee_id: '',
            immediate_head: '',
            job_title: '',
            organization: '',
            avatar: '',
            address: '',
            branch: ''            
          }
        },
    image: '',
    textarea:'',
            avatar: null, 
        image: null,
        busy: false,
        avatar_name: '',
      addDialog: false,
      loading: false,
      search: '',
      currentComponent: null,
      passData: {},
      total: 0,
      data: [],
      enties: 10,
      resource: [],
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
    avatarSelected(e) {
      this.busy = true;
      const image = event.target.files[0];
      if(image){
        this.avatar_name = image.name;
        const reader = new FileReader()
        reader.readAsDataURL(image)
        reader.onload = e => {
            this.avatar = event.target.result
        }
      }
      this.busy = false;
    },
    openAttachment(){
      document.getElementById("avatar").click()
    },
    handleClick() {
        console.log(this.editableTabsValue)
    },
    onSubmit() {

    },
    handleCancel() {
      this.$router.push('/lesson-management/all-lessons');
    },
    handleAdd() {
      this.addDialog = true
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
