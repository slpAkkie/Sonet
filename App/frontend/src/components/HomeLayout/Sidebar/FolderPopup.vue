<template>
  <div class="popup__overlay" @click="$emit('popup:close', 'cancel')"></div>
  <div class="popup">
    <template v-if="!isLoading">
      <div class="popup__header">
        <div class="popup__close" @click="$emit('popup:close', 'cancel')">Закрыть</div>
      </div>
      <form action="/" method="post" @submit.prevent="save" class="popup__form">
        <Input v-model="data.title" />
        <div class="popup__controls">
          <Button value="Сохранить" @click="save" />
        </div>
      </form>
    </template>
    <Preloader v-if="isLoading"/>
  </div>
</template>

<script>
import Preloader from '../../Preloader'
import Input from '../../controls/Input'
import Button from '../../controls/Button'

// TODO: Refactor
export default {
  name: 'NotePopup',
  emits: [ 'popup:close' ],
  components: {
    Input,
    Button,
    Preloader,
  },
  data: () => ({
    isLoading: false,
    data: {
      title: '',
      body: '',
    },
  }),
  methods: {
    save() {
      this.isLoading = true

      this.axios.post('folders', this.data)
        .then(this.handleResponse)
        .catch(this.handleError)
        .finally(this.afterRequest)
    },
    handleResponse(response) {
      let noteData = response.data.data
      this.$store.commit('pushFolder', noteData)
      this.$emit('popup:close')
    },
    handleError(error) {
      console.log(error)
    },
    afterRequest() {
      this.isLoading = false
    },
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