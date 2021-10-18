<template>
  <Preloader :play="isPreloader">
    <form action="#" method="post" class="auth-form" @submit.prevent="tryRegister">
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
  </Preloader>
  <p class="text_center">Если у вас у же есть аккаунт, вы можете <router-link to="login">войти</router-link> в него</p>
</template>

<script>
import Input from '../components/elements/Input';
import Button from '../components/elements/Button';
import Preloader from '../components/general/Preloader';

export default {
  name: 'RegisterView',
  emits: [ 'authEvent' ],
  components: {
    Input,
    Button,
    Preloader,
  },
  data: () => ({
    isPreloader: false,
    postData: {
      first_name: '',
      last_name: '',
      login: '',
      email: '',
      password: '',
      password_confirmation: '',
    },
    formErrors: {
      first_name: '',
      last_name: '',
      login: '',
      email: '',
      password: '',
    },
  }),
  methods: {
    tryRegister() {
      this.isPreloader = true

      this.formErrors = {
        first_name: '',
        last_name: '',
        login: '',
        email: '',
        password: '',
      }
      this.axios
        .post('register', this.postData)
        .then(response => this.handleResponse(response.data))
        .catch(error => this.handleResponseError(error.response.data))
        .finally(() => this.isPreloader = false)
    },
    handleResponse() {
      this.$emit('authEvent', 'register')
    },
    handleResponseError(response) {
      if (response.code === 422) this.formErrors = response.error.errors
      else alert('Произошла ошибка')
    },
  },
}
</script>
