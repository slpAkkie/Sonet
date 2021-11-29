<template>
  <header class="header">
    <div class="container">
      <h1>Sonet</h1>
      <p>Sonet - web-приложение. Электронная записная книжка</p>
      <ul>
        <li><router-link to="/login">Вход</router-link></li>
        <li><router-link to="/register">Регистрация</router-link></li>
        <li><router-link to="/home">Главная страница</router-link></li>
      </ul>
    </div>
  </header>
</template>

<script>
export default {
  name: 'Landing',
}
</script>

<style lang="scss">
.container {
  max-width: 117rem;
  margin-left: auto;
  margin-right: auto;
  padding-left: 1.5rem;
  padding-right: 1.5rem;
}

.header {
  margin-top: 5rem;
}
</style>