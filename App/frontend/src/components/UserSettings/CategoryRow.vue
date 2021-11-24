<template>
  <div class="category-row">
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
  methods: {
    del() {
      this.$store
        .dispatch('deleteCategory', this.data.id)
    },
  },
}
</script>

<style lang="scss">
.category-row {
  display: flex;
  align-items: center;

  &__title {
    display: block;
    flex-grow: 1;

    &.link_exact-active {
      position: relative;

      &::before {
        content: '';
        //
        position: absolute;
        top: 50%;
        left: -1rem;
        //
        width: .3rem;
        height: 100%;
        //
        background-color: var(--blue-50);
        //
        transform: translateY(-50%);
      }
    }
  }
}
</style>