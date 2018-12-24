import axios from 'axios'
import { Message } from 'element-ui'
// import store from '@/store'
// import { getToken } from '@/utils/auth'

// create an axios instance
const service = axios.create({
  baseURL: process.env.MIX_BASE_API, // api 的 base_url
  timeout: 5000 // request timeout
})

// request interceptor
service.interceptors.request.use(
  config => {
    // Do something before request is sent
    // if (store.getters.token) {
    //   // 讓每個請求攜帶token-- ['X-Token']為自定義key 請根據實際情況自行修改
    //   config.headers['X-Token'] = getToken()
    // }
    return config
  },
  error => {
    // Do something with request error
    console.log(error) // for debug
    Promise.reject(error)
  }
)

// response interceptor
service.interceptors.response.use(
  // response => response,
  /**
   * 下面的註釋為通過在response裡，自定義code來標示請求狀態
   * 當code返回如下情況則說明權限有問題，登出並返回到登錄頁
   * 如想通過 xmlhttprequest 來狀態碼標識 邏輯可寫在下面error中
   * 以下代碼均為樣例，請結合自生需求加以修改，若不需要，則可刪除
   */
  response => {
    const res = response.data

    // if (res.code !== 20000) {
    //   Message({
    //     message: res.message,
    //     type: 'error',
    //     duration: 5 * 1000
    //   })
    //   // 50008:非法的token; 50012:其他客戶端登錄了;  50014:Token 過期了;
    //   if (res.code === 50008 || res.code === 50012 || res.code === 50014) {
    //     // 請自行在引入 MessageBox
    //     // import { Message, MessageBox } from 'element-ui'
    //     MessageBox.confirm('你已被登出，可以取消繼續留在該頁面，或者重新登錄', '確定登出', {
    //       confirmButtonText: '重新登錄',
    //       cancelButtonText: '取消',
    //       type: 'warning'
    //     }).then(() => {
    //       store.dispatch('FedLogOut').then(() => {
    //         location.reload() // 為了重新實例化vue-router對象 避免bug
    //       })
    //     })
    //   }
    //   return Promise.reject('error')
    // } else {
    //   return response.data
    // }

    return response.data
  },
  error => {
    console.log('err' + error) // for debug
    Message({
      message: error.message,
      type: 'error',
      duration: 5 * 1000
    })
    return Promise.reject(error)
  }
)

export default service
