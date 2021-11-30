<template>
  <div class="tab-content__header">
    <h6>Ваши персональные данные</h6>
  </div>
  <div class="main-tab__user-data">
    <div class="main-tab__row">
      <label class="main-tab__label" for="first_name">Ваше имя:</label>
      <Input disabled id="first_name" class="main-tab__input" v-model="first_name" />
    </div>
    <div class="main-tab__row">
      <label class="main-tab__label" for="last_name">Ваша фамилия:</label>
      <Input disabled id="last_name" class="main-tab__input" v-model="last_name" />
    </div>
    <div class="main-tab__row">
      <label class="main-tab__label" for="login">Ваш логин:</label>
      <Input disabled id="login" class="main-tab__input" v-model="login" />
    </div>
    <div class="main-tab__row">
      <label class="main-tab__label" for="email">Ваш email:</label>
      <Input disabled id="email" class="main-tab__input" v-model="email" />
    </div>
<!--    TODO: Uncomment when API method will be done -->
<!--    <div class="main-tab__row">-->
<!--      <label class="main-tab__label" for="password">Новый пароль:</label>-->
<!--      <Input id="password" class="main-tab__input" v-model="password" />-->
<!--    </div>-->
<!--    <div class="main-tab__row">-->
<!--      <label class="main-tab__label" for="password_confirmation">Повтор пароля:</label>-->
<!--      <Input id="password_confirmation" class="main-tab__input" v-model="password_confirmation" />-->
<!--    </div>-->
  </div>
</template>

<script>
import Input from '../../components/controls/Input'

export default {
  name: 'MainSettingsTab',
  components: {
    Input,
  },
  data: () => ({
    postData: {
      first_name: '',
      last_name: '',
      login: '',
      password: '',
      password_confirmation: '',
    },
  }),
  computed: {
    first_name: {
      get() {
        return this.$store.getters.user.first_name
      },
    },
    last_name: {
      get() {
        return this.$store.getters.user.last_name
      },
    },
    login: {
      get() {
        return this.$store.getters.user.login
      },
    },
    email: {
      get() {
        return this.$store.getters.user.email
      },
    },
    password() {
      return this.postData.password
    },
    password_confirmation() {
      return this.postData.password_confirmation
    },
  },
}
</script>

<style lang="scss">
.main-tab {
  &__row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 3rem;
    //
    margin-bottom: 1.5rem;
  }

  &__label {
    flex-shrink: 0;
    //
    max-width: 40%;
  }

  &__input {
    max-width: 75%;
  }
}
</style>