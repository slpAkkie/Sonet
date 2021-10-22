<template>
  <component :is="getLayoutComponent" @auth:event="handleAuthEvent"></component>
</template>

<script>
import AuthLayout from './layouts/AuthLayout'
import MainLayout from './layouts/MainLayout'

export default {
  name: 'App',
  components: {
    AuthLayout,
    MainLayout,
  },
  computed: {
    getLayoutComponent() {
      return this.layoutKey ? this.layoutVariants[this.layoutKey].component : null
    },
  },
  data: () => ({
    layoutKey: null,
    layoutVariants: {
      auth: {
        component: 'AuthLayout',
        baseUrl: '/login',
        beforeCallback: (vue) => {
          vue.axios.defaults.headers.common['Authorization'] = undefined
        },
      },
      main: {
        component: 'MainLayout',
        baseUrl: '/',
        beforeCallback: (vue) => {
          vue.axios.defaults.headers.common['Authorization'] = `Bearer ${vue.$store.getters.token}`
        },
      },
    },
  }),
  methods: {
    async setLayout(layoutKey, url = null) {
      this.layoutVariants[layoutKey].beforeCallback(this)
      await this.$router.replace(url || this.layoutVariants[layoutKey].baseUrl)
      this.layoutKey = layoutKey
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
