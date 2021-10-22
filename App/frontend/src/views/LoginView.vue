<template>
  <Preloader :play="formDisabled" />
  <form v-if="!formDisabled" action="#" method="post" class="auth-form" @submit.prevent="tryLogin">
    <Input type="text" name="login" placeholder="Ваш логин" v-model="postData.login" />
    <p class="auth-form__error-message" v-if="formErrors.login">{{ formErrors.login }}</p>
    <Input type="password" name="password" placeholder="Ваш пароль" v-model="postData.password" />
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
  name: 'LoginView',
  emits: [ 'auth:event' ],
  components: {
    Input,
    Button,
    Preloader,
  },
  data: () => ({
    formDisabled: null,
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

      this.axios
        .post('login', this.postData)
        .then(this.handleResponse)
        .catch(this.handleError)
        .finally(this.afterRequest)
    },
    handleResponse(response) {
      const user = response.data.data
      this.$store.commit('setUser', user)
      this.$emit('auth:event', 'login')
    },
    handleError(error) {
      const errorData = error.response.data
      if (errorData.code === 422) this.formErrors = errorData.error.errors
      else {
        alert('Произошла не предвиденная ошибка ошибка (Более подробное описание ошибки смотрите в консоли)')
        console.log(error)
      }
    },
    afterRequest() {
      this.formDisabled = null
    },
  },
  created() {
    this.clearErrors()
  }
}
</script>
