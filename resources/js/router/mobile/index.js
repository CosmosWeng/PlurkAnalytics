import index from './home'

import Layout from '@/views/mint-ui/layout/Layout'

export default {
  path: '/mobile',
  component: Layout,
  hidden: true,
  children: [
    index
    //
  ]
}
