import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import { getToken, getAccessToken } from '@api/login'
import store from '../store'

const routes = [
  { path: '/' },
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
          // localStorage.setObject('user', result.data.user)
          store.commit('setUser', result.data.user)
        }
      })

      next({ path: '/' })
    }
  },
  { path: '*', redirect: '/' }
]

export default new Router({
  mode: 'history', //后端支持可开
  scrollBehavior: () => ({ y: 0 }),
  routes: routes
})
