import router from './router'
import store from './store'
import NProgress from 'nprogress' // progress bar
import 'nprogress/nprogress.css' // progress bar style
import { Message } from 'element-ui'
import { getToken } from '@/utils/auth' // getToken from cookie

NProgress.configure({ showSpinner: false }) // NProgress configuration
// permission judge function
function hasPermission(roles, permissionRoles) {
  if (roles.includes('admin')) {
    return true
  } // admin permission passed directly
  if (!permissionRoles) {
    return true
  }
  return roles.some(role => permissionRoles.indexOf(role) >= 0)
}

const whiteList = ['/login', '/dashboard'] // 不重定向白名单

router.beforeEach((to, from, next) => {
  NProgress.start()
  // next()
  let roles = store.getters.roles

  store.
    dispatch('GenerateRoutes', { roles }).
    // then(accessRoutes => {
    //   // router.addRoutes(accessRoutes)
    // }).
    then(function() {
      if (getToken()) {
        if (to.path === '/login') {
          next({ path: '/' })
          NProgress.done()
        } else {
          if (store.getters.roles.length === 0) {
            store.
              dispatch('user/GetInfo').
              then(res => {
                roles = res.data.roles.map(item => item.name)
                store.dispatch('GenerateRoutes', { roles }).then(accessRoutes => {
                  router.addRoutes(accessRoutes)
                  next()
                })
              }).
              catch(err => {
                store.dispatch('user/FedLogOut').then(() => {
                  Message.error(err || 'Verification failed, please login again')
                  next({ path: '/' })
                })
              })
          } else {
            // 没有动态改变权限的需求可直接next() 删除下方权限判断 ↓
            // if (hasPermission(store.getters.roles, to.meta.roles)) {
            //   next()
            // } else {
            //   next({ path: '/401', replace: true, query: { noGoBack: true } })
            // }
            next()
          }
        }
      } else {
        next()
      }
    })
})

router.afterEach(() => {
  NProgress.done() // 结束Progress
})
