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
              <!-- <span class="search-input-label">List of Chapters</span> -->
              <el-button type="success" size="mini" @click="handleAdd()" style="float:right"><i class="el-icon-plus"></i> New Chapter</el-button>
            </el-col>
          </div>
        </div>

        <div class="card-content">
          <template>
              <el-table ref="dragTable" v-loading="loading" :data="chapterlist" row-key="id" border fit highlight-current-row style="width: 100%">
                <el-table-column align="left" label="Drag" width="50">
                  <template slot-scope="{}">
                   <i class="fas fa-arrows-alt"></i>
                  </template>
                </el-table-column>
                <el-table-column align="center" label="Chapter Number" width="200">
                  <template slot-scope="scope">
                    <span>{{ scope.row.chapter_num }}</span>
                  </template>
                </el-table-column>
                <el-table-column align="center" label="Chapter Name">
                  <template slot-scope="scope">
                    <span>{{ scope.row.name }}</span>
                  </template>
                </el-table-column>
                <el-table-column width="450" align="left" label="Description">
                  <template slot-scope="scope">
                    <span>{{ scope.row.description }}</span>
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
                <el-table-column width="150" align="left" label="Status">
                  <template slot-scope="{row}">
                    <!-- <span>{{ row.age }}</span> -->
                      <el-switch
                      v-model="row.status">
                    </el-switch>
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
                :total="meta.total"
                :page-sizes="[10, 25, 50, 100]"
                :page-size="meta.per_page"
                :page.sync="meta.page"
                :limit.sync="listQuery.limit"
                layout="total, prev, pager, next, jumper"
                @current-change="handlePageChange"/>
            </div>
          </template>
        </div>
      </el-card>
    </el-col>
  </el-col>
</template>

<script>
//   import EditComponent from './Form/EditComponent.vue'
  import CreateChapterComponent from "./CreateChapterComponent.vue";
  import Sortable from 'sortablejs';
  import {Notification} from "element-ui";
  export default {
  name: "ViewChapterComponent",
  // filters: {
  //   statusFilter(status) {
  //     const statusMap = {
  //       published: 'success',
  //       draft: 'info',
  //       deleted: 'danger'
  //     }
  //     return statusMap[status]
  //   }
  // },
  components: {
    CreateChapterComponent
  },
  data() {
    return {
      loading: false,
      search: '',
      currentComponent: null,
      // total: 0,
      data: [],
      total: null,
      listQuery: {
        page: 1,
        limit: 10
      },
      value: true,
      sortable: null,
      oldList: [],
      newList: [],

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
      roles_and_permission: this.$store.state.user,
      chapterlist: [],
      meta: {
        total: 0,
        page: 0,
        per_page: 0
      }
    }
  },
//   filters: {
//     moment: function (date) {
//       return moment(date).format('lll');
//     }
//   },
  watch: {
    search: function() {
      this.loading = true
      if (this.search.length >= 1 || this.search.length === 0) {
        this.filterRecord()
      }
    }
  },
  created: function() {
    this.loading = true
    this.getRecords()
  },
  methods: {
    handleAdd() {
      this.$router.push('/chapter-management/create-chapter');
    },
    tableRowClassName({ row }) {
      if (row.status === 'yes') {
        return 'status-active'
      } else {
        return 'status-normal'
      }
    },
    filterTag(value, row) {
      return row.is_active === value
    },
    filterTagAuto(value, row) {
      return row.auto_up_on_schedule_end === value
    },
    handlePageChange() {

    },
    handleSizeChange() {

    },
    getRecords: function() {
      let url = "/api/chapters";
      let now = new Date()
      axios.get(url)
        .then(response => {
          console.log(response)
          this.chapterlist = response.data.chapter; // add data to the response
          this.meta = response.data.meta
          this.loading = false
        })
        .catch( error => {
          // this.has_error = true
          // this.error_details = error.response.data
          // this.error_title = error.response.data.message
          // this.errors = error.response.data.errors
          // this.loading = false
          // this.$Progress.finish()
        });
    },
    // getList() {
    //   this.listLoading = true
    //   // this.total = data.total
    //   this.listLoading = false
    //   this.oldList = this.list.map(v => v.id)
    //   this.newList = this.oldList.slice()
    //   this.$nextTick(() => {
    //     this.setSort()
    //   })
    // },
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
          const targetRow = this.list.splice(evt.oldIndex, 1)[0]
          this.list.splice(evt.newIndex, 0, targetRow)
          // for show the changes, you can delete in you code
          const tempIndex = this.newList.splice(evt.oldIndex, 1)[0]
          this.newList.splice(evt.newIndex, 0, tempIndex)
        }
      })
    },
  }
}
</script>

<style scoped>
.sortable-ghost{
  opacity: .8;
  color: #fff!important;
  background: #42b983!important;
}
.icon-star{
  margin-right:2px;
}
.drag-handler{
  width: 20px;
  height: 20px;
  cursor: pointer;
}
.show-d{
  margin-top: 15px;
}
</style>
