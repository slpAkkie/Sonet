<template>
  <Authorized>
    <h2 class="page-title">{{ pageTitle }}</h2>
    <ControlPanel />
    <Preloader v-if="isNotesLoading" :show="true" />
    <div class="notes-wrapper notes-wrapper_grid">
      <slot v-if="isNotes"></slot>
    </div>
    <h6 v-if="!isNotesLoading && !isNotes" class="text_center">Заметок нет</h6>
  </Authorized>
</template>

<script>
import Authorized from './Profile'
import ControlPanel from '../components/HomeLayout/ControlPanel'
import Preloader from '../components/Preloader'

export default {
  name: 'NotesIndexLayout',
  components: {
    Preloader,
    Authorized,
    ControlPanel,
  },
  computed: {
    pageTitle() {
      let pageTitle

      if (this.$route.name === 'IndexSharedNotes') pageTitle = 'Доступные мне'
      else if (this.$route.name === 'IndexSharedNotes') pageTitle = 'Доступные мне'
      else if (this.$route.name === 'IndexNotesWithoutFolder') pageTitle = 'Без папки'
      else if (this.$route.params.folder_id) pageTitle = 'Папка: ' + this.$store.getters.folder(this.$route.params.folder_id)?.title

      return pageTitle || 'Мои заметки'
    },
    isNotesLoading() {
      return !this.$store.getters.notesLoaded
    },
    isNotes() {
      if (this.$route.name === 'IndexNotesWithoutFolder') return !!this.$store.getters.notes.filter(note => !note['folder']).length

      if (this.$route.name === 'IndexSharedNotes') return !!this.$store.getters.sharedNotes.length

      if (this.$route.params.folder_id) return !!this.$store.getters.notesInFolder(this.$route.params.folder_id).length

      return !!this.$store.getters.notes.length
    },
  },
}
</script>

<style lang="scss">
.notes-wrapper {
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
