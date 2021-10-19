<template>
  <Preloader :play="isWaitingResponse">
    <form action="#" method="post" class="auth-form" @submit.prevent="tryLogin">
      <Input type="text" name="login" placeholder="Ваш логин" v-model="postData.login" />
      <p class="auth-form__error-message" v-if="formErrors.login">{{ formErrors.login }}</p>
      <Input type="password" name="password" placeholder="Ваш пароль" v-model="postData.password" />
      <p class="auth-form__error-message" v-if="formErrors.password">{{ formErrors.password }}</p>
      <Button type="submit" value="Войти" />
    </form>
  </Preloader>
  <p class="text_center">Или вы можете <router-link to="register">зарегистрироваться</router-link></p>
</template>

<script>
import Input from '../components/elements/Input'
import Button from '../components/elements/Button'
import Preloader from '../components/general/Preloader'

export default {
  name: 'LoginView',
  emits: [ 'authEvent' ],
  components: {
    Input,
    Button,
    Preloader,
  },
  data: () => ({
    isWaitingResponse: false,
    postData: {
      login: '',
      password: '',
    },
    formErrors: {
      login: '',
      password: '',
    }
  }),
  methods: {
    tryLogin() {
      if (this.isWaitingResponse) return
      this.isWaitingResponse = true

      this.formErrors = {
        login: '',
        password: '',
      }
      this.axios
        .post('login', this.postData)
        .then(response => this.handleResponse(response.data))
        .catch(error => this.handleResponseError(error.response.data))
        .finally(() => this.isWaitingResponse = false)
    },
    handleResponse(response) {
      this.$store.commit('setToken', response.data.api_token)
      this.$store.commit('setUser', response.data)
      this.$emit('authEvent', 'login')
    },
    handleResponseError(response) {
      if (response.code === 422) this.formErrors = response.error.errors
      else alert('Произошла ошибка')
    },
  },
}
</script>
