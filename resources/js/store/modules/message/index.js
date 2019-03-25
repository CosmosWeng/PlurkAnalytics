// import state from './state.js'
// import mutations from './mutations.js'
// import actions from './actions.js'
// import getters from './getters.js'

const state = {
  message: []
}

const mutations = {
  SET_MESSAGE: (state, message) => {
    state.message = message
  }
}

const actions = {}
const getters = {
  message: state => state.message
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
