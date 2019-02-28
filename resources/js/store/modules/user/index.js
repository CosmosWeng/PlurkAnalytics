// import state from './state.js'
// import mutations from './mutations.js'
import { getToken } from '@/utils/auth'
import actions from './actions.js'
import getters from './getters.js'

const state = {
  token: '',
  name: '',
  avatar: '',
  roles: []
}
const mutations = {}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
