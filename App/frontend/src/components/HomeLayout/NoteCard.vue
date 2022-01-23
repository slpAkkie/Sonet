<template>
  <div class="note" @click="open">
    <header class="note__header">
      <h5 class="note__title">{{ title }}</h5>
      <div class="note__category-color" :style="`--color: ${categoryColor}`"></div>
    </header>
    <main class="note__main" v-html="body"></main>
    <footer class="note__footer">
      <div v-if="note.author" class="note__author">{{ note.author }}</div>
      <div v-else class="note__comments-amount" ref="commentsAmountEl" @click="openComments">{{ comments_amount }}</div>
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
    body() {
      let split = this.note.body.split('\n')
      split.splice(3)
      return split.join('<br>')
    },
    date() {
      return (new Date(this.note['created_at'])).toLocaleDateString()
    },
    categoryColor() {
      return this.$store.getters.categoryColor(this.note.category)
    },
    comments_amount() {
      let word = '',
        amount = this.note.comments_amount,
        variants = ['комментарий', 'комментария', 'комментариев']

      if (amount % 100 === 1) word = variants[0]
      else if (Math.floor(amount / 10) % 10 !== 1 && [2, 3, 4].includes(amount % 10)) word = variants[1]
      else word = variants[2]

      return `${amount} ${word}`
    },
  },
  methods: {
    open(evt) {
      if (evt.target !== this.$refs.commentsAmountEl) this.$router.push(`/notes/${this.note.id}`)
    },
    openComments() {
      this.$router.push(`/notes/${this.note.id}/comments`)
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

  &__author {
    color: var(--primary);
  }

  &__created_at, &__comments-amount {
    color: var(--primary_muted);
  }

  &__comments-amount:hover {
    text-decoration: underline;
  }
}
</style>