<template>
  <Nav @logout="$emit('authEvent', 'logout')" />
  <router-view />
</template>

<script>
import Nav from '../../components/general/Nav';

export default {
  name: 'MainLayout',
  emits: [ 'authEvent' ],
  components: {
    Nav
  },
}
</script>

<style lang="scss">

</style>
