<template>
  <h1>Landing page</h1>
  <ul>
    <li><router-link to="/login">Вход</router-link></li>
    <li><router-link to="/register">Регистрация</router-link></li>
    <li><router-link to="/home">Главная страница</router-link></li>
  </ul>
</template>

<script>
export default {
  name: 'Landing',
}
</script>

<style scoped>

</style>