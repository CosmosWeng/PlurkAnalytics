import request from '@utils/request'
import { Message } from 'element-ui'

export function getUsersMe() {
  return request({
    url: '/plurk/getMe',
    method: 'get'
  })
}

export function getFriends() {
  return request({
    url: '/plurk/getFriends',
    method: 'get'
  })
}
