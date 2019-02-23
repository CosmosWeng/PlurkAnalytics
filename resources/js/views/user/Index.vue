<template>
  <div class="app-container documentation-container">
    <ElRow
      type="flex"
      justify="space-between"
    >
      <ElCol :span="12">
        <ElCard :body-style="{ padding: '0px' }">
          <img
            :src="user.avatar_big"
            class="image"
          >
          <div style="padding: 14px;">
            <span> {{ user.full_name }}</span>
            <p v-html="user.about_renderred" />
          </div>
        </ElCard>
      </ElCol>
      <ElCol :span="10">
        <ElCard :body-style="{ padding: '0px' }">
          <div style="padding: 14px;">
            <span>統計</span>

            <ElRow>
              <ElButton
                round
                @click="getReport"
              >
                開始互動分析
              </ElButton>
            </ElRow>

            <ElRow justify="center">
              <ElProgress
                :text-inside="true"
                :stroke-width="18"
                :percentage="70"
              />
              <ElProgress
                :text-inside="true"
                :stroke-width="18"
                :percentage="80"
                color="rgba(142, 113, 199, 0.7)"
              />
              <ElProgress
                :text-inside="true"
                :stroke-width="18"
                :percentage="100"
                status="success"
              />
              <ElProgress
                :text-inside="true"
                :stroke-width="18"
                :percentage="50"
                status="exception"
              />
            </ElRow>
          </div>
        </ElCard>
      </ElCol>
    </ElRow>
  </div>
</template>
<script>
import { getUsersMe } from '@api/user'

export default {
  name: 'UserIndo',
  data() {
    return {

    }
  },
  computed: {
    user() {
      return this.$store.state.user.info
    }
  },
  mounted() {
    if (localStorage.getObject('r')) {
      this.$store.dispatch('user/GetUsersMe')
    }
  },
  methods: {
    getReport() {
      this.$store.dispatch('user/GetInteractiveReport')
    }
  },
}
</script>

<style>
.image {
  width: 100%;
  display: block;
}
</style>
