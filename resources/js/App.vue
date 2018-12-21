<template>
  <div id="app">
    <ElContainer direction="vertical">
      <ElHeader style="text-align: right; font-size: 12px">
        <ElButton
          type="success"
          @click="$router.push({'path':'/login'})"
        >
          Login
        </ElButton>
      </ElHeader>
      <ElMain>
        <RouterView />
        <div>{{ user }}</div>
      </ElMain>
    </ElContainer>
  </div>
</template>

<script>
import Navbar from '@views/layout/Navbar'

export default {
  name: 'App',
  components: {
  },
  data() {
    return {
    }
  },
  computed: {
    user() {
      return this.$store.state.user
    }
  },
  methods: {
    goLogin() {
      window.location.href = '/login'
    }
  },
}
</script>

<style>
.el-main {
  background-color: #e9eef3;
  color: #333;
  text-align: center;
  line-height: 160px;
}

body > .el-container {
  margin-bottom: 40px;
}
</style>