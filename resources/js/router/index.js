import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    title: 'title'               the name show in subMenu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    breadcrumb: false            if false, the item will hidden in breadcrumb(default is true)
  }
**/
import e404 from '@/views/404'
import * as web from './web'
import mobile from './mobile'

export const constantRoutes = [
  { path: '/404', component: e404, hidden: true },
  web.dashboard,
  web.login,
  web.message,
  web.plurk,
  mobile,
  { path: '*', redirect: '/404', hidden: true }
]
export const asyncRoutes = []

const router = new Router({
  base: '/',
  mode: 'history', //后端支持可开
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

// router.beforeEach((to, from, next) => {
//   const roles = []

//   let token = localStorage.getObject('token'),
//       user = store.getters['user/user']

//   if (token && !user) {
//     getUserInfo().then(function(result) {
//       if (result.code == 200) {
//         store.commit('user/SET_PLURK_USER', result.data)

//         roles.push('admin')
//         store.dispatch('GenerateRoutes', { roles }).then(accessRoutes => {
//           // 根据roles权限生成可访问的路由表
//           router.addRoutes(accessRoutes) // 动态添加可访问路由表
//         })
//       }
//     })
//   }

//   if (user) {
//     roles.push('admin')
//   }

//   //
//   store.dispatch('GenerateRoutes', { roles }).then(accessRoutes => {
//     // 根据roles权限生成可访问的路由表
//     router.addRoutes(accessRoutes) // 动态添加可访问路由表
//   })
//   next()
// })

export default router
