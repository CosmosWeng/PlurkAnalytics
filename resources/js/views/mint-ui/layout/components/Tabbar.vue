<template>
  <!--  -->
  <div class="page-tabbar">
    <div class="page-wrap">
      <router-view />
    </div>

    <mt-tabbar
      v-model="selected"
      fixed
    >
      <mt-tab-item id="index">
        <svg-icon
          icon-class="dashboard"
          class="icon"
        />
        Home
      </mt-tab-item>
      <mt-tab-item id="message/list">
        <svg-icon
          icon-class="message"
          class="icon"
        />
        Message
      </mt-tab-item>

      <mt-tab-item
        v-if="token"
        id="plurk"
      >
        <svg-icon
          icon-class="plurk"
          class="icon"
        />
        Plurk
      </mt-tab-item>
    </mt-tabbar>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  components: {},
  data() {
    return {
      selected: 'index'
    }
  },
  computed: {
    ...mapGetters({
      token: "user/token",
    }),
  },
  watch: {
    selected(value) {
      this.$router.push('/mobile/' + value)
    }
  },
  mounted() {
    this.selected = this.$route.path.replace(/^\/mobile\//g, '')
  },
}
</script>

<style rel="stylesheet/scss" lang="scss">
.page-tabbar {
  overflow: hidden;
  height: 100vh;
}

.page-wrap {
  overflow: auto;
  height: 100%;
  padding-bottom: 100px;
}

.mint-tab-item-label {
  font-size: 18px !important;
}
</style>
