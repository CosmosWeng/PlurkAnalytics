import Vue from 'vue'
import SvgIcon from '@/views/element-ui/components/SvgIcon' // svg组件

// register globally
Vue.component('svg-icon', SvgIcon)

const req = require.context('./svg', false, /\.svg$/)
const requireAll = requireContext => requireContext.keys().map(requireContext)

requireAll(req)
