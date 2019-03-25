<template>
  <div>
    <mt-header
      fixed
      title="Plurk Alytice"
    >
      <router-link
        slot="left"
        to="/"
      >
        <mt-button>
          PC .Ver
        </mt-button>
      </router-link>
    </mt-header>
    <div class="page-header-main">
      <Tabbar />
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import { install as Mint } from 'mint-ui'
Vue.use(Mint)

import { Tabbar } from './components'
export default {
  components: {
    Tabbar
  },
  data() {
    return {

    }
  }
}
</script>

<style src="mint-ui/lib/style.css"></style>

<style  rel="stylesheet/scss" lang="scss">
html,
body {
  background-color: #fafafa;
  -webkit-overflow-scrolling: touch;
  user-select: none;
}

a {
  color: inherit;
}

.page-header-main {
  margin-top: 50px;
  min-height: 120vh;
  margin-bottom: 15px;
}

.page-title {
  text-align: center;
}

.page-back {
  display: inline-block;
  position: absolute;
  width: 40px;
  height: 40px;
  text-align: center;

  i {
    font-size: 24px;
    line-height: 40px;
  }
}
</style>
