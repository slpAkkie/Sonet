<template>
  <NoteView>
    <Preloader v-if="isLoading" />
    <div class="note-editor" v-else-if="!requestFailed">
      <Input class="note-editor__title" placeholder="Название" name="title" v-model="title" />
      <div v-if="!isShared" class="note-editor__row">
        <div class="note-editor__col">
          <div class="note-editor__col-title">Папка</div>
          <select class="c-input" name="folder_id" id="folder_id" v-model="folder_id">
            <option value="">--- Отсутствует ---</option>
            <option v-for="folder in folders" :key="folder.id" :value="folder.id">{{ folder.title }}</option>
          </select>
        </div>
        <div class="note-editor__col">
          <div class="note-editor__col-title">Категория</div>
          <select class="c-input" name="category_id" id="category_id" v-model="category_id">
            <option value="">--- Отсутствует ---</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
          </select>
        </div>
      </div>
      <Textarea class="note-editor__body" name="body" v-model="body" />
      <div class="note-editor__row note-editor__row_end">
        <Button value="Сохранить" @click="update" />
        <Button appearance="danger" value="Удалить" @click="del" />
      </div>
    </div>
    <div v-else>
      <h5>Мы не смогли открыть эту заметку</h5>
      <p>Попробуйте перезагрузить страницу</p>
      <p>Если ошибка повториться, возможно у вас нет доступа к этой заметки</p>
    </div>
  </NoteView>
</template>

<script>
import Preloader from '../../components/Preloader'
import Input from '../../components/controls/Input'
import Textarea from '../../components/controls/Textarea'
import Button from '../../components/controls/Button'
import NoteView from '../../layouts/NoteView'

export default {
  name: 'ViewNote',
  components: {
    NoteView,
    Preloader,
    Input,
    Textarea,
    Button,
  },
  props: {
    id: String,
  },
  data: () => ({
    // TODO: Attachments
    isWaiting: false,
    changes: {},
  }),
  computed: {
    isLoading() {
      return (this.note === null || this.isWaiting) && !this.requestFailed
    },
    note() {
      return this.$store.getters.note(this.id)
    },
    isShared() {
      return this.$store.getters.isShared(this.id)
    },
    requestFailed() {
      return this.note === false
    },
    title: {
      get() {
        return this.changes['title'] !== undefined ? this.changes['title'] : this.note['title']
      },
      set(value) {
        this.changes['title'] = value
      },
    },
    body: {
      get() {
        return this.changes['body'] !== undefined ? this.changes['body'] : this.note['body']
      },
      set(value) {
        this.changes['body'] = value
      },
    },
    folder_id: {
      get() {
        return this.changes['folder_id'] !== undefined ? this.changes['folder_id'] : this.note['folder'] || ''
      },
      set(value) {
        this.changes['folder_id'] = value
      },
    },
    category_id: {
      get() {
        return this.changes['category_id'] !== undefined ? this.changes['category_id'] : this.note['category']?.id || ''
      },
      set(value) {
        this.changes['category_id'] = value
      },
    },
    folders() {
      return this.$store.getters.folders
    },
    categories() {
      return this.$store.getters.categories
    },
    postData() {
      return {
        id: this.note.id,
        ...this.changes,
      }
    },
  },
  methods: {
    update() {
      this.isWaiting = true

      this.$store
        .dispatch('updateNote', this.postData)
        .then(this.handleUpdateResponse)
    },
    handleUpdateResponse() {
      this.isWaiting = false
    },
    del() {
      this.$store
        .dispatch('deleteNote', this.id)
        .catch(this.handleDelError)
        .finally(this.afterDelRequest)
    },
    handleDelError() {
      alert('Что-то сломалось, мы уже выясняем причину')
    },
    afterDelRequest() {
      this.$router.push('/home')
    },
  },
}
</script>
