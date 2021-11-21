<template>
  <div class="popup__overlay" @click="$emit('popup:close', 'cancel')"></div>
  <div class="popup">
    <template v-if="!isLoading">
      <div class="popup__header">
        <div class="popup__close" @click="$emit('popup:close', 'cancel')">Закрыть</div>
      </div>
      <form action="/" method="post" @submit.prevent="save" class="popup__form">
        <label>Название</label>
        <Input v-model="data.title" />
        <label>Описание</label>
        <Textarea class="popup__textarea" v-model="data.body" />
        <label>Папка</label>
        <select class="c-input" name="folder_id" id="folder_id" v-model="data.folder_id">
          <option value="">--- Отсутствует ---</option>
          <option v-for="folder in folders" :key="folder.id" :value="folder.id">{{ folder.title }}</option>
        </select>
        <label>Категория</label>
        <select class="c-input" name="category_id" id="category_id" v-model="data.category_id">
          <option value="">--- Отсутствует ---</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
        </select>
        <div class="popup__controls">
          <Button v-if="mayBeDeleted" value="Удалить" @click="del" appearance="danger" />
          <Button value="Сохранить" @click="save" />
        </div>
      </form>
    </template>
    <Preloader :show="isLoading"/>
  </div>
</template>

<script>
import Input from '../elements/Input'
import Button from '../elements/Button'
import Textarea from '../elements/Textarea'
import Preloader from '../general/Preloader'

export default {
  name: 'NotePopup',
  emits: [ 'popup:close' ],
  components: {
    Input,
    Button,
    Textarea,
    Preloader,
  },
  props: {
    noteData: {
      type: Object,
    },
  },
  data: () => ({
    isLoading: false,
    data: {
      title: '',
      body: '',
      folder_id: '',
      category_id: '',
    },
    action: null,
  }),
  computed: {
    mayBeDeleted() {
      return !!this.data.id
    },
    folders() {
      return this.$store.getters.folders
    },
    categories() {
      return this.$store.getters.categories
    },
  },
  methods: {
    del() {
      let confirmation = confirm('Вы уверены, что хотите удалить эту заметку')
      if (!confirmation) return

      this.isLoading = true
      this.$store
        .dispatch('deleteNote', this.data.id)
        .then(() => {
          this.isLoading = false
          this.$emit('popup:close')
        })
    },
    save() {
      if (this.action === 'update') alert('Изменение еще не сделано')
      else if (this.action === 'post') {
        this.isLoading = true
        this.axios[this.action]('notes', this.data)
          .then(this.handleResponse)
          .catch(this.handleError)
          .finally(this.afterRequest)
      }
    },
    handleResponse(response) {
      let noteData = response.data.data
      this.$store.commit('pushNote', noteData)
      this.$emit('popup:close')
    },
    handleError(error) {
      let errorData = error.response.data
      console.log(errorData)
    },
    afterRequest() {
      this.isLoading = false
    },
  },
  beforeMount() {
    if (this.noteData) this.data = this.noteData
    if (!this.data.folder_id) this.data.folder_id = ''
    if (!this.data.category_id) this.data.category_id = ''
    this.action = this.data.id ? 'update' : 'post'
  },
}
</script>

<style lang="scss">
.popup {
  position: fixed;
  top: 5rem;
  left: 0;
  right: 0;
  //
  max-width: 45rem;
  padding: 3rem;
  margin: 0 auto;
  //
  background-color: var(--white);
  border-radius: .4rem;
  box-shadow: 0 0 1.5rem 0 var(--gray-90-08);
  //
  z-index: 101;

  &__overlay {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    //
    background-color: var(--white-25);
    //
    z-index: 100;
  }

  &__header {
    display: flex;
    justify-content: flex-end;
    align-items: center;
  }

  &__close {
    margin-bottom: 1.5rem;
    //
    cursor: pointer;
  }

  &__form {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    gap: 1.5rem;
  }

  &__textarea {
    min-height: 12rem;
    min-width: 100%;
  }

  &__controls {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    align-items: center;
    gap: 1.5rem;
  }
}
</style>