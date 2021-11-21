<template>
  <Preloader :show="formDisabled"/>
  <form v-show="!formDisabled" action="#" method="post" class="auth-form" @submit.prevent="tryRegister">
    <Input type="text" name="first_name" placeholder="Ваше имя" v-model="postData.first_name" />
    <p class="auth-form__error-message" v-if="formErrors.first_name">{{ formErrors.first_name }}</p>
    <Input type="text" name="last_name" placeholder="Ваша фамилия" v-model="postData.last_name" />
    <p class="auth-form__error-message" v-if="formErrors.last_name">{{ formErrors.last_name }}</p>
    <Input type="text" name="login" placeholder="Ваш логин" v-model="postData.login" />
    <p class="auth-form__error-message" v-if="formErrors.login">{{ formErrors.login }}</p>
    <Input type="email" name="email" placeholder="Ваш email" v-model="postData.email" />
    <p class="auth-form__error-message" v-if="formErrors.email">{{ formErrors.email }}</p>
    <Input type="password" name="password" placeholder="Ваш пароль" v-model="postData.password" />
    <p class="auth-form__error-message" v-if="formErrors.password">{{ formErrors.password }}</p>
    <Input type="password" name="password_confirmation" placeholder="Ваш пароль" v-model="postData.password_confirmation" />
    <Button type="submit" value="Зарегистрироваться" />
  </form>
  <p class="text_center">Если у вас у же есть аккаунт, вы можете <router-link to="/login">войти</router-link> в него</p>
</template>

<script>
import Input from '../components/elements/Input'
import Button from '../components/elements/Button'
import Preloader from '../components/general/Preloader'

export default {
  name: 'Register',
  components: {
    Input,
    Button,
    Preloader,
  },
  data: () => ({
    formDisabled: null,
    postData: {
      first_name: '',
      last_name: '',
      login: '',
      email: '',
      password: '',
      password_confirmation: '',
    },
    formErrors: null,
  }),
  methods: {
    clearErrors() {
      this.formErrors = {
        first_name: '',
        last_name: '',
        login: '',
        email: '',
        password: '',
      }
    },
    tryRegister() {
      if (this.formDisabled) return
      this.formDisabled = true

      this.clearErrors()

      this.axios
        .post('register', this.postData)
        .then(this.handleResponse)
        .catch(this.handleError)
        .finally(this.afterRequest)
    },
    handleResponse() {
      this.$router.push('/login')
    },
    handleError(error) {
      const errorData = error.response.data
      if (errorData.code !== 422) return

      this.formErrors = errorData.error.errors
      this.postData.password = ''
      this.postData.password_confirmation = ''
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
