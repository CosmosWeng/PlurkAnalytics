<template>
  <div>
    <mt-header
      fixed
      title="固定在顶部"
    />
    <router-view />
  </div>
</template>

<script>
import Vue from 'vue'
import { install as Mint } from 'mint-ui'
Vue.use(Mint)

export default {}
</script>

<style src="mint-ui/lib/style.css"></style>

<style  rel="stylesheet/scss" lang="scss">
/* @reset-global mobile; */
</style>
