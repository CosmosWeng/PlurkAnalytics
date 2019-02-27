/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

import 'normalize.css/normalize.css' // A modern alternative to CSS resets
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/en'

import '@/styles/index.scss'

import App from './App.vue'
import store from './store'
import router from './router'

import '@/icons/index' // icon
// import '@/permission' // permission control

Vue.use(ElementUI, { locale })
Vue.config.productionTip = false

const app = new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
