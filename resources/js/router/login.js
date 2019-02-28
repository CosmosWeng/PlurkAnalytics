import { getToken, getAccessToken } from '@/api/login'

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
            let r = result.data.r

            localStorage.setObject('r', r)
            window.location.href = 'https://www.plurk.com/OAuth/authorize?oauth_token=' + r.oauth_token
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
            localStorage.setObject('token', result.data.token)
          }
        })
        next({ path: '/' })
      }
    }
  ]
}
