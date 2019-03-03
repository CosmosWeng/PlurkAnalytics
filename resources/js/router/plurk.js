import store from '../store'
import Layout from '../views/layout/Layout'
import { Info, Friend } from '@/views/plurk'

export default {
  path: '/plurk',
  component: Layout,
  redirect: '/plurk/info',
  name: 'Plurk',
  meta: { title: 'Plurk', icon: 'plurk' },
  beforeEnter: (to, from, next) => {
    //
    store.
      dispatch('user/GetUserInfo').
      then(function(res) {
        next()
      }).
      catch(err => {
        next({ path: '/', replace: true })
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
