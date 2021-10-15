<template>
  <form action="#" method="post" @submit.prevent="tryLogin">
    <input type="text" name="text" placeholder="Ваш логин" v-model="postData.login">
    <p v-if="formErrors.login">{{ formErrors.login }}</p>
    <input type="text" name="password" placeholder="Ваш пароль" v-model="postData.password">
    <p v-if="formErrors.password">{{ formErrors.password }}</p>
    <input type="submit" value="Войти">
  </form>
</template>

<script>
export default {
  name: 'LoginView',
  data: () => ({
    postData: {
      login: '',
      password: ''
    },
    formErrors: {
      login: '',
      password: ''
    }
  }),
  methods: {
    tryLogin() {
      console.log(this.postData)
      this.axios.post('login', this.postData).then(response => console.log(response))
    }
  }
}
</script>