import request from '@/utils/request'

export function getUserInfo() {
  return request({
    url: '/plurk/getMe',
    method: 'get'
  })
}

export function getFriendList() {
  return request({
    url: '/plurk/getFriends',
    method: 'get'
  })
}
