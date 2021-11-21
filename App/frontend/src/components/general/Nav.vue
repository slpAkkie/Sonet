<template>
  <nav class="nav">
    <div class="container">
      <div class="nav__inner">
        <div class="nav__brand">
          <h1 class="nav__brand-title"><router-link to="/home">Sonet</router-link></h1>
        </div>
        <div class="nav__user-menu">
          <UserMenu />
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import UserMenu from './UserMenu'

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
  box-shadow: 0 .4rem 1.5rem var(--gray-90-08);

  &__inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    //
    height: 100%;
    padding: 1.5rem 0;
  }

  &__brand-title {
    font-size: 3.5rem;
  }

  &__user-img {
    max-width: 3.2rem;
    //
    cursor: pointer;
  }
}
</style>
