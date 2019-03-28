<template>
  <div class="app-container">
    <el-table
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column
        align="center"
        label="Name"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.nick_name }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="內容"
      >
        <template
          v-if="scope.row.content"
          slot-scope="scope"
        >
          <!-- <span>{{ scope.row.content }}</span> -->
          <div v-html="scope.row.content" />
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="Actions"
        min-width="120"
      >
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="small"
            icon="el-icon-view"
          >
            顯示回覆
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <Pagination
      v-show="total>0"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { fetchPlurks } from '@/api/plurk'
import Pagination from '@/views/element-ui/components/Pagination' // Secondary package based on el-pagination

export default {
  name: 'FriendList',
  components: { Pagination },
  filters: {},
  data() {
    return {
      list: [],
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20
      },
      analyseFriendData: {
        users: {},
        favorite_count: 0,
        replurkers_count: 0,
        response_count: 0
      }
    }
  },
  computed: {
    ...mapGetters({
      plurk_uuid: "user/plurk_uuid"
    }),
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      this.listQuery.plurk_uuid = this.plurk_uuid
      fetchPlurks(this.listQuery).then(response => {
        this.list = response.data
        this.total = response.total
        this.listLoading = false
      })
    },
    // handleSizeChange(val) {
    //   this.listQuery.limit = val
    //   this.getList()
    // },
    // handleCurrentChange(val) {
    //   this.listQuery.page = val
    //   this.getList()
    // }
  }
}
</script>

<style scoped>
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
</style>
