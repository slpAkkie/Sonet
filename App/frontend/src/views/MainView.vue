<template>
  <ControlPanel @displayMode:update="updateDisplayMode" />

  <Preloader :play="isLoading" />
  <div v-if="isNotes" class="note-wrapper" :class="displayModeClass">
    <Note v-for="note in notes" :key="note.id" :note="note" @note:open="void 0" />
  </div>
  <p v-if="isNotNotes" class="text_center">У вас нет заметок</p>
</template>

<script>
import Preloader from '../components/general/Preloader'
import Note from '../components/pages/MainView/Note'
import ControlPanel from '../components/pages/MainView/ControlPanel'

export default {
  name: 'MainView',
  emits: [ 'auth:event' ],
  components: {
    Preloader,
    Note,
    ControlPanel,
  },
  data: () => ({
    displayMode: null,
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
    }
  },
  beforeCreate() {
    this.$store.dispatch('loadNotes')
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
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 1.5rem;
  //
  margin-bottom: 1.5rem;
}
</style>
