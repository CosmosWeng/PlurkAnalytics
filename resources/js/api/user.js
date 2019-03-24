import request from '@/utils/request'

export function GetInfo() {
  return request({
    url: '/plurk/getMe',
    method: 'get'
  })
}

export function fetchFriendList(query) {
  return request({
    url: '/plurk/getFriendsByOffset',
    method: 'get',
    params: query
  })
}

export function logout() {
  return request({
    url: '/login/logout',
    method: 'post'
  })
}
