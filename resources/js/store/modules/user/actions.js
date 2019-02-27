import { getFriends, getUsersMe } from '@/api/user'
import { getInteractiveReport } from '@/api/analyse'
export default {
  GetFriends({ commit, state }) {
    return new Promise((resolve, reject) => {
      getFriends().
        then(response => {
          if (!response.data) {
            // 由於mockjs 不支持自定義狀態碼只能這樣hack
            reject('error')
          }
          const data = response.data

          if (data && Object.keys(data).length > 0) {
            commit('SET_FRIENDS', data)
          } else {
            reject('getInfo: friends must be a non-null array !')
          }
          resolve(response)
        }).
        catch(error => {
          reject(error)
        })
    })
  },
  GetUsersMe({ commit, state }) {
    return new Promise((resolve, reject) => {
      getUsersMe().
        then(response => {
          if (!response.data) {
            // 由於mockjs 不支持自定義狀態碼只能這樣hack
            reject('error')
          }
          const data = response.data

          if (data && Object.keys(data).length > 0) {
            commit('SET_ME', data)
          } else {
            reject('getInfo: Info must be a non-null array !')
          }
          resolve(response)
        }).
        catch(error => {
          reject(error)
        })
    })
  },
  GetInteractiveReport({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInteractiveReport().
        then(response => {
          if (!response.data) {
            // 由於mockjs 不支持自定義狀態碼只能這樣hack
            reject('error')
          }
          const data = response.data

          console.log(data)

          if (data && Object.keys(data).length > 0) {
            // commit('SET_ME', data)
          } else {
            reject('getInfo: Info must be a non-null array !')
          }
          resolve(response)
        }).
        catch(error => {
          reject(error)
        })
    })
  }
}
