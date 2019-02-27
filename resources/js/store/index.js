import Vue from 'vue'
import Vuex from 'vuex'
import * as modules from './modules'

import getters from './getters'

Vue.use(Vuex)

export default new Vuex.Store({
  getters,
  modules
})
