<template>
  <Preloader :play="isLoading">
    <form action="#" method="post" class="auth-form" @submit.prevent="tryLogin">
      <Input type="text" name="login" placeholder="Ваш логин" v-model="postData.login" />
      <p class="auth-form__error-message" v-if="formErrors.login">{{ formErrors.login }}</p>
      <Input type="password" name="password" placeholder="Ваш пароль" v-model="postData.password" />
      <p class="auth-form__error-message" v-if="formErrors.password">{{ formErrors.password }}</p>
      <Button type="submit" value="Войти" />
    </form>
    <p class="text_center">Или вы можете <router-link to="/register">зарегистрироваться</router-link></p>
  </Preloader>
</template>

<script>
import Input from '../components/elements/Input'
import Button from '../components/elements/Button'
import Preloader from '../components/general/Preloader'

export default {
  name: 'LoginView',
  emits: [ 'auth' ],
  components: {
    Input,
    Button,
    Preloader,
  },
  data: () => ({
    isLoading: false,
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
      if (this.isLoading) return
      this.isLoading = true

      this.clearErrors()

      this.axios
        .post('login', this.postData)
        .then(this.handleResponse)
        .catch(this.handleError)
        .finally(this.afterRequest)
    },
    handleResponse(response) {
      const user = response.data.data
      this.$store.commit('setUser', user)
      this.$emit('auth', 'login')
    },
    handleError(error) {
      const errorData = error.response.data
      if (errorData.code === 422) this.formErrors = errorData.error.errors
      else alert('Произошла ошибка')
    },
    afterRequest() {
      this.isLoading = false
    },
  },
  created() {
    this.clearErrors()
  }
}
</script>
