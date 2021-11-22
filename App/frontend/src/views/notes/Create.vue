<template>
  <NoteView>
    <Preloader v-if="isLoading" />
    <div v-else class="note-editor">
      <Input class="note-editor__title" placeholder="Название" name="title" v-model="postData.title" />
      <div class="note-editor__row">
        <div class="note-editor__col">
          <div class="note-editor__col-title">Папка</div>
          <select class="c-input" name="folder_id" id="folder_id" v-model="postData.folder_id">
            <option value="">--- Отсутствует ---</option>
            <option v-for="folder in folders" :key="folder.id" :value="folder.id">{{ folder.title }}</option>
          </select>
        </div>
        <div class="note-editor__col">
          <div class="note-editor__col-title">Категория</div>
          <select class="c-input" name="category_id" id="category_id" v-model="postData.category_id">
            <option value="">--- Отсутствует ---</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
          </select>
        </div>
      </div>
      <Textarea class="note-editor__body" name="body" v-model="postData.body" />
      <div class="note-editor__row note-editor__row_end">
        <Button value="Сохранить" @click="save" />
      </div>
    </div>
  </NoteView>
</template>

<script>
import Input from '../../components/controls/Input'
import Textarea from '../../components/controls/Textarea'
import Button from '../../components/controls/Button'
import NoteView from '../../layouts/NoteView'
import Preloader from '../../components/Preloader'

export default {
  name: 'CreateNote',
  components: {
    NoteView,
    Preloader,
    Input,
    Textarea,
    Button,
  },
  data: () => ({
    // TODO: Attachments
    postData: {
      title: '',
      body: '',
      category_id: '',
      folder_id: '',
    },
    isLoading: false,
  }),
  computed: {
    folders() {
      return this.$store.getters.folders
    },
    categories() {
      return this.$store.getters.categories
    },
  },
  methods: {
    save() {
      this.isLoading = true

      this.$store
        .dispatch('createNote', this.postData)
        .then(this.handleResponse)
        .catch(this.handleError)
    },
    handleResponse(id) {
      this.isLoading = false
      this.$router.push(`/notes/${id}`)
    },
    handleError() {
      alert('Что-то сломалось, мы уже выясняем причину')
      this.isLoading = false

      this.$router.push(`/home`)

      // TODO: Handle validation errors
    },
  },
}
</script>
