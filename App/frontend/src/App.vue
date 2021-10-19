<template>
  <MainLayout v-if="layout === 'main'" @authEvent="handleAuthEvent" />
  <AuthLayout v-else-if="layout === 'auth'" @authEvent="handleAuthEvent" />
</template>

<script>
import AuthLayout from './views/layouts/AuthLayout'
import MainLayout from './views/layouts/MainLayout'

export default {
  name: 'App',
  components: {
    AuthLayout,
    MainLayout,
  },
  data: () => ({
    layout: 'main',
  }),
  methods: {
    changeLayout(layout, url = null) {
      this.layout = layout
      url && this.$router.push(url)
    },
    handleAuthEvent(event) {
      if (event === 'login') this.changeLayout('main', '/')
      else if (['register', 'logout'].includes(event)) this.changeLayout('auth', 'login')
    },
  },
  beforeCreate() {
    this.$store.dispatch('checkToken').then(response => {
      !response
        ? this.changeLayout('auth')
        : this.changeLayout('main')
    })
  },
}
</script>

<style lang="scss">
@import '/assets/scss/fonts';
@import '/assets/scss/vars';
@import '/assets/scss/normalize';
@import '/assets/scss/support';
@import '/assets/scss/grid';
</style>
