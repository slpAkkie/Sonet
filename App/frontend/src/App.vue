<template>
  <component :is="layoutVariants[layoutKey].component" @auth:event="handleAuthEvent"></component>
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
    layoutKey: 'auth',
    layoutVariants: {
      auth: {
        component: 'AuthLayout',
        baseUrl: '/login',
      },
      main: {
        component: 'MainLayout',
        baseUrl: '/',
      },
    },
  }),
  methods: {
    setLayout(layoutKey, url = null) {
      this.layoutKey = layoutKey
      this.$router.push(url || this.layoutVariants[layoutKey].baseUrl)
    },
    handleAuthEvent(event) {
      if (event === 'login') this.setLayout('main')
      else if (['register', 'logout'].includes(event)) this.setLayout('auth')
    },
  },
  beforeMount() {
    this.setLayout(this.$store.getters.isUser ? 'main' : 'auth')
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
