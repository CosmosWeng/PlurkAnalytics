import Vue from 'vue'
import Vuex from 'vuex'
import * as modules from './modules'

// import getters from './getters'

Vue.use(Vuex)

const state = {
  lang: 'en',
  user: null
}

const mutations = {
  setUser(state, data) {
    state.user = data
    localStorage.setObject('user', data)
  }
}

const actions = {}

export default new Vuex.Store({
  state,
  mutations,
  actions,
  // getters,
  modules
})
