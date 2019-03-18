import Layout from '../views/layout/Layout'
import { List } from '@/views/message'

export default {
  path: '/message',
  component: Layout,
  children: [
    {
      path: 'Index',
      name: 'Message',
      component: List,
      meta: { title: 'Message', icon: 'message' }
    }
  ]
}
