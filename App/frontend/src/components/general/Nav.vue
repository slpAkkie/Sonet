<template>
  <nav class="nav">
    <div class="container">
      <div class="nav__inner">
        <div class="nav__left">
          <img class="nav__logo" src="@/assets/img/nav__logo.png" alt="Logo">
        </div>
        <div class="nav__right">
          <Button value="Выход" @click="tryLogout" />
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import Button from "../elements/Button"

export default {
  name: 'Nav',
  emits: [ 'logout' ],
  components: {
    Button,
  },
  methods: {
    tryLogout() {
      this.axios.delete('/logout', {
        headers: {
          Authorization: `Bearer ${this.$store.getters.api_token}`
        }
      }).then(() => {
        this.$store.dispatch('removeToken')
        this.$emit('logout')
      }).catch(() => alert('Произошла ошибка'))
    },
  },
}
</script>

<style lang="scss">
.nav {
  &__inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    //
    padding: 1.5rem 0;
  }

  &__logo {
    max-width: 10.5rem;
  }
}
</style>