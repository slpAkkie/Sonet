<template>
  <Nav />
  <div class="page-wrapper">
    <div class="container page-container" :class="!withSidebar && 'page-container__single'">
      <main class="page-main">
        <slot></slot>
      </main>
      <Sidebar v-if="withSidebar" />
    </div>
  </div>
</template>

<script>
import Nav from '../components/HomeLayout/Nav'
import Sidebar from '../components/HomeLayout/Sidebar'

export default {
  name: 'ProfileLayout',
  components: {
    Nav,
    Sidebar,
  },
  computed: {
    withSidebar() {
      return !this.$route.meta['withoutSidebar']
    },
  },
  beforeCreate() {
    this.$store.dispatch('loadNotes')
    this.$store.dispatch('loadSharedNotes')
    this.$store.dispatch('loadCategories')
    this.$store.dispatch('loadFolders')
  },
}
</script>

<style lang="scss">
.page {
  &-wrapper {
    min-height: calc(100vh - 9rem);
    padding-top: 3rem;
    padding-bottom: 3rem;
  }

  &-container {
    display: grid;
    grid-template-rows: auto;
    grid-template-columns: 1fr 30rem;
    align-items: flex-start;
    gap: 3rem;

    &__single {
      grid-template-columns: 1fr;
    }

    @media screen and (max-width: 749px) {
      grid-template-rows: auto auto;
      grid-template-columns: auto;
    }
  }
}
</style>