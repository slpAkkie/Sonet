<template>
  <Preloader :play="isLoading" />
  <div class="note-editor" v-if="noteLoaded">
    <Input class="note-editor__title" placeholder="Название" name="title" v-model="note.title" />
    <div class="note-editor__row">
      <div class="note-editor__col">
        <div>Папка</div>
        <select class="c-input" name="folder_id" id="folder_id" v-model="note.folder_id">
          <option value="">--- Отсутствует ---</option>
          <option v-for="folder in folders" :key="folder.id" :value="folder.id">{{ folder.title }}</option>
        </select>
      </div>
      <div class="note-editor__col">
        <div>Категория</div>
        <select class="c-input" name="category_id" id="category_id" v-model="note.category_id">
          <option value="">--- Отсутствует ---</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
        </select>
      </div>
    </div>
    <Textarea class="note-editor__body" name="body" v-model="note.body" />
    <div class="note-editor__row note-editor__row_end">
      <Button appearance="danger" value="Удалить" @click="del" />
    </div>
  </div>
  <template v-if="noteLoadingFailed">Мы не смогли открыть вашу заметку, попробуйте перезагрузить страницу</template>
</template>

<script>
import Preloader from '../components/general/Preloader'
import Input from '../components/elements/Input'
import Textarea from '../components/elements/Textarea'
import Button from "../components/elements/Button";

export default {
  name: 'NoteView',
  components: {
    Preloader,
    Input,
    Textarea,
    Button,
  },
  props: {
    id: String,
  },
  data: () => ({
    isLoading: null,
    note: null,
  }),
  computed: {
    noteLoaded() {
      return !this.isLoading && this.note !== null
    },
    noteLoadingFailed() {
      return !this.isLoading && this.note === null
    },
    folders() {
      return this.$store.getters.folders
    },
    categories() {
      return this.$store.getters.categories
    },
  },
  methods: {
    handleResponse(response) {
      this.note = response.data.data
      this.note.category_id = this.note.category?.id || ''
      this.note.folder_id = this.note.folder?.id || ''
    },
    handleError() {
      alert('Something went wrong!')
    },
    handleFinally() {
      this.isLoading = false
    },
    del() {
      let confirmation = confirm('Вы уверены, что хотите удалить эту заметку')
      if (!confirmation) return

      this.isLoading = true
      this.$store
          .dispatch('deleteNote', this.note.id)
          .then(() => {
            this.isLoading = false
            this.$router.push('/')
          })
    },
  },
  mounted() {
    this.isLoading = true

    this.axios
      .get(`notes/${this.id}`)
      .then(this.handleResponse)
      .catch(this.handleError)
      .finally(this.handleFinally)
  }
}
</script>

<style lang="scss">
.note-editor {
  &__title {
    margin-bottom: 1.5rem;
  }

  &__body {
    min-height: 15rem;
    margin-bottom: 1.5rem;
    //
    resize: vertical;
  }

  &__row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
    //
    margin-bottom: 1.5rem;

    &_end {
      justify-content: flex-end;
    }
  }

  &__col {
    flex-grow: 1;
  }
}
</style>