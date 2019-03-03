import { getUserInfo, logout } from '@/api/user'
import { removeToken } from '@/utils/auth'

export default {
  GetUserInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getUserInfo(state.token).
        then(response => {
          // 由于mockjs 不支持自定义状态码只能这样hack
          if (!response.data) {
            reject('Verification failed, please login again.')
          }
          const data = response.data

          if (data.roles && data.roles.length > 0) {
            // 验证返回的roles是否是一个非空数组
            commit('SET_ROLES', data.roles)
          } else {
            // reject('getInfo: roles must be a non-null array!')
          }

          commit('SET_PLURK_USER', data)

          resolve(response)
        }).
        catch(error => {
          reject(error)
        })
    })
  },
  // 登出
  LogOut({ commit, state }) {
    return new Promise((resolve, reject) => {
      commit('SET_TOKEN', '')
      commit('SET_ROLES', [])
      removeToken()
      resolve()
    })
  }
}
