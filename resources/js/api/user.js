import request from '@utils/request'

function getToken() {
  var r = localStorage.getObject('r')

  return {
    oauth_token: r['oauth_token'],
    oauth_token_secret: r['oauth_token_secret']
  }
}
export function getUsersMe() {
  return request({
    url: '/plurk/getMe',
    method: 'get',
    params: getToken()
  })
}
