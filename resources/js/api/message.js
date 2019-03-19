import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/messages',
    method: 'get',
    params: query
  })
}

export function createMessage(data) {
  return request({
    url: '/messages',
    method: 'post',
    data
  })
}
