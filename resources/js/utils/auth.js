import Cookies from 'js-cookie'

const TokenKey = 'vue_admin_template_token'

export function getToken() {
  // return Cookies.get(TokenKey)
  return localStorage.getObject('token')
}

export function setToken(token) {
  // return Cookies.set(TokenKey, token)
  return localStorage.setObject('token', token)
}

export function removeToken() {
  // return Cookies.remove(TokenKey)
  return localStorage.clear()
}

Storage.prototype.setObject = function(key, value) {
  this.setItem(key, JSON.stringify(value))
}
Storage.prototype.getObject = function(key) {
  var value = this.getItem(key)

  try {
    return value && JSON.parse(value)
  } catch (e) {
    console.log(e)
    return null
  }
}
