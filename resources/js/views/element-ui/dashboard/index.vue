<template>
  <div class="dashboard-container">
    <div class="dashboard-text" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Viewer from 'tui-editor/dist/tui-editor-Viewer'

export default {
  name: 'Dashboard',
  data() {
    return {
      editor: null,
      content: `
功能說明
- Plurk 登入
- Plurk 貼文分析
- Plurk 好友分析

`
    }
  },
  computed: {},
  mounted() {
    this.initEditor()
  },
  methods: {
    initEditor() {

      this.editor = new Viewer({
        el: document.querySelector('.dashboard-text'),
        height: '500px',
        initialValue: this.content
      })

    },
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.dashboard {
  &-container {
    margin: 30px;
  }
  &-text {
    font-size: 30px;
    line-height: 46px;
  }
}
</style>
