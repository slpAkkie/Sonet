<template>
  <Nav @logout="$emit('authEvent', 'logout')" />
  Имя: {{ $store.getters.user.first_name }}
  <router-view />
</template>

<script>
import Nav from '../../components/general/Nav'

export default {
  name: 'MainLayout',
  emits: [ 'authEvent' ],
  components: {
    Nav
  },
  methods: {
    loadUser(api_token) {
      console.log(api_token)
      console.log('Данные пользователя не были получены, надо их получить, но axios сбрасывает default.baseURL, а я не хочу писать хост каждый раз, когда отправляю запрос')
      // TODO: Найти решение проблемы
      // this.axios.get('user', {
      //   headers: {
      //     Authorization: `Bearer ${api_token}`,
      //   },
      // }).then(response => this.$store.commit('setUser', response.data))
    },
  },
  mounted() {
    if (!this.$store.getters.isUserLoaded && this.$store.getters.api_token) this.loadUser(this.$store.getters.api_token)
  }
}
</script>

<style lang="scss">

</style>
