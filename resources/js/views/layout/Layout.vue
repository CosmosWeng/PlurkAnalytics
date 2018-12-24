<template>
  <ElContainer direction="vertical">
    <ElHeader>
      <Navbar />
    </ElHeader>

    <ElMain>
      <RouterView />
    </ElMain>
  </ElContainer>
</template>

<script>
import Navbar from '@views/layout/Navbar'

export default {
  name: 'Layout',
  components: {
    Navbar
  },
  data() {
    return {
    }
  },
}
</script>

<style>
</style>