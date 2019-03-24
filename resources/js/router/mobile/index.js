import Layout from '@/views/mint-ui/layout/Layout'

export default {
  path: '/mobile',
  component: Layout,
  children: [
    {
      path: 'index',
      component: () => import('@/views/mint-ui/home/index'),
      meta: { title: 'Mobile .Ver', icon: 'phone', roles: [] }
    }
  ]
}
