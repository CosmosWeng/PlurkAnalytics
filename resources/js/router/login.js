import { getToken, getAccessToken } from '@/api/login'
import store from '../store'

export default {
  path: '/login',
  hidden: true,
  children: [
    {
      path: 'plurk',
      redirect: (to, from, next) => {
        localStorage.clear()

        getToken(to.query).then(function(result) {
          if (result.hasOwnProperty('data')) {
            let data = result.data

            localStorage.setObject('r', data.r)
            window.location.href = 'https://www.plurk.com/OAuth/authorize?oauth_token=' + data.r.oauth_token
          }
        })

        return '/'
      }
    },
    {
      path: 'callback',
      beforeEnter: (to, from, next) => {
        let query = to.query

        query['oauth_token_secret'] = localStorage.getObject('r')['oauth_token_secret']
        getAccessToken(query).then(function(result) {
          localStorage.clear()
          if (result.hasOwnProperty('data')) {
            let data = result.data

            localStorage.setObject('token', data.token)
            store.commit('user/SET_TOKEN', data.token)

            if (data.hasOwnProperty('user')) {
              store.commit('user/SET_PLURK_USER', data.user)
            }
          }
        })
        next({ path: '/' })
      }
    }
  ]
}
