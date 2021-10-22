<template>
  <div class="note">
    <header class="note__header">
      <h5 class="note__title like-link" @click="$emit('note:open', note)">{{ note.title }}</h5>
      <div class="note__category-color" :style="`--color: ${categoryColor}`"></div>
    </header>
    <main class="note__main">{{ body }}</main>
    <footer class="note__footer">
      <div class="note__author">{{ note.author }}</div>
      <div class="note__created_at">{{ date }}</div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'Note',
  emits: [ 'note:open' ],
  props: {
    note: {
      type: Object,
      required: true,
    },
  },
  computed: {
    body() {
      return this.note.body
    },
    date() {
      return (new Date(this.note.created_at)).toLocaleDateString()
    },
    categoryColor() {
      return this.note.category ? this.note.category.color : 'transparent'
    },
  },
}
</script>

<style lang="scss">
.note {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  //
  padding: 1rem 1.5rem;
  //
  background-color: var(--gray-10);
  box-shadow: 0 0 1.5rem 0 var(--gray-90-08);
  border-radius: .4rem;

  &__header, &__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  &__header {
    //
  }

  &__title {
    flex-grow: 1;
    //
    color: inherit;
  }

  &__category-color {
    --color: transparent;
    //
    width: 1.5rem;
    height: 1.5rem;
    //
    background-color: var(--color);
    border-radius: 1.5rem;
  }

  &__main {
    //
  }

  &__footer {
    //
  }

  &__author {
    color: var(--blue-50);
  }

  &__created_at {
    color: var(--gray-50);
  }
}
</style>