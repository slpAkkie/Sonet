<template>
    <Preloader :show="formDisabled"/>
    <form v-show="!formDisabled" action="#" method="post" class="auth-form" @submit.prevent="tryLogin">
      <Input type="text" autocomplete="username" name="login" placeholder="Ваш логин" v-model="postData.login" />
      <p class="auth-form__error-message" v-if="formErrors.login">{{ formErrors.login }}</p>
      <Input type="password" autocomplete="current-password" name="password" placeholder="Ваш пароль" v-model="postData.password" />
      <p class="auth-form__error-message" v-if="formErrors.password">{{ formErrors.password }}</p>
      <Button type="submit" value="Войти" />
    </form>
    <p class="text_center">Или вы можете <router-link to="/register">зарегистрироваться</router-link></p>
</template>

<script>
import Input from '../components/elements/Input'
import Button from '../components/elements/Button'
import Preloader from '../components/general/Preloader'

export default {
  name: 'Login',
  components: {
    Input,
    Button,
    Preloader,
  },
  data: () => ({
    formDisabled: false,
    postData: {
      login: '',
      password: '',
    },
    formErrors: null
  }),
  methods: {
    clearErrors() {
      this.formErrors = {
        login: '',
        password: '',
      }
    },
    tryLogin() {
      if (this.formDisabled) return
      this.formDisabled = true

      this.clearErrors()

      this.$store
        .dispatch('login', this.postData)
        .then(this.handleResponse)
        .catch(this.handleError)
        .finally(this.afterRequest)
    },
    handleResponse() {
      this.$router.push('/home')
    },
    handleError(response) {
      if (response.code !== 422) return

      this.formErrors = response.error.errors
      this.postData.password = ''
    },
    afterRequest() {
      this.formDisabled = false
    },
  },
  beforeMount() {
    this.clearErrors()
  }
}
</script>
