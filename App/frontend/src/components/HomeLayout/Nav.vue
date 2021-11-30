<template>
  <nav class="nav">
    <div class="container">
      <div class="nav__inner">
        <div class="nav__brand">
          <h1 class="nav__brand-title"><router-link to="/home" class="nav__brand-link link_static">Sonet</router-link></h1>
        </div>
        <div class="nav__user-menu">
          <UserMenu />
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import UserMenu from './Nav/UserMenu'

export default {
  name: 'Nav',
  components: {
    UserMenu,
  },
}
</script>

<style lang="scss">
.nav {
  height: 9rem;
  //
  background-color: var(--bg-light);

  &__inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    //
    height: 100%;
    padding: 1.5rem 0;
  }

  &__brand {
    &-title {
      font-size: 3.5rem;
    }
  }
}
</style>
