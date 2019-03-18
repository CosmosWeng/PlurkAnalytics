<template>
  <div>
    <div class="app-container">
      <el-button
        type="primary"
        size="small"
        style="margin:0 0 20px 0;"
      >
        <a
          href="https://github.com/PanJiaChen/vue-element-admin/tree/master/src/components/TreeTable"
          target="_blank"
        >Documentation</a>
      </el-button>

      <tree-table
        :data="tableData"
        :columns="columns"
        border
      >
        <!-- <template slot="selection">
          <el-table-column
            type="selection"
            align="center"
            width="55"
          />
        </template> -->

        <template slot="pre-column">
          <el-table-column
            type="expand"
            width="55"
          >
            <template slot-scope="scope">
              <!--  -->
              <template v-if="scope.row.user">
                <p>
                  {{ scope.row.user.name }}: {{ scope.row.content }}
                </p>
                <template v-if="scope.row.children">
                  <!--  -->
                  <template v-for="children in scope.row.children">
                    <!--  -->
                    <template v-if="children.user">
                      {{ children.user.name }}: {{ children.content }}
                    </template>
                  </template>
                </template>
              </template>
            </template>
          </el-table-column>
        </template>

        <!-- <template
          slot="scope"
          slot-scope="{scope}"
        >
          <el-tag>level: {{ scope.row.is_public }}</el-tag>
          <el-tag>expand: {{ scope.row.is_reply }}</el-tag>
          <el-tag>select: {{ scope.row.user_id }}</el-tag>
        </template> -->

        <template
          slot="is_reply"
          slot-scope="{scope}"
        >
          <el-tag v-if="scope.row.is_reply">
            已回覆
          </el-tag>
          <el-tag v-else>
            未回覆
          </el-tag>
        </template>

        <template
          slot="operation"
          slot-scope="{scope}"
        >
          <el-button
            size="mini"
            type="success"
            @click="editItem(scope.row)"
          >
            回覆
          </el-button>
        </template>
      </tree-table>
    </div>

    <el-dialog
      :visible.sync="dialogFormVisible"
      title="Edit"
    >
      <el-form
        :model="tempItem"
        label-width="100px"
        style="width:600px"
      >
        <el-form-item label="Name">
          <el-input
            v-model.trim="tempItem.name"
            placeholder="Name"
          />
        </el-form-item>
      </el-form>
      <span
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="dialogFormVisible = false">Cancel</el-button>
        <el-button
          type="primary"
          @click="updateItem"
        >Confirm</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
/**
  Auth: Lei.j1ang
  Created: 2018/1/19-14:54
*/
import treeTable from '@/components/TreeTable'
import treeToArray from './treeTable/customEval'

import { mapGetters } from 'vuex'
import { fetchList } from '@/api/message'

export default {
  name: 'CustomTreeTableDemo',
  components: { treeTable },
  data() {
    return {
      tableData: [],
      tempItem: {},
      dialogFormVisible: false,
      columns: [
        {
          label: 'Title',
          key: 'title',
        },
        {
          label: 'Created At',
          key: 'created_at',
          width: 300
        },
        {
          label: 'Status',
          key: 'is_reply',
        },
        {
          label: 'Operation',
          key: 'operation',
          width: 160
        }
      ],
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20
      },
    }
  },
  computed: {
    ...mapGetters({
      token: "user/token",
      messages: "message/message",
    }),
  },
  created() {
    this.getList()
  },
  methods: {
    message(row) {
      this.$message.info('created_at: ' + row.created_at)
    },
    getList() {
      this.listLoading = true
      this.listQuery.plurk_uuid = this.plurk_uuid
      fetchList(this.listQuery).then(response => {
        this.tableData = response.data
        this.total = this.friends_count
        this.listLoading = false
      })
    },
    editItem(row) {
      this.tempItem = Object.assign({}, row)
      this.dialogFormVisible = true
    },
    async updateItem() {
      await this.$refs.TreeTable.updateTreeNode(this.tempItem)
      this.dialogFormVisible = false
    },
    selectChange(val) {
      console.log(val)
    },
  }
}
</script>
