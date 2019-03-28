import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

/** note: sub-menu only appear when children.length>=1
 *  detail see  https://panjiachen.github.io/vue-element-admin-site/guide/essentials/router-and-nav.html
 **/

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    roles: ['admin','editor']    will control the page roles (you can set multiple roles)
    title: 'title'               the name show in sub-menu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if true, the page will no be cached(default is false)
    breadcrumb: false            if false, the item will hidden in breadcrumb(default is true)
    affix: true                  if true, the tag will affix in the tags-view
  }
**/
import { checkAsyncRoutes } from '@/store/modules/permission'
import * as web from './web'
import mobile from './mobile'

export const constantRoutes = [
  {
    path: '/404',
    name: 'page404',
    props: true,
    hidden: true,
    component: () => import('@/views/404'),
    beforeEnter: (to, from, next) => {
      let cachePath = localStorage.getObject('cacheRoutePath')

      if (checkAsyncRoutes(asyncRoutes, cachePath)) {
        next({ path: cachePath })
      }

      if (to.params.hasOwnProperty('from')) {
        next()
      } else {
        next({ name: 'page404', params: { from: from } })
      }
    }
  },
  mobile,
  web.dashboard,
  web.login,
  web.message,
  { path: '*', redirect: '/404', hidden: true }
]
export const asyncRoutes = [web.plurk]

export default new Router({
  base: '/',
  mode: 'history', //后端支持可开
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})
