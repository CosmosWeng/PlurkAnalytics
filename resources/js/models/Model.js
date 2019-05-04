import { Model as BaseModel } from 'vue-api-query'
import request from '@/utils/request'
BaseModel.$http = request
export default class Model extends BaseModel {
  // define a base url for a REST API
  baseURL() {
    return ''
  }

  // implement a default request method
  request(config) {
    return this.$http.request(config)
  }
}
