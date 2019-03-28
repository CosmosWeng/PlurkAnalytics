import request from '@/utils/request'

export function fetchPlurks(query) {
  return request({
    url: '/plurk',
    method: 'get',
    params: query
  })
}

export function getPlurkResponsesByPlurkID(plurk_id) {
  return request({
    url: '/plurk/response',
    method: 'get',
    params: { plurk_id }
  })
}
