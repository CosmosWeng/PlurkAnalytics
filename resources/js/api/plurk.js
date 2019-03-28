import request from '@/utils/request'

export function fetchPlurks(query) {
  return request({
    url: '/plurk',
    method: 'get',
    params: query
  })
}
