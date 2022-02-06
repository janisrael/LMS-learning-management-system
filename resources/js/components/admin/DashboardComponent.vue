<template>
  <el-col :span="24">
      <el-col :span="24" class="content-margin">
        <el-card class="box-card layout-card">
          <div class="card-content">
            <h4>Welcome {{ userInfo.data.name }} as
              <span v-for="(role, i) in userInfo.data.role" :key="i">
                {{ role.name }}
              </span>
            </h4>
            <span>last login: {{ userInfo.data.last_login_at | moment }}</span>
          </div>
        </el-card>
<!--        <el-col :span="24">-->
<!--          <el-col :span="12" style="margin-bottom: 20px;">-->
<!--            <el-card class="box-card dashboard-card" shadow="never">-->
<!--              <div slot="header" class="clearfix">-->
<!--                <span style="display: block; padding: 5px 0">Upcoming Maintenance</span>-->
<!--              </div>-->
<!--              <div class="card-content">-->
<!--                <el-collapse v-model="activeName" accordion class="dashboard-collapse">-->
<!--                  <el-collapse-item v-for="(maintenance, index) in upcoming" :key="index" name="1" class="collapse-container">-->
<!--&lt;!&ndash;                    <template v-if="maintenance.schedule_start === 'yes'" slot="title">&ndash;&gt;-->
<!--&lt;!&ndash;                      <i class="header-icon el-icon-timer" style="font-size: 39px !important;"></i> <span class="dashboard-collapse-title">{{ maintenance.schedule_start | moment }} </span>&ndash;&gt;-->
<!--&lt;!&ndash;                    </template>&ndash;&gt;-->
<!--                    <template slot="title">-->
<!--                      <i class="header-icon el-icon-timer" style="font-size: 39px !important;"></i> <span class="dashboard-collapse-title">{{ maintenance.schedule_start | moment }} </span>-->
<!--                    </template>-->
<!--                    <div>Consistent with real life: in line with the process and logic of real life, and comply with languages and habits that the users are used to;</div>-->
<!--                    <div>Consistent within interface: all elements should be consistent, such as: design style, icons and texts, position of elements, etc.</div>-->
<!--                  </el-collapse-item>-->
<!--                </el-collapse>-->
<!--              </div>-->
<!--&lt;!&ndash;              <template>&ndash;&gt;-->
<!--&lt;!&ndash;                <el-table&ndash;&gt;-->
<!--&lt;!&ndash;                  :data="upcoming"&ndash;&gt;-->
<!--&lt;!&ndash;                  :default-sort = "{ prop: 'schedule_start', order: 'ascending' }"&ndash;&gt;-->
<!--&lt;!&ndash;                  style="width: 100%">&ndash;&gt;-->
<!--&lt;!&ndash;                  <el-table-column&ndash;&gt;-->
<!--&lt;!&ndash;                    prop="schedule_start"&ndash;&gt;-->
<!--&lt;!&ndash;                    label="Schedule Start"&ndash;&gt;-->
<!--&lt;!&ndash;                    width="180">&ndash;&gt;-->
<!--&lt;!&ndash;                    <template slot-scope="scope">&ndash;&gt;-->
<!--&lt;!&ndash;                      {{ scope.row.schedule_start | moment }}&ndash;&gt;-->
<!--&lt;!&ndash;                    </template>&ndash;&gt;-->
<!--&lt;!&ndash;                  </el-table-column>&ndash;&gt;-->
<!--&lt;!&ndash;                  <el-table-column&ndash;&gt;-->
<!--&lt;!&ndash;                    prop="schedule_end"&ndash;&gt;-->
<!--&lt;!&ndash;                    label="Schedule End"&ndash;&gt;-->
<!--&lt;!&ndash;                    width="180">&ndash;&gt;-->
<!--&lt;!&ndash;                    <template slot-scope="scope">&ndash;&gt;-->
<!--&lt;!&ndash;                      {{ scope.row.schedule_end | moment }}&ndash;&gt;-->
<!--&lt;!&ndash;                    </template>&ndash;&gt;-->
<!--&lt;!&ndash;                  </el-table-column>&ndash;&gt;-->
<!--&lt;!&ndash;                  <el-table-column&ndash;&gt;-->
<!--&lt;!&ndash;                    prop="ticket_no"&ndash;&gt;-->
<!--&lt;!&ndash;                    label="Ticket No">&ndash;&gt;-->
<!--&lt;!&ndash;                  </el-table-column>&ndash;&gt;-->
<!--&lt;!&ndash;                </el-table>&ndash;&gt;-->
<!--&lt;!&ndash;              </template>&ndash;&gt;-->
<!--            </el-card>-->
<!--          </el-col>-->
<!--          <el-col :span="12" style="margin-bottom: 20px;">-->
<!--            <el-card class="box-card" shadow="never">-->
<!--              <div slot="header" class="clearfix">-->
<!--                <span style="display: block; padding: 5px 0">Marketing</span>-->
<!--              </div>-->
<!--              <el-col :span="24" style="margin-bottom: 20px;">-->
<!--                <el-col :span="12" style="margin-bottom: 20px;">-->
<!--                  <el-avatar icon="el-icon-user-solid"></el-avatar>-->
<!--                  <span>EverWebinar: 4</span>-->
<!--                </el-col>-->
<!--                <el-col :span="12" style="margin-bottom: 20px;">-->
<!--                  <el-avatar icon="el-icon-user-solid"></el-avatar>-->
<!--                  <span>Checkout Pages: 4</span>-->
<!--                </el-col>-->
<!--              </el-col>-->
<!--            </el-card>-->
<!--          </el-col>-->
<!--        </el-col>-->
      </el-col>

<!--  <el-col :span="24" class="page-content-title">Dashboard</el-col>-->


<!--  </el-row>-->
<!--{{ roles_and_permission.permissions }}-->
<!--    <span v-for="role in roles_and_permission.permissions">-->
<!--      <div v-for="x in role">-->
<!--            {{ x.permission }}-->
<!--      </div>-->

<!--    </span>-->
  <!-- <el-col :span="24" class="content-margin">
    <el-col :span="12">
      <el-card class="box-card" shadow="never">
        <div slot="header" class="clearfix">
          <span style="display: block; padding: 5px 0px;">This Months Maintenance ( {{ filteredData.length }} )</span>
        </div>
        <template>
          <el-table
            :data="filteredData"
            :default-sort = "{ prop: 'schedule_start', order: 'ascending' }"
            :row-class-name="tableRowClassName"
            style="width: 100%; cursor: pointer;">
            <el-table-column
              prop="schedule_start"
              label="Schedule Start"
              width="180">
              <template slot-scope="scope">
                {{ scope.row.schedule_start | moment }}
              </template>
            </el-table-column>
            <el-table-column
              prop="schedule_end"
              label="Schedule End"
              width="180">
              <template slot-scope="scope">
                {{ scope.row.schedule_end | moment }}
              </template>
            </el-table-column>
            <el-table-column
              prop="ticket_no"
              label="Ticket No">
            </el-table-column>
            <el-table-column
              prop="status"
              label="Status">
              <template slot-scope="scope">
                  <el-tag v-if="scope.row.status === 'no'" type="primary" size="small" effect="dark">Active</el-tag>
                  <el-tag v-if="scope.row.status === 'yes'" type="success" size="small" effect="dark">On Going</el-tag>
              </template>
            </el-table-column> -->
            <!-- <el-table-column
              prop="time_range"
     </el-col>
      <el-col :span="12" style="margin-bottom: 20px;">
        <el-card class="box-card" shadow="never">
          <div slot="header" class="clearfix">
            <span style="display: block; padding: 5px 0">Upcoming Maintenance</span>
          </div>
          <template>
            <el-table
              :data="upcoming"
              :default-sort = "{ prop: 'schedule_start', order: 'ascending' }"
              style="width: 100%">
              <el-table-column
                prop="schedule_start"
                label="Schedule Start"
                width="180">
                <template slot-scope="scope">
                  {{ scope.row.schedule_start | moment }}
                </template>
              </el-table-column>
              <el-table-column
                prop="schedule_end"
                label="Schedule End"
                width="180">
                <template slot-scope="scope">
                  {{ scope.row.schedule_end | moment }}
                </template>
              </el-table-column>
              <el-table-column
                prop="ticket_no"
                label="Ticket No">
              </el-table-column>
            </el-table>
          </template>
        </el-card>
      </el-col>
      <el-col :span="12">
        <el-card class="box-card" shadow="never">
          <div slot="header" class="clearfix">
            <span style="display: block; padding: 5px 0;">Previous Maintenance</span>
          </div>
          <template>
            <el-table
              :data="prev_schedule"
              :default-sort = "{ prop: 'schedule_start', order: 'ascending' }"
              style="width: 100%">
              <el-table-column
                prop="schedule_start"
                label="Schedule Start"
                width="180">
                <template slot-scope="scope">
                  <span v-if="prev_schedule">{{ scope.row.schedule_start | moment }}</span>
                </template>
              </el-table-column>
              <el-table-column
                prop="schedule_end"
                label="Schedule End"
                width="180">
                <template slot-scope="scope">
                  <span v-if="prev_schedule">{{ scope.row.schedule_end | moment }}</span>
                </template>
              </el-table-column>
              <el-table-column
                prop="ticket_no"
                label="Ticket No">
              </el-table-column>
              <el-table-column
                prop="time_range"
                label="Time Range"
                width="180">
                <template slot-scope="scope">
                  {{ scope.row.time_range }}
                </template>
              </el-table-column> -->
            <!-- </el-table>
          </template>
        </el-card>
      </el-col>
      label="Time Range">
            </el-table-column> -->
          <!-- </el-table>
        </template>
      </el-card> -->
<!--{{ filteredData }}-->

  <!-- </el-col> -->
<!--  </el-row>-->
  </el-col>
</template>

<script>
  export default {
    name: "DashboardComponent",
    props: {
      allowed_views: {
        required: false,
        type: Array
      },
      userdetails: {
        required: false,
        type: Object
      }
    },
    data() {
      return {
        tableData: [{
          date: '2016-05-03',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-02',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-04',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }, {
          date: '2016-05-01',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles'
        }],
        data: [],
        loading: false,
        search: 9,
        test: [],
        month: '',
        year: '',
        filteredData: [],
        prev_schedule: [],
        upcoming: [],
        active_maintenance: [],
        url: window.ENV.APP_URL,
        roles_and_permission: {},
        userInfo: this.$store.state,
        activeName: '1'
      }
    },
    filters: {
      moment: function (date) {
        return moment(date).format('lll');
      }
    },
    created: function() {
      this.mapdata()
      // this.getRecords()
    },
    methods: {
      mapdata(){
        this.roles_and_permission = this.$store.state.user
        // setTimeout(() => this.ex_call_modal(), 300)
        var i;
        let data = ''
        const wait=ms=>new Promise(resolve => setTimeout(resolve, ms));
        wait(2*100).then(() => {
          if(this.userInfo.data) {
            data = this.userInfo.data
          } else {
            throw new Error("error occurred");
          }
        }).catch(() => {
          console.log("This is failure callback");
        });
      },
      ex_call_modal() {
        console.log(this.userInfo.data ,'data')
      },
      tableRowClassName({ row, rowIndex }) {
      // console.log(row)
      if (row.status === 'yes') {
        return 'status-active'
      } else {
        return 'status-normal'
      }
    },
      getRecords: function() {
        var AjaxUrl = "/maintenance";
        axios.get(AjaxUrl)
          .then(response => {
            this.data = response.data.data; // add data to the response
            this.year = new Date().getFullYear()
            var now = new Date()
            this.month = (new Date().getMonth() + 1).toString().padStart(2, "0")
            var sorted = this.data.sort(function(a, b) { return new Date(a.schedule_start) - new Date(b.schedule_start) })
            var arr = []
            var future = []
            var past = []
            var active = []
            this.data.forEach((value, index) => {
              if(value.is_active === 1 || value.is_active === '1') {
                var d1 = new Date(value.schedule_start)
                var d2 = new Date(value.schedule_end)
                if(d1.getTime() >= now) {
                  future.push(value)
                }
                if(d1.getTime() < now) {
                  past.push(value)
                }
                if(d1.getTime() <= now && d2.getTime() >= now) {
                  active.push(value)
                  this.data[index]['status'] = 'yes'
                } else {
                  this.data[index]['status'] = 'no'
                }
                if ((moment(value.schedule_start).format('YYYY') === String(this.year)) === true && (moment(value.schedule_start).format('MM') === String(this.month)) === true) {
                  arr.push(value)
                }
                var t = this.convertTime(value.schedule_start, value.schedule_end)
                this.data[index]['time_range'] = t
              }
            })
            var id = ''
            past.forEach((value, index) => {
              if((past.length - 1) === index) {
                 id = value.ticket_no
              }
            })
            this.active_maintenance = active
            this.upcoming = future

            var p = []
            p.push(sorted.find(o => o.ticket_no === id))
            var time = this.convertTime(p[0].schedule_start, p[0].schedule_end)
            p[0]['time_range'] = time
            this.prev_schedule = p
            // console.log(arr,'future')
            this.filteredData = arr
            // this.filteredData = this.data | moment
            this.loading = false
          });
      },
      convertTime(start, end) {
        var now  = new Date(start);
        var then = new Date(end);

        var ms = moment(then,"DD/MM/YYYY HH:mm:ss").diff(moment(now,"DD/MM/YYYY HH:mm:ss"));
        var d = moment.duration(ms);
        var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
        return s
      }
    }
  }
</script>

<style scoped>

</style>
