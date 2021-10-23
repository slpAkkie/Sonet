<template>
  <Nav @auth:event="forwardAuthEvent" />
  <div class="page-wrapper">
    <div class="container page-container">
      <main class="page-main">
        <router-view />
      </main>
      <Sidebar />
    </div>
  </div>
</template>

<script>
import Nav from '../components/general/Nav'
import Sidebar from '../components/general/Sidebar'

export default {
  name: 'MainLayout',
  emits: [ 'auth:event' ],
  components: {
    Nav,
    Sidebar,
  },
  methods: {
    forwardAuthEvent(...params) {
      this.$emit('auth:event', ...params)
    }
  },
}
</script>

<style lang="scss">
.page {
  &-wrapper {
    min-height: calc(100vh - 9rem);
    padding-top: 3rem;
    padding-bottom: 3rem;
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
