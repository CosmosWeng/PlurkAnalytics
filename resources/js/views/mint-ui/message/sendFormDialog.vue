<template>
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
        :disabled="disabilConfirmBtn"
        @click="createData"
      >
        Confirm
      </el-button>
    </div>
  </el-dialog>
</template>

<script>
import { fetchList, createMessage } from '@/api/message'
export default {
  components: {},
  props: {
    value: {
      type: Object,
      default() {
        return {
        }
      }
    }
  },
  data() {
    return {
      disabilConfirmBtn: false,
      temp: {
        id: undefined,
        title: '',
        content: '',
        is_public: 1,
        parent_id: 0
      },
      dialogFormVisible: false,
      dialogStatus: 'create',
      textMap: {
        update: 'Edit',
        create: 'Create',
        reply: "Reply"
      },
      rules: {
        title: [{ required: true, message: 'title is required', trigger: 'blur' }],
        content: [{ required: true, message: 'content is required', trigger: 'blur' }],
      },
    }
  },
  watch: {
    value: {
      handler(newValue) {
        this.handleCreate()
        this.dialogFormVisible = newValue.dialogFormVisible
        this.dialogStatus = newValue.dialogStatus
        this.temp.parent_id = newValue.parent_id
        this.temp.title = newValue.title
      },
      deep: true
    },
    dialogFormVisible(newValue) {
      let value = this.value

      value.dialogFormVisible = newValue
      this.$emit('input', value)
    },
    dialogStatus(newValue) {
      if (newValue == 'reply') {
        this.temp.title = 'Re:' + this.temp.title
      }
    }
  },
  mounted() {
    //
  },
  methods: {
    resetTemp() {
      this.temp = {
        id: undefined,
        title: '',
        content: '',
        is_public: 1,
      }
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
          this.disabilConfirmBtn = true
          createMessage(this.temp).then((response) => {
            if (response.code == 200) {
              this.dialogFormVisible = false
              this.$notify({
                title: '成功',
                message: response.message,
                type: 'success',
                duration: 2000
              })
              this.$router.go()
            }
            this.disabilConfirmBtn = false
          })
        }
      })
    },
  },
}
</script>

<style rel="stylesheet/scss" scoped lang="scss">
</style>
