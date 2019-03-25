<template>
  <div class="container">
    <router-link
      class="page-back"
      :to="'/mobile/message'"
    >
      <i class="mintui mintui-back" />
    </router-link>
    <h1 class="page-title">
      留言
    </h1>
    <div
      v-for="(item, index) in responses"
      :key="index"
    >
      {{ item.created_at }} : <br>
      <p>
        {{ item.content }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
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

    }
  },
  computed: {
    responses() {
      let children = (this.message.hasOwnProperty('children')) ? this.message.children : []

      return (children.length > 0) ? children.reverse() : []
    }
  },
  mounted() {
    //
  },
}
</script>

<style rel="stylesheet/scss" scoped lang="scss">
</style>
