<template>
  <div class="folder-row">
    <div class="folder-row__title" @click="select">{{ title }}</div>
    <div v-if="withControls" class="folder-row__controls"></div>
  </div>
</template>

<script>
export default {
  name: 'FolderRow',
  props: {
    title: {
      type: String,
      required: true,
    },
    id: {
      type: Number,
      required: false,
      default: null,
    },
    withControls: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    select() {
      this.$emit('folder:select', this.id || null)
    },
  },
}
</script>

<style lang="scss">
.folder-row {
  display: flex;
  align-items: center;
  //
  padding: 0 1rem;
  margin: .75rem 0;
  //
  transition-property: background-color, color;
  transition-timing-function: ease;
  transition-duration: .1s;
  cursor: pointer;

  &:hover {
    color: var(--white);
    background-color: var(--blue-50);
  }

  &__title {
    flex-grow: 1;
    //
    padding: .5rem 0;
  }
}
</style>