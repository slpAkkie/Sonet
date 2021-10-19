<template>
  <Nav @logout="$emit('authEvent', 'logout')" @startLogout="isLogout = true" />
  <div class="page-main">
    <router-view />
  </div>
  <Preloader :play="isLogout || isUserLoading" :fullScreen="true" />
</template>

<script>
import Nav from '../../components/general/Nav'
import Preloader from '../../components/general/Preloader';

export default {
  name: 'MainLayout',
  emits: [ 'authEvent' ],
  components: {
    Nav,
    Preloader,
  },
  data: () => ({
    isUserLoading: false,
    isLogout: false,
  }),
  methods: {
    loadUser(api_token) {
      this.isUserLoading = true
      this.axios
        .get('user', {
          headers: {
            Authorization: `Bearer ${api_token}`,
          },
        })
        .then(this.userLoaded)
        .catch(error => {
          if (error.response.data.code === 401) {
            this.$store.dispatch('removeToken')
            this.$emit('authEvent', 'logout')
          }
        })
    },
    userLoaded(response) {
      this.isUserLoading = false
      this.$store.commit('setUser', response.data.data)
    },
  },
  mounted() {
    if (!this.$store.getters.isUserLoaded && this.$store.getters.api_token) this.loadUser(this.$store.getters.api_token)
  },
}
</script>

<style lang="scss">
.page-main {
  margin-top: 3rem;
}
</style>
