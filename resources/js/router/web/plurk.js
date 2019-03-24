import store from '@/store'
import Layout from '@/views/element-ui/layout/Layout'
// import { Info, Friend } from '@/views/element-ui/plurk'

export default {
  path: '/plurk',
  component: Layout,
  redirect: '/plurk/info',
  name: 'Plurk',
  meta: { title: 'Plurk', icon: 'plurk', roles: ['user'] },
  beforeEnter: (to, from, next) => {
    //
    store.
      dispatch('user/GetInfo').
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
      component: () => import('@/views/element-ui/plurk/info'),
      // component: Info,
      meta: { title: 'Info', icon: 'people' }
    },
    {
      path: 'friend',
      name: 'PlurkFriend',
      component: () => import('@/views/element-ui/plurk/friend'),
      // component: Friend,
      meta: { title: 'Friend', icon: 'peoples' }
    }
  ]
}
