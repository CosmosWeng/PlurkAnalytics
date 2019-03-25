<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-edit"
        @click="handleCreate"
      >
        Add
      </el-button>
    </div>
    <tree-table
      :data="tableData"
      :columns="columns"
      fit
      highlight-current-row
      style="width: 100%;"
      border
    >
      <template slot="pre-column">
        <el-table-column
          type="expand"
          width="55"
        >
          <template slot-scope="scope">
            <!--  -->
            <template v-if="scope.row.user">
              <p>
                {{ scope.row.user.name }}: <br>
                {{ scope.row.content }}
              </p>
              <template v-if="scope.row.children">
                <!--  -->
                <el-card
                  v-for="children in scope.row.children"
                  :key="children.id"
                  class="box-card"
                >
                  <template v-if="children.user">
                    <div
                      v-if="scope.row.user_id == children.user_id"
                      class="text item"
                    >
                      {{ children.user.name }}: <br>
                      {{ children.content }}
                    </div>
                    <div
                      v-else
                      class="text item"
                      align="right"
                    >
                      : {{ children.user.name }}<br>
                      {{ children.content }}
                    </div>
                  </template>
                </el-card>
              </template>
            </template>
          </template>
        </el-table-column>
      </template>

      <template
        slot="is_reply"
        slot-scope="{scope}"
      >
        <el-tag
          v-if="scope.row.is_reply"
          type="info"
        >
          已回覆
        </el-tag>
        <el-tag
          v-else
          type="danger"
        >
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
          @click="handleReply(scope.row)"
        >
          回覆
        </el-button>
      </template>
    </tree-table>
    <Pagination
      v-show="total>0"
      :total="total"
      :page-sizes="[5,10,20]"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.limit"
      @pagination="getList"
    />

    <el-dialog
      :title="textMap[dialogStatus]"
      :visible.sync="dialogFormVisible"
      width="100%"
    >
      <el-form
        ref="dataForm"
        :rules="rules"
        :model="temp"
        style="width: 100%;"
      >
        <el-form-item prop="title">
          <el-input
            v-model="temp.title"
            placeholder="Please input Title"
          />
        </el-form-item>

        <el-form-item prop="content">
          <el-input
            v-model="temp.content"
            :autosize="{ minRows: 4, maxRows: 10}"
            type="textarea"
            placeholder="Please input Content"
          />
        </el-form-item>
      </el-form>
      <div
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="dialogFormVisible = false">
          Cancel
        </el-button>
        <el-button
          type="primary"
          @click="dialogStatus==='create'?createData():updateData()"
        >
          Confirm
        </el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
/**
  Auth: Lei.j1ang
  Created: 2018/1/19-14:54
*/
import treeToArray from './treeTable/customEval'
import treeTable from '@/views/element-ui/components/TreeTable'
import Pagination from '@/views/element-ui//components/Pagination'

import { mapGetters } from 'vuex'
import { fetchList, createMessage } from '@/api/message'

export default {
  name: 'CustomTreeTableDemo',
  components: { treeTable, Pagination },
  data() {
    return {
      tableData: [],
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
        page: 0,
        limit: 5
      },
      temp: {
        id: undefined,
        title: '',
        content: '',
        is_public: 1,
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Edit',
        create: 'Create'
      },
      rules: {
        title: [{ required: true, message: 'title is required', trigger: 'blur' }],
        content: [{ required: true, message: 'content is required', trigger: 'blur' }],
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
    getList() {
      this.listLoading = true
      this.listQuery.plurk_uuid = this.plurk_uuid
      fetchList(this.listQuery).then(response => {
        this.tableData = response.data
        this.total = response.total
        this.listLoading = false
      })
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        title: '',
        content: '',
        is_public: 1,
      }
    },
    handleReply(row) {
      let parent_id = row.id,
          title = 'Re: ' + row.title

      this.resetTemp()
      this.temp['parent_id'] = parent_id
      this.temp['title'] = title

      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    handleCreate() {
      this.resetTemp()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {

          createMessage(this.temp).then((response) => {
            if (response.code == 200) {
              // this.tableData.unshift(this.temp)
              this.dialogFormVisible = false
              this.$notify({
                title: '成功',
                message: response.message,
                type: 'success',
                duration: 2000
              })
              this.getList()
            }
          })
        }
      })
    },
    selectChange(val) {
      console.log(val)
    },
  }
}
</script>
