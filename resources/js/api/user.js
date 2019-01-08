import request from '@utils/request'
import { Message } from 'element-ui'

function getToken() {
  var r = localStorage.getObject('r')

  if (!r) {
    Message({
      message: 'Not Token',
      type: 'error',
      duration: 5 * 1000
    })
    throw 'Not Token'
  }

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

export function getFriends() {
  return request({
    url: '/plurk/getFriends',
    method: 'get',
    params: getToken()
  })
}
