export { default as login } from './login'
export { default as message } from './message'
export { default as plurk } from './plurk'

import Layout from '@/views/element-ui/layout/Layout'
import index from '@/views/element-ui/dashboard'

export const dashboard = {
  path: '/',
  component: Layout,
  redirect: '/dashboard',
  name: 'Dashboard',
  children: [
    {
      path: 'dashboard',
      component: index,
      meta: { title: 'Home', icon: 'dashboard' }
    }
  ]
}
