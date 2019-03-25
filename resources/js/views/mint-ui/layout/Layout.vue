<template>
  <div>
    <mt-header
      fixed
      title="Plurk Alytice"
    >
      <router-link
        slot="left"
        to="/"
      >
        <mt-button>
          PC .Ver
        </mt-button>
      </router-link>

      <mt-button
        v-if="!token"
        slot="right"
        @click="login"
      >
        Login
      </mt-button>
      <mt-button
        v-else
        slot="right"
        @click="logout"
      >
        Logout
      </mt-button>
    </mt-header>
    <div class="page-header-main">
      <Tabbar />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { Tabbar } from './components'

export default {
  components: {
    Tabbar
  },
  data() {
    return {

    }
  },
  computed: {
    ...mapGetters({
      token: "user/token",
    }),
  },
  methods: {
    login() {
      this.$indicator.open('Loading...')
      this.$router.push('/login/plurk')
      this.$indicator.close()

    },
    logout() {
      this.$indicator.open('Loading...')
      this.$store.dispatch('user/LogOut').then(() => {
        this.$indicator.close()
        location.reload() // 为了重新实例化vue-router对象 避免bug
      })
    }
  },
}
</script>

<style src="mint-ui/lib/style.css"></style>

<style  rel="stylesheet/scss" lang="scss">
html,
body {
  background-color: #fafafa;
  -webkit-overflow-scrolling: touch;
  user-select: none;
}

a {
  color: inherit;
}

.mint-header {
  font-size: 16px;
}

.page-header-main {
  margin-top: 50px;
  min-height: 120vh;
  margin-bottom: 15px;
}

.page-title {
  text-align: center;
}
</style>
