<template>
  <component :is="routeLayout">
    <router-view></router-view>
  </component>
</template>

<script>
import Auth from './layouts/Auth'
import Home from './layouts/Home'

export default {
  name: 'App',
  components: {
    Auth,
    Home,
  },
  computed: {
    routeLayout() {
      const { layout } = this.$route.meta
      return layout || 'div'
    }
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
