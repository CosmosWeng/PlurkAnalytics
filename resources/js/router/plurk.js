import store from '../store'

import Layout from '../views/layout/Layout'
import { Info, Friend } from '@/views/plurk'
import { getUserInfo } from '@/api/user'

export default {
  path: '/plurk',
  component: Layout,
  redirect: '/plurk/info',
  name: 'Plurk',
  meta: { title: 'Plurk', icon: 'plurk' },
  beforeEnter: (to, from, next) => {
    //
    getUserInfo().then(function(result) {
      if (result.hasOwnProperty('data')) {
        let data = result.data

        store.commit('user/SET_PLURK_USER', data)

        next()
      } else {
        next({ path: '/' })
      }
    })
  },

  children: [
    {
      path: 'info',
      name: 'PlurkInfo',
      component: Info,
      meta: { title: 'Info', icon: 'people' }
    },
    {
      path: 'friend',
      name: 'PlurkFriend',
      component: Friend,
      meta: { title: 'Friend', icon: 'peoples' }
    }
  ]
}
