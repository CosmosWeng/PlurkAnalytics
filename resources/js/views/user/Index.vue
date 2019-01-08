<template>
  <div class="app-container documentation-container">
    {{ user }}
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
</style>
