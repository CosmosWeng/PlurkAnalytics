<template>
  <ElMenu
    mode="horizontal"
    :router="true"
  >
    <ElMenuItem
      index="1"
      :route="{'name':'User'}"
    >
      個人資料
    </ElMenuItem>

    <ElMenuItem
      index="2"
      :route="{'name':'FriendList'}"
    >
      好友名單
    </ElMenuItem>

    <ElMenuItem
      index="3"
      style="float: right;"
      :route="{'path':'/login'}"
    >
      Login
    </ElMenuItem>
  </ElMenu>
</template>

<script>
export default {
  components: {
  },
  computed: {
  },
  methods: {
    logout() {
      this.$store.dispatch('LogOut').then(() => {
        // location.reload() // 为了重新实例化vue-router对象 避免bug
      })
    }
  }
}
</script>
