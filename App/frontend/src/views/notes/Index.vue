<template>
  <NoteCard
      v-for="note in notes"
      :key="note.id"
      :note="note"
  />
</template>

<script>
import NoteCard from '../../components/HomeLayout/NoteCard'

export default {
  name: 'IndexNotes',
  props: {
    folder_id: {
      required: false,
      default: null,
    },
  },
  components: {
    NoteCard,
  },
  computed: {
    notes() {
      if (this.$route.name === 'IndexNotesWithoutFolder') return this.$store.getters.notes.filter(note => !note['folder'])

      if (this.$route.name === 'IndexSharedNotes') return this.$store.getters.sharedNotes

      if (this.folder_id !== null) return this.$store.getters.notesInFolder(this.folder_id)

      return this.$store.getters.notes
    },
  },
}
</script>

<style lang="scss">

</style>
