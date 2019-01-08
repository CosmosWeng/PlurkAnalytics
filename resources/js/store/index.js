import Vue from 'vue'
import Vuex from 'vuex'
import * as modules from './modules'

// import getters from './getters'

Vue.use(Vuex)

const state = {
  lang: 'en'
}

const mutations = {}

const actions = {}

export default new Vuex.Store({
  state,
  mutations,
  actions,
  // getters,
  modules
})
