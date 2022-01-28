<template>
  <div class="tab-content__header">
    <h6>Здесь расположены ваши категории</h6>
    <Button value="+" @click="openNewCategory" />
  </div>
  <p v-if="!categoriesLoaded">Загрузка...</p>
  <div class="categories-tab__categories-list" v-if="isCategories">
    <CategoryRow
      v-for="category in categories"
      :key="category.id"
      :data="category"

      @category:edit="openEditCategory"
    />
  </div>
  <p v-else-if="categoriesLoaded">У вас еще нет категорий, но вы можете их создать</p>

  <CategoryPopup
    v-if="openedPopup"
    @popup:close="closePopup"
    :data="categoryData"
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
    categoryData: null,
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
    openEditCategory(data) {
      this.categoryData = data
      this.openedPopup = true
    },
    closePopup() {
      this.openedPopup = false
      this.categoryData = null
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
  }
}
</style>