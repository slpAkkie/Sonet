<template>
  <Nav @logout="$emit('logout')" />
  <router-view />
</template>

<script>
import Nav from "../../components/general/Nav";

export default {
  name: "MainLayout",
  emits: [ 'logout' ],
  components: {
    Nav
  },
}
</script>

<style lang="scss">

</style>
