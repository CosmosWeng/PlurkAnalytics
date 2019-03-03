import request from '@/utils/request'

export function getToken(query) {
  return request({
    url: '/login/getToken',
    method: 'post',
    params: query
  })
}

export function getAccessToken(query) {
  return request({
    url: '/login/accessToken',
    method: 'post',
    params: query
  })
}
