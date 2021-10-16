<template>
  <form action="#" method="post" class="auth-form" @submit.prevent="tryLogin">
    <Input type="email" name="email" placeholder="Ваш логин" v-model="postData.login" />
    <p class="auth-form__error-message" v-if="formErrors.login">{{ formErrors.login }}</p>
    <Input type="password" name="password" placeholder="Ваш пароль" v-model="postData.password" />
    <p class="auth-form__error-message" v-if="formErrors.password">{{ formErrors.password }}</p>
    <Button type="submit" value="Войти" />
  </form>
  <p class="text_center">Или вы можете <router-link to="register">зарегистрироваться</router-link></p>
</template>

<script>
import Input from "../components/general/Input";
import Button from "../components/general/Button";

export default {
  name: 'LoginView',
  components: {
    Input,
    Button,
  },
  data: () => ({
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
      this.formErrors = {
        login: '',
        password: '',
      }
      this.axios
        .post('login', this.postData)
        .then(response => this.handleResponse(response.data))
        .catch(error => this.handleResponseError(error.response.data))
    },
    handleResponse(response) {
      console.log(response.data.api_token)
    },
    handleResponseError(response) {
      if (response.code === 422) this.formErrors = response.error.errors
      else alert('Произошла ошибка')
    },
  },
}
</script>
