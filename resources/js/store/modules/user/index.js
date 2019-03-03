// import state from './state.js'
// import mutations from './mutations.js'
import { getToken } from '@/utils/auth'
import actions from './actions.js'
import getters from './getters.js'

const state = {
  user: '',
  status: '',
  code: '',
  token: getToken(),
  name: '',
  plurk_uuid: '',
  full_name: '',
  join_date: '',
  karma: '',
  timezone: '',
  avatar: '',
  avatar_big: '',
  introduction: '',
  friends_count: '',
  roles: [],
  setting: {
    articlePlatform: []
  }
}
const mutations = {
  SET_CODE: (state, code) => {
    state.code = code
  },
  SET_TOKEN: (state, token) => {
    state.token = token
  },
  SET_INTRODUCTION: (state, introduction) => {
    state.introduction = introduction
  },
  SET_SETTING: (state, setting) => {
    state.setting = setting
  },
  SET_STATUS: (state, status) => {
    state.status = status
  },
  SET_NAME: (state, name) => {
    state.name = name
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles
  },
  SET_PLURK_USER: (state, data) => {
    state.user = data
    state.name = data.display_name
    state.avatar = data.avatar_medium
    state.avatar_big = data.avatar_big
    state.introduction = data.about

    state.plurk_uuid = data.id
    state.full_name = data.full_name
    state.join_date = data.join_date
    state.karma = data.karma
    state.timezone = data.timezone
    state.friends_count = data.friends_count
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
