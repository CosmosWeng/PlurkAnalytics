<template>
  <div class="app-container documentation-container">
    <ElRow
      type="flex"
      justify="space-between"
    >
      <ElCol :span="10">
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

            <ElRow
              type="flex"
              justify="center"
            >
              <ElButton round>
                圆角按钮
              </ElButton>
            </ElRow>
            <ElRow
              type="flex"
              justify="center"
            >
              <ElButton round>
                圆角按钮
              </ElButton>
            </ElRow>
            <ElRow
              type="flex"
              justify="center"
            >
              <ElButton round>
                圆角按钮
              </ElButton>
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
    this.$store.dispatch('user/GetUsersMe')
  },
}
</script>

<style>
.image {
  width: 100%;
  display: block;
}
</style>
