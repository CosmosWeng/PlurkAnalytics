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
      return this.$store.state.user
    }
  },
  mounted() {
    getUsersMe().then((result) => {
      if (result.hasOwnProperty('data')) {
        this.$store.commit('setUser', result.data)
      }
    }).catch((err) => {

    })
  },
}
</script>

<style>
</style>
