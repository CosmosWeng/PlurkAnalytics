/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

import Vue from 'vue'

import 'normalize.css/normalize.css' // A modern alternative to CSS resets
import '@/styles/index.scss'

import App from './App.vue'
import store from './store'
import router from './router'
import i18n from './lang' // Internationalization
import '@/icons/index' // icon
import './errorLog' // error log
import './permission' // permission control

Vue.config.productionTip = false

const app = new Vue({
  el: '#app',
  router,
  store,
  i18n,
  render: h => h(App)
})
