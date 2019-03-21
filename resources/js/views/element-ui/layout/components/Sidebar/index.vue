<template>
  <el-scrollbar wrap-class="scrollbar-wrapper">
    <el-menu
      :show-timeout="200"
      :default-active="$route.path"
      :collapse="isCollapse"
      :background-color="variables.menuBg"
      :text-color="variables.menuText"
      :active-text-color="variables.menuActiveText"
      mode="vertical"
    >
      <SidebarItem
        v-for="route in permission_routes"
        :key="route.path"
        :item="route"
        :base-path="route.path"
      />
    </el-menu>
  </el-scrollbar>
</template>

<script>
import { mapGetters } from 'vuex'
import variables from '@/styles/variables.scss'
import SidebarItem from './SidebarItem'

export default {
  components: { SidebarItem },
  computed: {
    ...mapGetters([
      'sidebar',
      'permission_routes',
    ]),
    routes() {
      let routes = this.$router.options.routes

      return routes
    },
    variables() {
      return variables
    },
    isCollapse() {
      return !this.sidebar.opened
    }
  },
  watch: {
    '$store.state.user.user': {
      handler: function (neweValue, oldValue) {
        console.log(neweValue, oldValue)
        if (neweValue) {
          let routes = this.$router.options.routes

          for (let index = 0; index < routes.length; index++) {
            const route = routes[index]

            if (route.checkToken) {
              let token = localStorage.getObject('token')

              if (token) {
                route.hidden = false
              } else {
                route.hidden = true
              }

              this.$set(this.$router.options.routes, index, route)
              console.log(route)

            }
          }
        }

      },
      deep: true // 開啟深度監聽
    }
  }
}
</script>
