// import state from './state.js'
// import mutations from './mutations.js'
import actions from './actions.js'
import getters from './getters.js'

const state = {
  data: [],
  object: {},
  info: {},
  friendObjects: {}
}
const mutations = {
  SET_ME(state, data) {
    state.info = data
  },
  SET_FRIENDS(state, data) {
    state.friendObjects = data
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
