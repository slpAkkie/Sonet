<template>
  <div class="user-menu__wrapper">
    <img class="nav__user-img" src="@/assets/img/icons/user--flat-colored.png" alt="UserMenu" @click="openUserMenu">
    <div v-if="openedUserMenu" class="nav__user-menu user-menu">
      <div class="user-menu__first-name">{{ $store.getters.user.first_name }}</div>
      <hr class="user-menu__separator">
      <Button value="Выход" @click="$emit('click:logout')" appearance="danger" />
    </div>
  </div>
</template>

<script>
import Button from '../elements/Button'

export default {
  name: 'UserMenu',
  emits: [ 'click:logout' ],
  components: {
    Button,
  },
  data: () => ({
    openedUserMenu: false,
  }),
  methods: {
    openUserMenu() {
      this.openedUserMenu = !this.openedUserMenu
    },
  },
}
</script>

<style lang="scss">
.user-menu {
  position: absolute;
  top: 100%;
  right: 0;
  //
  display: flex;
  flex-direction: column;
  align-items: stretch;
  //
  min-width: 15rem;
  padding: 1.5rem 1rem;
  //
  text-align: center;
  //
  box-shadow: 0 0 2.5rem 0 var(--gray-90-08);
  background-color: var(--white);
  border-radius: .4rem;
  //
  transform: translateY(1rem);

  &__wrapper {
    position: relative;
  }

  &__separator {
    width: 100%;
    height: .2rem;
    margin: 1rem auto;
    //
    background-color: var(--gray-30);
    border-radius: .4rem;
  }
}
</style>