<template>
  <div class="container">
    <router-link
      class="page-back"
      :to="'/mobile/message'"
    >
      <i class="mintui mintui-back" />
    </router-link>

    <mt-button
      class="page-reply"
      @click="MessageFormDialogModel.dialogFormVisible = !MessageFormDialogModel.dialogFormVisible"
    >
      <svg-icon
        icon-class="guide"
        class="icon"
      />
    </mt-button>

    <h1 class="page-title">
      留言
    </h1>

    <div
      v-for="(item, index) in responses"
      :key="index"
    >
      {{ (item.user)?item.user.name:'' }} at {{ item.created_at }} : <br>
      <p>
        {{ item.content }}
      </p>
    </div>

    <sendMessageFormDialog v-model="MessageFormDialogModel" />
  </div>
</template>

<script>
import sendMessageFormDialog from './sendFormDialog'
export default {
  components: { sendMessageFormDialog },
  props: {
    message: {
      type: Object,
      default() {
        return {}
      }
    }
  },
  data() {
    return {
      MessageFormDialogModel: {
        dialogFormVisible: false,
        dialogStatus: 'reply',
        parent_id: 0,
        title: ''
      }
    }
  },
  computed: {
    responses() {
      let children = (this.message.hasOwnProperty('children')) ? this.message.children : []

      return (children.length > 0) ? children.reverse() : []
    }
  },
  created() {
    //
    if (Object.keys(this.message).length == 0) {
      this.$router.push('/mobile/message')
    }
    //
    this.MessageFormDialogModel.parent_id = this.message.id
    this.MessageFormDialogModel.title = this.message.title
  },
  methods: {},
}
</script>

<style rel="stylesheet/scss" scoped lang="scss">
.page-back {
  display: inline-block;
  position: absolute;
  width: 40px;
  height: 40px;
  text-align: center;

  i {
    font-size: 24px;
    line-height: 40px;
  }
}

.page-reply {
  position: absolute;
  right: 1%;
}
</style>
