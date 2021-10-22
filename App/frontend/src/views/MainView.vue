<template>
  <div class="control-panel">
    <Button value="Добавить" @click="openNotePopup" />
  </div>
  <div v-if="!isLoadingNotes">
    <div v-if="isNotes" class="note-wrapper" :class="classes">
      <Note v-for="note in notes" :key="note.id" :note="note" @note:open="openNote" />
    </div>
    <p v-else>У вас нет заметок</p>
  </div>
  <Preloader v-else :play="true" :noColor="true" />
  <NotePopup v-if="isPopup" :noteData="selectedNote" :loading="isPopupLoading" @close="saveNote" @cancel="closePopup" />
</template>

<script>
import Preloader from '../components/general/Preloader'
import Note from '../components/pages/Note'
import Button from '../components/elements/Button'
import NotePopup from '../components/pages/NotePopup';

export default {
  name: 'MainView',
  components: {
    Preloader,
    Note,
    Button,
    NotePopup,
  },
  data: () => ({
    isLoadingNotes: false,
    notes: [],
    displayMode: 'grid',
    isPopup: false,
    isPopupLoading: false,
    selectedNote: null,
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
        .then(this.notesLoaded)
    },
    notesLoaded(response) {
      this.isLoadingNotes = false
      this.notes = response.data.data
    },
    openNote(note) {
      this.selectedNote = note
      this.openNotePopup()
    },
    openNotePopup() {
      this.isPopup = true
    },
    closePopup() {
      this.isPopup = false
      this.isPopupLoading = false
      this.selectedNote = null
    },
    saveNote(noteData) {
      this.isPopupLoading = true
      this.axios
        .post('notes', noteData)
        .then(this.noteSaved)
        .catch(error => {
          console.log(error.response.error)
        })
    },
    noteSaved(response) {
      this.notes.unshift(response.data.data)
      this.closePopup()
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

.control-panel {
  margin-bottom: 1.5rem;
}
</style>
