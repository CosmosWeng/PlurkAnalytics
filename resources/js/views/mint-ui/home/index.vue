<template>
  <div class="container">
    <div class="dashboard-text" />
  </div>
</template>

<script>
import Viewer from 'tui-editor/dist/tui-editor-Viewer'

export default {
  components: {

  },
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

<style rel="stylesheet/scss" scoped lang="scss">
</style>
