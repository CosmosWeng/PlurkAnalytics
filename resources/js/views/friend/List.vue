<template>
  <ElTable
    :data="tableData"
    style="width: 100%"
  >
    <ElTableColumn
      label="日期"
      width="180"
    >
      <template slot-scope="scope">
        <i class="el-icon-time" />
        <span style="margin-left: 10px">
          {{ scope.row.date }}
        </span>
      </template>
    </ElTableColumn>
    <ElTableColumn
      label="姓名"
      width="180"
    >
      <template slot-scope="scope">
        <ElPopover
          trigger="hover"
          placement="top"
        >
          <p>姓名: {{ scope.row.name }}</p>
          <p>住址: {{ scope.row.address }}</p>
          <div
            slot="reference"
            class="name-wrapper"
          >
            <ElTag size="medium">
              {{ scope.row.name }}
            </ElTag>
          </div>
        </ElPopover>
      </template>
    </ElTableColumn>
    <ElTableColumn label="操作">
      <template slot-scope="scope">
        <ElButton
          size="mini"
          @click="handleEdit(scope.$index, scope.row)"
        >
          编辑
        </ElButton>
        <ElButton
          size="mini"
          type="danger"
          @click="handleDelete(scope.$index, scope.row)"
        >
          删除
        </ElButton>
      </template>
    </ElTableColumn>
  </ElTable>
</template>

<script>
export default {
  data() {
    return {
      tableData: [{
        date: '2016-05-02',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1518 弄'
      }, {
        date: '2016-05-04',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1517 弄'
      }, {
        date: '2016-05-01',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1519 弄'
      }, {
        date: '2016-05-03',
        name: '王小虎',
        address: '上海市普陀区金沙江路 1516 弄'
      }]
    }
  },
  methods: {
    handleEdit(index, row) {
      console.log(index, row)
    },
    handleDelete(index, row) {
      console.log(index, row)
    }
  }
}
</script>