<template>
  <Nav @do:logout="tryLogout" />
  <div class="page-wrapper">
    <div class="container page-container">
      <main class="page-main">
        <router-view v-if="isUserLoaded" />
      </main>
      <Sidebar />
    </div>
  </div>
  <Preloader :play="isLogout || isUserLoading" :fullScreen="true" :fullColor="true" />
</template>

<script>
import Nav from '../../components/general/Nav'
import Preloader from '../../components/general/Preloader'
import Sidebar from '../../components/general/Sidebar'

export default {
  name: 'MainLayout',
  emits: [ 'authEvent' ],
  components: {
    Nav,
    Preloader,
    Sidebar,
  },
  data: () => ({
    isUserLoading: false,
    isLogout: false,
  }),
  computed: {
    isUserLoaded() {
      return this.$store.getters.isUserLoaded
    },
  },
  methods: {
    loadUser() {
      this.isUserLoading = true
      this.axios
        .get('user')
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
    tryLogout() {
      this.isLogout = true
      this.axios
        .delete('logout')
        .then(() => {
          this.$store.dispatch('removeToken')
          this.$emit('authEvent', 'logout')
        })
        .catch(() => alert('Произошла ошибка'))
    },
  },
  mounted() {
    if (!this.$store.getters.api_token) return

    this.axios.defaults.headers.common['Authorization'] = `Bearer ${this.$store.getters.api_token}`
    if (!this.$store.getters.isUserLoaded) this.loadUser()
  },
}
</script>

<style lang="scss">
.page {
  &-wrapper {
    min-height: calc(100vh - 9rem);
    padding-top: 3rem;
    //
    background-color: var(--gray-15);
  }

  &-container {
    display: grid;
    grid-template-rows: auto;
    grid-template-columns: 1fr 30rem;
    gap: 3rem;
  }
}
</style>
