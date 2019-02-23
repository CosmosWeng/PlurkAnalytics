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
      v-if="Object.keys(user).length === 0"
      index="3"
      style="float: right;"
      :route="{'path':'/login'}"
    >
      Login
    </ElMenuItem>
    <ElMenuItem
      v-else
      index="3"
      style="float: right;"
      :route="{'path':'/logout'}"
      @click="logout"
    >
      Logout
    </ElMenuItem>
  </ElMenu>
</template>

<script>
export default {
  components: {
  },
  computed: {
    user() {
      return this.$store.state.user.info
    }
  },
  methods: {
    logout() {
      this.$store.commit('user/SET_ME', {})
    }
  }
}
</script>
