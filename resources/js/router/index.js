import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'
import { getUserInfo } from '@/api/user'

Vue.use(Router)

/* Layout */
import Layout from '../views/layout/Layout'
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
import dashboard from '@/views/dashboard/index'

import login from './login'
import plurk from './plurk'
import message from './message'
export const constantRouterMap = [
  { path: '/404', component: e404, hidden: true },
  login,
  {
    path: '/',
    component: Layout,
    redirect: '/dashboard',
    name: 'Dashboard',
    children: [
      {
        path: 'dashboard',
        component: dashboard,
        meta: { title: 'Home', icon: 'dashboard' }
      }
    ]
  },
  message,
  plurk,
  { path: '*', redirect: '/404', hidden: true }
]

const router = new Router({
  base: '/',
  mode: 'history', //后端支持可开
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRouterMap
})

router.beforeEach((to, from, next) => {
  let token = localStorage.getObject('token'),
      user = store.getters['user/user']

  if (token && !user) {
    getUserInfo().then(function(result) {
      if (result.code == 200) {
        store.commit('user/SET_PLURK_USER', result.data)
      }
    })
  }
  next()
})

export default router
