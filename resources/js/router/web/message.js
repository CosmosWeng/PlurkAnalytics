import Layout from '@/views/element-ui/layout/Layout'
// import { List } from '@/views/element-ui/message'

export default {
  path: '/message',
  component: Layout,
  redirect: '/message/index',
  children: [
    {
      path: 'Index',
      name: 'Message',
      component: () => import('@/views/element-ui/message/list'),
      // component: List,
      meta: { title: 'Message', icon: 'message', roles: [] }
    }
  ]
}
