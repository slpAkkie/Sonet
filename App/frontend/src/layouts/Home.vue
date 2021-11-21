<template>
  <Nav />
  <div class="page-wrapper">
    <div class="container page-container">
      <main class="page-main">
        <slot></slot>
      </main>
      <Sidebar />
    </div>
  </div>
</template>

<script>
import Nav from '../components/general/Nav'
import Sidebar from '../components/Home/Sidebar'

export default {
  name: 'MainLayout',
  components: {
    Nav,
    Sidebar,
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
    align-items: flex-start;
    gap: 3rem;

    @media screen and (max-width: 749px) {
      grid-template-rows: auto auto;
      grid-template-columns: auto;
    }
  }
}
</style>
