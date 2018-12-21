import request from '@utils/request'

export function logout() {
  return request({
    url: '/login/logout',
    method: 'post'
  })
}

export function getToken(query) {
  return request({
    url: '/login/getToken',
    method: 'post',
    params: query
  })
}

export function getAccessToken(query) {
  return request({
    url: '/login/access_token',
    method: 'post',
    params: query
  })
}
