<template>
  <el-card
    class="box-card-component"
    style="margin-left:8px;min-height:400px;"
  >
    <div
      slot="header"
      class="box-card-header"
    >
      <img :src="avatar_big">
    </div>
    <div style="position:relative;">
      <PanThumb
        :image="avatar"
        class="panThumb"
      />

      <Mallki
        class-name="mallki-text"
        :text="full_name"
      />

      <div
        class="info-item"
        style="padding-top:35px;"
      >
        <span>{{ full_name }}</span>
      </div>

      <div class="info-item">
        <span>Karma: </span>
        <span>{{ karma }}</span>
      </div>

      <div class="info-item">
        <span>Timezone: </span>
        <span>{{ timezone }}</span>
      </div>

      <div class="info-item">
        <span>Join Date: </span>
        <span>{{ join_date }}</span>
      </div>
    </div>
  </el-card>
</template>

<script>
import { mapGetters } from 'vuex'
import PanThumb from '@/components/PanThumb'
import Mallki from '@/components/TextHoverEffect/Mallki'

export default {
  components: { PanThumb, Mallki },

  filters: {
    statusFilter(status) {
      const statusMap = {
        success: 'success',
        pending: 'danger'
      }

      return statusMap[status]
    }
  },
  data() {
    return {
      statisticsData: {
        article_count: 1024,
        pageviews_count: 1024
      }
    }
  },
  computed: {
    ...mapGetters({
      avatar: "user/avatar",
      avatar_big: "user/avatar_big",
      full_name: "user/full_name",
      join_date: "user/join_date",
      karma: "user/karma",
      timezone: "user/timezone",
    })
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" >
.box-card-component {
  .el-card__header {
    padding: 0px !important;
  }
}
</style>
<style rel="stylesheet/scss" lang="scss" scoped>
.box-card-component {
  .box-card-header {
    position: relative;
    height: 220px;
    img {
      width: 100%;
      height: 100%;
      transition: all 0.2s linear;
      &:hover {
        transform: scale(1.1, 1.1);
        filter: contrast(130%);
      }
    }
  }
  .mallki-text {
    position: absolute;
    top: 0px;
    right: 0px;
    font-size: 20px;
    font-weight: bold;
  }
  .panThumb {
    z-index: 100;
    height: 70px !important;
    width: 70px !important;
    position: absolute !important;
    top: -45px;
    left: 0px;
    border: 5px solid #ffffff;
    background-color: #fff;
    margin: auto;
    box-shadow: none !important;
  }
  .info-item {
    margin-bottom: 10px;
    font-size: 14px;
  }
  // @media only screen and (max-width: 720px) {
  //   .mallki-text {
  //     display: none;
  //   }
  // }
}
</style>
