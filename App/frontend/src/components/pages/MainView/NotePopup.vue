<template>
  <div class="note-popup__overlay" @click="$emit('popup:close', 'cancel')"></div>
  <div class="note-popup">
    <template v-if="!isLoading">
      <div class="note-popup__close" @click="$emit('popup:close', 'cancel')">Закрыть</div>
      <form action="/" method="post" @submit.prevent="save" class="note-popup__form">
        <Input v-model="data.title" />
        <Textarea class="note-popup__textarea" v-model="data.body" />
        <div class="note-popup__controls">
          <Button v-if="mayBeDeleted" value="Удалить" @click="del" appearance="danger" />
          <Button value="Сохранить" @click="save" />
        </div>
      </form>
    </template>
    <Preloader :play="isLoading" />
  </div>
</template>

<script>
import Input from '../../elements/Input'
import Button from '../../elements/Button'
import Textarea from '../../elements/Textarea'
import Preloader from '../../general/Preloader'

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
    },
    action: null,
  }),
  computed: {
    mayBeDeleted() {
      return !!this.data.id
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
    this.action = this.data.id ? 'update' : 'post'
  },
}
</script>

<style lang="scss">
.note-popup {
  position: absolute;
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

  &__overlay {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    //
    background-color: var(--white-25);
  }

  &__close {
    margin-bottom: 1.5rem;
    //
    text-align: right;
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