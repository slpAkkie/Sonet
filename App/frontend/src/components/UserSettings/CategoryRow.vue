<template>
  <div class="category-row" :class="isWaiting ? 'category-row_disabled' : ''">
    <div class="category-row__title">{{ data.title }}</div>
    <div class="category-row__controls">
      <Button value="Удалить" appearance="danger" @click="del" />
    </div>
  </div>
</template>

<script>
import Button from '../controls/Button'

export default {
  name: 'CategoryRow',
  components: {
    Button,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    isWaiting: false,
  }),
  methods: {
    del() {
      this.isWaiting = true

      this.$store
        .dispatch('deleteCategory', this.data.id)
        .catch(() => {
          this.isWaiting = false
        })
    },
  },
}
</script>

<style lang="scss">
.category-row {
  display: flex;
  align-items: center;

  &_disabled {
    opacity: .5;
    //
    pointer-events: none;
  }

  &__title {
    flex-grow: 1;
    display: block;
  }
}
</style>