<template>
  <ControlPanel
      @displayMode:update="updateDisplayMode"
      @popup:new="openNewNote"
  />

  <Preloader :show="isLoading"/>
  <div v-if="isNotes" class="note-wrapper" :class="displayModeClass">
    <Note
        v-for="note in notes"
        :key="note.id"
        :note="note"
        @click="openNote(note.id)"
    />
  </div>
  <p v-if="isNotNotes" class="text_center">Заметок нет</p>

  <NotePopup
      v-if="openedPopup"
      @popup:close="closePopup"
      :noteData="openedNote"
  />
</template>

<script>
import Preloader from '../components/general/Preloader'
import Note from '../components/Home/Note'
import ControlPanel from '../components/Home/ControlPanel'
import NotePopup from '../components/Home/NotePopup'

export default {
  name: 'MainView',
  emits: [ 'auth:event' ],
  components: {
    Preloader,
    Note,
    ControlPanel,
    NotePopup,
  },
  data: () => ({
    displayMode: null,
    openedPopup: false,
    openedNote: null,
  }),
  computed: {
    notes() {
      return this.$store.getters.notes
    },
    isLoading() {
      return !this.$store.getters.notesLoaded
    },
    isNotes() {
      return !this.isLoading && !!this.$store.getters.notes.length
    },
    isNotNotes() {
      return !this.isLoading && !this.$store.getters.notes.length
    },
    displayModeClass() {
      return this.displayMode ? `note-wrapper_${this.displayMode.className}` : null
    },
  },
  methods: {
    updateDisplayMode(displayMode) {
      this.displayMode = displayMode
    },
    openNewNote() {
      this.openedPopup = true
    },
    async openNote(id) {
      await this.$router.push(`/notes/${id}`)
      // this.openedNote = Object.assign({}, await this.$store.dispatch('getNote', id))
      // this.openedPopup = true
    },
    closePopup() {
      this.openedPopup = false
      this.openedNote = null
    },
  },
  beforeMount() {
    this.$store.dispatch('loadNotes')
    this.$store.dispatch('loadCategories')
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
