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
            @click="showResponse(scope.row)"
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

    <el-dialog
      title="回覆"
      :visible.sync="dialogVisible"
      width="80%"
    >
      <template v-for="(response, index) in responses">
        <el-card
          v-if="response.user"
          :key="index"
          class="box-card"
        >
          <div
            slot="header"
            class="clearfix"
          >
            <span>{{ response.user.display_name }} at {{ response.posted }}</span>
          </div>
          <div
            class="text item"
            v-html="response.content"
          />
        </el-card>
      </template>
    </el-dialog>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { fetchPlurks, getPlurkResponsesByPlurkID } from '@/api/plurk'
import Pagination from '@/views/element-ui/components/Pagination' // Secondary package based on el-pagination

export default {
  name: 'FriendList',
  components: { Pagination },
  filters: {},
  data() {
    return {
      list: [],
      total: 0,
      dialogVisible: false,
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
      },
      responses: []
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
    showResponse(row) {
      this.listLoading = true
      getPlurkResponsesByPlurkID(row.plurk_id).then(result => {
        this.responses = result.data
        this.dialogVisible = true
        this.listLoading = false
      })
    }
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
