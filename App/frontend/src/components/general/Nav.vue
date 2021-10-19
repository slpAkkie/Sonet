<template>
  <nav class="nav">
    <div class="container">
      <div class="nav__inner">
        <div class="nav__left">
          <router-link to="/"><img class="nav__logo" src="@/assets/img/nav__logo.png" alt="Logo"></router-link>
        </div>
        <div class="nav__right">
          <UserMenu @click:logout="$emit('do:logout')" />
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import UserMenu from "./UserMenu";

export default {
  name: 'Nav',
  emits: [ 'do:logout' ],
  components: {
    UserMenu,
  },
}
</script>

<style lang="scss">
.nav {
  height: 9rem;
  box-shadow: 0 .4rem 1.5rem var(--gray-90-08);

  &__inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    //
    height: 100%;
    padding: 1.5rem 0;
  }

  &__logo {
    max-width: 10.5rem;
  }

  &__user-img {
    max-width: 3.2rem;
    //
    cursor: pointer;
  }
}
</style>
