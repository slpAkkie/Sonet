<template>
  <component :is="routeLayout">
    <router-view></router-view>
  </component>
</template>

<script>
import Authorized from './layouts/Profile'
import Auth from './layouts/Auth'
import NotesIndex from './layouts/NotesIndex'

export default {
  name: 'App',
  components: {
    Auth,
    NotesIndex,
    Authorized,
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
@import '/assets/scss/general';
</style>
