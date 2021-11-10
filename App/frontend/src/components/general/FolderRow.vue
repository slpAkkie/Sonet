<template>
  <div class="folder-row">
    <div class="folder-row__title" @click="select">{{ title }}</div>
    <div v-if="withControls" class="folder-row__controls">
      <Button value="Удалить" appearance="danger" @click="del" />
    </div>
  </div>
</template>

<script>
import Button from '../elements/Button'

export default {
  name: 'FolderRow',
  emits: [
      'folder:select',
      'folder:del',
  ],
  components: {
    Button,
  },
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
    del() {
      this.$emit('folder:del', this.id)
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
    padding: .7rem 0;
  }
}
</style>