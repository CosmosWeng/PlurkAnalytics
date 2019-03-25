<template>
  <div class="page-infinite">
    <mt-header
      fixed
      title="Message"
    >
      <mt-button
        slot="right"
        class="page-new"
        @click="MessageFormDialogModel.dialogFormVisible = !MessageFormDialogModel.dialogFormVisible"
      >
        <svg-icon
          icon-class="guide"
          class="icon"
        />
      </mt-button>
    </mt-header>
    <div
      ref="wrapper"
      class="page-infinite-wrapper"
      :style="{ height: wrapperHeight + 'px' }"
    >
      <ul
        v-infinite-scroll="loadMore"
        class="page-infinite-list"
        infinite-scroll-disabled="loading"
        infinite-scroll-distance="50"
      >
        <li
          v-for="item in list"
          :key="item.id"
          class="page-infinite-listitem"
          @click="goContent(item)"
        >
          <mt-cell
            :title="item.title"
            :label="item.id + ' '+ item.created_at"
            :value="(item.user == null)?'':item.user.name"
            is-link
          />
        </li>
      </ul>
      <p
        v-show="loading"
        class="page-infinite-loading"
      >
        <mt-spinner type="fading-circle" />
        加载中...
      </p>
    </div>

    <sendMessageFormDialog v-model="MessageFormDialogModel" />
  </div>
</template>

<script>
import { MessageBox } from 'mint-ui'
import { mapGetters } from 'vuex'
import { fetchList, createMessage } from '@/api/message'
import sendMessageFormDialog from './sendFormDialog'
export default {
  components: { sendMessageFormDialog },
  data() {
    return {
      list: [],
      loading: false,
      allLoaded: false,
      wrapperHeight: 0,
      total: 0,
      listQuery: {
        page: 0,
        limit: 15
      },
      //
      MessageFormDialogModel: {
        dialogFormVisible: false,
        dialogStatus: 'create',
        parent_id: 0,
        title: ''
      }
    }
  },
  computed: {
    ...mapGetters({
      token: "user/token",
      messages: "message/message",
    }),
  },
  created() {
    this.getList()
  },
  mounted() {
    document.documentElement.style.overflow = 'hidden'
    this.wrapperHeight = document.documentElement.clientHeight - this.$refs.wrapper.getBoundingClientRect().top
  },
  methods: {
    goContent(item) {
      this.$router.push({ name: 'MobileMessageContent', params: { 'message': item } })
    },
    getList() {
      this.listQuery.plurk_uuid = this.plurk_uuid
      return fetchList(this.listQuery).then(response => {
        this.list = response.data
        this.total = response.total
      })
    },
    loadMore() {
      if (this.listQuery.limit > this.list.length) {
        this.loading = true
      }

      setTimeout(() => {
        this.getList().then(res => {
          if (this.total > this.list.length) {
            this.listQuery.limit = this.listQuery.limit + 5
          }
        })
        this.loading = false
      }, 2500)
    }
  }
}
</script>

<style rel="stylesheet/scss"  lang="scss">
.page-infinite {
  .page-infinite-desc {
    text-align: center;
    color: #666;
    padding-bottom: 5px;
    border-bottom: solid 1px #eee;
  }

  .page-infinite-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .page-infinite-listitem {
    height: 50px;
    line-height: 50px;
    border-bottom: solid 1px #eee;
    // text-align: center;
    &:first-child {
      border-top: solid 1px #eee;
    }
  }

  .page-infinite-wrapper {
    margin-top: -1px;
    overflow: scroll;
  }
  .page-infinite-loading {
    text-align: center;
    height: 50px;
    line-height: 50px;
    div {
      display: inline-block;
      vertical-align: middle;
      margin-right: 5px;
    }
  }
}
</style>
