<template>
  <div class="tab-content__header">
    <h6>Здесь расположены ваши категории</h6>
    <Button value="Новая категория" @click="openNewCategory" />
  </div>
  <p v-if="!categoriesLoaded">Загрузка...</p>
  <div class="categories-tab__categories-list" v-if="isCategories">
    <CategoryRow
      v-for="category in categories"
      :key="category.id"
      :data="category"
    />
  </div>
  <p v-else>У вас еще нет категорий, но вы можете их создать</p>

  <CategoryPopup
    v-if="openedPopup"
    @popup:close="closePopup"
  />
</template>

<script>
import Button from '../../components/controls/Button'
import CategoryPopup from '../../components/UserSettings/CategoryPopup'
import CategoryRow from '../../components/UserSettings/CategoryRow'

export default {
  name: 'CategoriesSettingsTab',
  components: {
    Button,
    CategoryPopup,
    CategoryRow,
  },
  data: () => ({
    openedPopup: false,
  }),
  computed: {
    isCategories() {
      return !!this.categories.length
    },
    categories() {
      return this.$store.getters.categories
    },
    categoriesLoaded() {
      return this.$store.getters.categoriesLoaded
    },
  },
  methods: {
    openNewCategory() {
      this.openedPopup = true
    },
    closePopup() {
      this.openedPopup = false
    },
  },
}
</script>

<style lang="scss">
.categories-tab {
  &__categories-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    //
    padding: 1.5rem 0;
  }
}
</style>