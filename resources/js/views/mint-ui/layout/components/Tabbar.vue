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
      <mt-tab-item id="message">
        <svg-icon
          icon-class="plurk"
          class="icon"
        />
        Message
      </mt-tab-item>

      <mt-tab-item id="plurk">
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
export default {
  components: {},
  data() {
    return {
      selected: 'index'
    }
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

<style rel="stylesheet/scss" scoped lang="scss">
.page-tabbar {
  overflow: hidden;
  height: 100vh;
}

.page-wrap {
  overflow: auto;
  height: 100%;
  padding-bottom: 100px;
}
</style>
