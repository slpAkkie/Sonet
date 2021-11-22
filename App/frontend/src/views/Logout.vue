<template>
  <h5>Переадресация...</h5>
</template>

<script>
export default {
  name: 'Logout',
  beforeMount() {
    this.$store.commit('clearStore')
    this.$router.push('/login')
  }
}
</script>

<style lang="scss">

</style>