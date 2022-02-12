<template>
  <div style="display: block; padding-top: 30px; max-width: 80%;">
    <el-table
    :data="tableData"
    stripe
    border
    style="width: 100%">
    <el-table-column
      prop="date"
      label="Question"
      width="180">
    </el-table-column>
    <el-table-column
      prop="name"
      label="Answer">
    </el-table-column>
    <el-table-column
      prop="address"
      label="Action"
      fixed-right
      width="200">
    </el-table-column>
    </el-table>
  </div>
</template>

<script>
  export default {
    name: 'LessonFaqComponent',
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
        }]
      }
   }
  }
</script>

<style scoped>

</style>