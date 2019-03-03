<template>
  <div class="app-container">
    <el-button
      class=""
      type="primary"
      icon="el-icon-tickets"
      @click="analyseFriend"
    >
      分析好友
    </el-button>

    <el-table
      v-loading="listLoading"
      :data="rendorList"
      border
      fit
      highlight-current-row
      style="width: 100%"
    >
      <!-- <el-table-column
        align="center"
        label="ID"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column> -->

      <el-table-column
        align="center"
        label="Name"
      >
        <template slot-scope="scope">
          <span>{{ scope.row.display_name }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="Like數"
        width="80px"
      >
        <template
          v-if="scope.row.hasOwnProperty('favorer')"
          slot-scope="scope"
        >
          <span>{{ scope.row.favorer }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="分享數"
        width="80px"
      >
        <template
          v-if="scope.row.hasOwnProperty('replurk')"
          slot-scope="scope"
        >
          <span>{{ scope.row.replurk }}</span>
        </template>
      </el-table-column>

      <el-table-column
        align="center"
        label="Actions"
        min-width="120"
      >
        <template slot-scope="scope">
          <a
            :href="'https://www.plurk.com/'+scope.row.nick_name"
            target="_blank"
          >
            <el-button
              type="primary"
              size="small"
              icon="el-icon-view"
            >
              前往
            </el-button>
          </a>
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
import { fetchFriendList } from '@/api/user'
import { getInteractiveReport } from '@/api/analyse'
import Pagination from '@/components/Pagination' // Secondary package based on el-pagination

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
      friends_count: "user/friends_count",
      plurk_uuid: "user/plurk_uuid"
    }),
    rendorList() {
      let list = [],
          users = this.analyseFriendData.users

      for (let index = 0; index < this.list.length; index++) {
        const element = this.list[index]

        if (users.hasOwnProperty(element.id)) {
          // element = Object.assign(element, users[element.id])
          element.favorer = users[element.id].favorer
          element.replurk = users[element.id].replurk
        } else {
          element.favorer = 'Null'
          element.replurk = 'Null'
        }
        list.push(element)
      }

      return list
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      this.listQuery.plurk_uuid = this.plurk_uuid
      fetchFriendList(this.listQuery).then(response => {
        this.list = response.data
        this.total = this.friends_count
        this.listLoading = false
      })
    },
    analyseFriend() {
      getInteractiveReport().then(response => {
        this.analyseFriendData = response.data
      })
    },
    handleSizeChange(val) {
      this.listQuery.limit = val
      this.getList()
    },
    handleCurrentChange(val) {
      this.listQuery.page = val
      this.getList()
    }
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
