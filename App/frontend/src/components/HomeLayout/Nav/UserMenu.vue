<template>
  <div v-if="isOpen" class="user-menu__overlay" @click="toggle"></div>
  <div class="user-menu__wrapper">
    <img class="user-menu__user-icon" src="@/assets/img/icons/user--flat-colored.png" alt="UserMenu" @click="toggle">
    <div v-if="isOpen" class="user-menu">
      <div class="user-menu__first-name">{{ first_name }}</div>
      <hr class="user-menu__separator">
      <Button class="user-menu__button" value="Настройки" @click="openSettings" />
      <Button class="user-menu__button" value="Выход" @click="tryLogout" appearance="danger" />
    </div>
  </div>
  <Preloader v-if="isLoading" :full-screen="true" />
</template>

<script>
import Preloader from '../../Preloader'
import Button from '../../controls/Button'

export default {
  name: 'UserMenu',
  components: {
    Button,
    Preloader,
  },
  data: () => ({
    isOpen: false,
    isLoading: false,
  }),
  computed: {
    first_name() {
      return this.$store.getters.user.first_name || 'Загрузка...'
    },
  },
  methods: {
    toggle() {
      this.isOpen = !this.isOpen
    },
    tryLogout() {
      this.toggle()
      this.isLoading = true
      this.$store
        .dispatch('logout')
        .finally(this.afterRequest)
    },
    afterRequest() {
      this.$router.push('/logout')
    },
    openSettings() {
      this.toggle()
      this.$router.push('/settings')
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
  background-color: var(--bg-lighter);
  border: .1rem solid var(--primary);
  border-radius: .4rem;
  //
  transform: translateY(1rem);

  &__overlay {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    //
    z-index: 100;
  }

  &__wrapper {
    position: relative;
    //
    z-index: 101;
  }

  &__user-icon {
    width: 100%;
    max-width: 3.2rem;
    //
    cursor: pointer;
  }

  &__separator {
    width: 100%;
    height: .2rem;
    margin: 1rem auto;
    //
    background-color: var(--c-info_inactive);
    border-radius: .4rem;
  }

  &__button {
    & + & {
      margin-top: 1rem;
    }
  }
}
</style>