import request from '@utils/request'

export function getInteractiveReport() {
  return request({
    url: '/analyse/report',
    method: 'get'
  })
}
