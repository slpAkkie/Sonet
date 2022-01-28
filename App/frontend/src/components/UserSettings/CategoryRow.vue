<template>
  <div class="category-row" :class="isWaiting ? 'category-row_disabled' : ''">
    <div class="category-row__color" :style="colorStyleString"></div>
    <div class="category-row__title" @click="edit">{{ data.title }} <span class="category-row__amount">[{{ data.notes_amount }}]</span></div>
    <div class="category-row__controls">
      <Button value="-" appearance="danger" @click="del" />
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
  computed: {
    colorStyleString() {
      return `--color: ${this.data.color}`
    },
  },
  methods: {
    edit() {
      this.$emit('category:edit', this.data)
    },
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

  &__color {
    width: 3rem;
    height: 1.5rem;
    margin-right: 1.5rem;
    //
    background-color: var(--color);
    border-radius: 1.5rem;
  }

  &__title {
    flex-grow: 1;
    display: block;
    //
    cursor: pointer;
  }

  &__amount {
    color: var(--primary_muted);
  }
}
</style>