<template>
  <MainLayout v-if="layout === 'main'" @logout="changeLayout('auth', 'login')" />
  <AuthLayout v-else-if="layout === 'auth'" @login="changeLayout('main', '/')" />
</template>

<script>
import AuthLayout from "./views/layouts/AuthLayout";
import MainLayout from "./views/layouts/MainLayout";

export default {
  name: 'App',
  components: {
    AuthLayout,
    MainLayout
  },
  data: () => ({
    layout: 'main'
  }),
  methods: {
    changeLayout(layout, url) {
      this.layout = layout
      this.$router.push(url)
    }
  },
  beforeCreate() {
    this.$store.dispatch('checkToken').then(response => {
      !response
        ? this.changeLayout('auth', '/login')
        : this.changeLayout('main', '/')
    })
  }
}
</script>
