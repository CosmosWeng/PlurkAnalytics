<template>
  <ElTable
    :data="friends"
    style="width: 100%"
  >
    <ElTableColumn
      label="ID"
      width="180"
    >
      <template slot-scope="scope">
        <span style="margin-left: 10px">
          {{ scope.row.id }}
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
          <p>姓名: {{ scope.row.display_name }}</p>
          <p>帳號: {{ scope.row.nick_name }}</p>
          <div
            slot="reference"
            class="name-wrapper"
          >
            <ElTag size="medium">
              {{ scope.row.full_name }}
            </ElTag>
          </div>
        </ElPopover>
      </template>
    </ElTableColumn>
    <ElTableColumn
      label="操作"
      align="right"
    >
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
      }],
    }
  },
  computed: {
    friends() {
      return this.$store.getters['user/getFriends']
    }
  },
  mounted() {
    this.$store.dispatch('user/GetFriends')

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