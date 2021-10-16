<template>
  <MainLayout v-if="layout === 'main'" @logout="changeLayout('auth', 'login')" />
  <AuthLayout v-else-if="layout === 'auth'" @login="changeLayout('main', '/')" />
</template>

<script>
import AuthLayout from "./views/layouts/AuthLayout";
import MainLayout from "./views/layouts/MainLayout";

export default {
  name: 'App',
  components: {
    AuthLayout,
    MainLayout,
  },
  data: () => ({
    layout: 'main',
  }),
  methods: {
    changeLayout(layout, url = null) {
      this.layout = layout
      url && this.$router.push(url)
    }
  },
  beforeCreate() {
    this.$store.dispatch('checkToken').then(response => {
      !response
        ? this.changeLayout('auth')
        : this.changeLayout('main')
    })
  },
}
</script>

<style lang="scss">
*,
*::before,
*::after {
  box-sizing: border-box;
  //
  padding: 0;
  margin: 0;
  //
  outline: none;
  border: none;
  box-shadow: none;
}

html {
  font-family: 'Segoe UI', sans-serif;
  font-size: 10px;
}

input {
  font-family: 'Segoe UI', sans-serif;
}

body {
  font-size: 1.6rem;
}

p {
  margin: 1.5rem 0;
}

a {
  color: #51b5d4;
  text-decoration: none;
  //
  transition: color .1s ease;

  &:hover {
    color: #0983a2;
  }
}

.text {
  &_center {
    text-align: center;
  }
}
</style>
