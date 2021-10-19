<template>
  <div v-if="isNotes" class="note-wrapper" :class="classes">
    <Note v-for="note in notes" :key="note.id" :note="note" />
    <Note v-for="note in notes" :key="note.id" :note="note" />
  </div>
  <Preloader v-else :play="isLoadingNotes" :noColor="true" />
</template>

<script>
import Preloader from '../components/general/Preloader'
import Note from '../components/pages/Note';

export default {
  name: 'MainView',
  components: {
    Preloader,
    Note,
  },
  data: () => ({
    isLoadingNotes: false,
    notes: [],
    displayMode: 'grid',
  }),
  computed: {
    isNotes() { return !!this.notes.length },
    classes() {
      return {
        'note-wrapper_grid': this.displayMode === 'grid',
        'note-wrapper_column': this.displayMode === 'column',
      }
    },
  },
  methods: {
    loadNotes() {
      this.isLoadingNotes = true
      this.axios
        .get('notes')
        .then(response => this.notes = response.data.data)
    },
  },
  mounted() {
    if (this.$store.getters.isUserLoaded) this.loadNotes()
  }
}
</script>

<style lang="scss">
.note-wrapper {
  display: grid;
  gap: 3rem;

  &_grid {
    grid-template-columns: 1fr 1fr;
  }

  &_column {
    grid-template-columns: 1fr;
  }
}
</style>
