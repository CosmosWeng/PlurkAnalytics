import Layout from '@/views/mint-ui/layout/Layout'
import MessageLayout from '@/views/mint-ui/layout/MessageLayout'

export default {
  path: '/mobile',
  redirect: '/mobile/index',
  component: Layout,
  children: [
    {
      path: 'index',
      component: () => import('@/views/mint-ui/home/index'),
      meta: { title: 'Mobile .Ver', icon: 'phone', roles: [] }
    },
    {
      path: 'message',
      hidden: true,
      redirect: '/mobile/message/list',
      component: MessageLayout,
      meta: { roles: [] },
      children: [
        {
          path: 'list',
          component: () => import('@/views/mint-ui/message/list'),
          meta: { roles: [] }
        },
        {
          path: 'content',
          name: 'MobileMessageContent',
          component: () => import('@/views/mint-ui/message/content'),
          props: true,
          meta: { roles: [] }
        }
      ]
    }
  ]
}
