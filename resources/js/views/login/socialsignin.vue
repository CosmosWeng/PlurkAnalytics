<template>
  <div class="social-signup-container">
    <div
      class="sign-btn"
      @click="plurkHandleClick('plurk')"
    >
      <span class="plurk-svg-container">
        <svg-icon
          icon-class="plurk"
          class="icon"
        />
      </span> Plurk
    </div>
  </div>
</template>

<script>
// import openWindow from '@/utils/openWindow'

export default {
  name: 'SocialSignin',
  methods: {
    plurkHandleClick(thirdpart) {
      this.$router.push({ path: '/login/plurk' })
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      })

    },
    tencentHandleClick(thirdpart) {
      alert('ok')
      // this.$store.commit('SET_AUTH_TYPE', thirdpart)
      // const client_id = 'xxxxx'
      // const redirect_uri = encodeURIComponent('xxx/redirect?redirect=' + window.location.origin + '/auth-redirect')
      // const url = 'https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=' + client_id + '&redirect_uri=' + redirect_uri
      // openWindow(url, thirdpart, 540, 540)
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.social-signup-container {
  margin: 20px 0;
  .sign-btn {
    display: inline-block;
    cursor: pointer;
  }
  .icon {
    color: #fff;
    font-size: 24px;
    margin-top: 8px;
  }

  .plurk-svg-container .wx-svg-container,
  .qq-svg-container {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    padding-top: 1px;
    border-radius: 4px;
    margin-bottom: 20px;
    margin-right: 5px;
  }
  .plurk-svg-container {
    background-color: #ff574d;
  }
  .wx-svg-container {
    background-color: #24da70;
  }
  .qq-svg-container {
    background-color: #6ba2d6;
    margin-left: 50px;
  }
}
</style>
