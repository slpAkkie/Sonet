<template>
  <div class="note" @click="open">
    <header class="note__header">
      <h5 class="note__title">{{ title }}</h5>
      <div class="note__category-color" :style="`--color: ${categoryColor}`"></div>
    </header>
    <main class="note__main">{{ note.body }}</main>
    <footer class="note__footer">
      <div class="note__author">{{ note.author }}</div>
      <div class="note__created_at">{{ date }}</div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'NoteCard',
  props: {
    note: {
      type: Object,
      required: true,
    },
  },
  computed: {
    title() {
      return `${this.note.title.slice(0, 25).trim()}${this.note.title.length > 25 ? '...' : ''}`
    },
    date() {
      return (new Date(this.note['created_at'])).toLocaleDateString()
    },
    categoryColor() {
      return this.$store.getters.categoryColor(this.note.category)
    },
  },
  methods: {
    open() {
      this.$router.push(`/notes/${this.note.id}`)
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
  background-color: var(--bg-lighter);
  box-shadow: 0 0.5rem 1.5rem -1rem var(--primary);
  border-radius: .4rem;
  //
  cursor: pointer;

  &__header, &__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  &:hover > &__header {
    color: var(--secondary);
    //
    transition: color .1s ease;
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
    flex-grow: 1;
  }

  &__footer {
    //
  }

  &__author {
    color: var(--primary);
  }

  &__created_at {
    color: var(--primary_muted);
  }
}
</style>