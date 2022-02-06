<template>
    <el-col :span="24">
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
                    style="max-width: 300px;">
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
                  <el-button type="success" size="mini" @click="handleAdd()" style="float:right"><i class="el-icon-plus"></i></el-button>
                </el-col>
              </div>
            </div>
            <div class="card-content">
              <div v-if="no_access === false">
              <template>
                <el-table
                  v-loading="loading"
                  :data="tabledata"
                  border
                  style="width: 100%">
                  <el-table-column
                    prop="name"
                    sortable
                    label="Name"
                    min-width="200"
                    :width="colwidth">
                    <template slot-scope="scope">
                      <el-link type="primary" @click="handleEdit(scope.row)">{{ scope.row.name }}</el-link>
                    </template>
                  </el-table-column>
                  <el-table-column
                    prop="description"
                    sortable
                    label="Description"
                    min-width="200">
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
                    prop="created_at"
                    sortable
                    label="Date Created"
                    width="150">
                    <template slot-scope="scope">
                      <span>{{ scope.row.created_at | moment }}</span>
                    </template>
                  </el-table-column>
                  <el-table-column
                    prop="updated_at"
                    sortable
                    label="Date Updated"
                    width="150">
                    <template slot-scope="scope">
                      <span>{{ scope.row.updated_at | moment }}</span>
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
              <div v-else>
                  <el-tag type="danger">{{ no_access_msg }}</el-tag>
              </div>
            </div>
          </el-card>
        </el-col>
        <component ref="modalComponent" :is="currentComponent" :selected="passData" @changed="emitChange()"/>
    </el-col>
</template>

<script>
  import EditUserGroupComponent from "./Form/EditUserGroupComponent";
  import CreateUserGroupComponent from "./Form/CreateUserGroupComponent";
  import { Notification } from 'element-ui'
  export default {
    name: "ViewComponent",
    components: {
      EditUserGroupComponent,
      CreateUserGroupComponent
    },
    data() {
      return {
        loading: false,
        search: '',
        no_access: false,
        no_access_msg: '',
        currentComponent: null,
        passData: {},
        per_page: 10,
        total: 0,
        options: [
          {
            value: 10,
            label: '10'
          },
          {
            value: 25,
            label: 25
          },
          {
            value: 50,
            label: '50'
          },
          {
            value: 100,
            label: 100
          }
        ] ,
        data: [],
        tabledata: [],
        listQuery: {
          page: 1,
          limit: 20
        },
        chunkedData: '',
        page_number: 0,
        forms: new Form({
          id: '',
          name: '',
          description: '',
          is_active: ''
        }),
        colwidth: '',
        ecolwidth: ''
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
      // window.addEventListener('resize', this.handleResize);
       this.handleResize()
       this.loading = true
       this.getRecords()
    } ,
    methods: {
      handleResize() {
        var windowWidth = window.innerWidth
        if(windowWidth <= 768) {
          this.colwidth = '200'
          this.ecolwidth = '200'
        }
        // this.window.height = window.innerHeight;
      },
      filterTag(value, row) {
        return row.is_active === value
      },
      handleDelete(row) {
        this.forms.fill(row)
        this.$confirm('Are you sure you want to delete this User Group?', 'Warning', {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }).then(() => {
          this.forms.get('/user-group/delete/' + row.id)
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
      handleAdd() {
        this.currentComponent = CreateUserGroupComponent
        setTimeout(() => this.ex_call_modal(), 1)
      },
      handleEdit(row) {
        this.passData = row
        console.log(row)
        this.currentComponent = EditUserGroupComponent
        setTimeout(() => this.ex_call_modal(), 1)
      },
      ex_call_modal() {
        this.$refs.modalComponent.show()
      },
      filterRecord() {
        var newdata = []
        if(this.search.length === 0) {
          this.tabledata = this.data
        }
        this.tabledata.forEach((value, index) => {
          if(value.description.includes(this.search) || value.name.includes(this.search)) {
            newdata.push(value)
          }
        })
        this.tabledata = newdata
        this.loading = false
      },
      getRecords() {
        var AjaxUrl = "/user-group";
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
              this.chunkData(this.data)
            }
            this.loading = false
          }).catch(error => {
            this.no_access = true
            this.no_access_msg = error.response.data.message
            this.loading = false
          })
      },
      chunkData(data) {
        this.loading = true
        Object.defineProperty(Array.prototype, 'chunk', {
          writable: true,
          enumerable: true,
          configurable: true,
          value: function(chunkSize) {
            var R = [];
            for (var i = 0; i < this.length; i += chunkSize)
              R.push(this.slice(i, i + chunkSize));
            return R;
          }
        });
        this.page_number = ''
        let per_page = this.per_page
        this.chunkedData = data.chunk(per_page)
        let page_number = this.chunkedData.length
        this.page_number = page_number
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
      emitChange() {
        this.currentComponent = null
        this.getRecords()
      }
    }
  }
</script>

<style scoped>

</style>
