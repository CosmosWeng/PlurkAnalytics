<template>
  <div>
    <mt-header
      fixed
      title="固定在顶部"
    />
    <RouterView />
  </div>
</template>

<script>
import Vue from 'vue'
import { install as Mint } from 'mint-ui'
Vue.use(Mint)

export default {
  components: {
    // MtHeader: Header
  },
  computed: {},
  mounted() {
  },
  methods: {}
}
</script>

<style src="mint-ui/lib/style.css"></style>

<style  rel="stylesheet/scss" lang="scss">
/* @reset-global mobile; */
</style>
