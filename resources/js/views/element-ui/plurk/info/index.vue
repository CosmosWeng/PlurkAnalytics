<template>
  <div class="app-container">
    <el-row :gutter="8">
      <el-col
        :xs="{span: 24}"
        :sm="{span: 24}"
        :md="{span: 12}"
        :lg="{span: 8}"
        :xl="{span: 8}"
        style="margin-bottom:30px;"
      >
        <BoxCardLeft />
      </el-col>
      <el-col
        :xs="{span: 24}"
        :sm="{span: 24}"
        :md="{span: 12}"
        :lg="{span: 16}"
        :xl="{span: 16}"
        style="margin-bottom:30px;"
      >
        <BoxCardRight />
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import BoxCardLeft from './components/BoxCardLeft'
import BoxCardRight from './components/BoxCardRight'

export default {
  components: { BoxCardLeft, BoxCardRight },
  filters: {},
  data() {
    return {}
  },
  computed: {}
}
</script>

<style rel="stylesheet/scss" lang="scss" >
</style>
