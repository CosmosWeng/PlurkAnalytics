import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import { getToken, getAccessToken } from '@api/login'
import store from '../store'

import Layout from '@views/layout/Layout'
import UserIndex from '@views/user/Index'
import FriendList from '@views/friend/List'

const routes = [
  { path: '/', component: Layout, redirect: { name: 'User' } },
  {
    path: '/user',
    component: Layout,
    redirect: '/user/info',
    children: [
      {
        path: 'home',
        component: UserIndex,
        name: 'UserHome'
      },
      {
        path: 'info',
        component: UserIndex,
        name: 'User'
      }
    ]
  },

  {
    path: '/friend',
    component: Layout,
    redirect: '/friend/list',
    children: [
      {
        path: 'list',
        component: FriendList,
        name: 'FriendList'
      }
    ]
  },

  {
    path: '/logout',
    redirect: (to, from, next) => {
      localStorage.clear()
      return '/user/home'
    }
  },
  {
    path: '/login',
    redirect: (to, from, next) => {
      localStorage.clear()

      getToken(to.query).then(function(result) {
        if (result.hasOwnProperty('data')) {
          let r = result.data.r

          localStorage.setObject('r', r)
          window.location.href = 'https://www.plurk.com/OAuth/authorize?oauth_token=' + r.oauth_token
        }
      })

      return '/'
    }
  },
  {
    path: '/login/callback',
    beforeEnter: (to, from, next) => {
      let query = to.query

      query['oauth_token_secret'] = localStorage.getObject('r')['oauth_token_secret']
      getAccessToken(query).then(function(result) {
        if (result.hasOwnProperty('data')) {
          localStorage.setObject('r', result.data.r)
        }
        next({ path: '/' })
      })
    }
  },
  { path: '*', redirect: '/' }
]

export default new Router({
  base: '/',
  mode: 'history', //后端支持可开
  scrollBehavior: () => ({ y: 0 }),
  routes: routes
})
