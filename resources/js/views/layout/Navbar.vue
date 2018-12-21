<template>
  <ElMenu
    class="navbar"
    mode="horizontal"
  />
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
        location.reload() // 为了重新实例化vue-router对象 避免bug
      })
    }
  }
}
</script>
