<template>
  <div class="popup__overlay" @click="$emit('popup:close', 'cancel')"></div>
  <div class="popup">
    <div class="popup__inner" v-if="!isLoading">
      <div class="popup__header">
        <h6>Новая категория</h6>
        <div class="popup__close" @click="$emit('popup:close', 'cancel')">Закрыть</div>
      </div>
      <form action="/" method="post" @submit.prevent="save" class="popup__form">
        <Input v-model="postData.title" />
        <div class="popup__controls">
          <Input class="category-popup__color-picker" type="color" v-model="postData.color" />
          <Button value="Сохранить" @click="save" />
        </div>
      </form>
    </div>
    <Preloader v-if="isLoading"/>
  </div>
</template>

<script>
import Preloader from '../Preloader'
import Input from '../controls/Input'
import Button from '../controls/Button'

export default {
  name: 'CategoryPopup',
  emits: [ 'popup:close' ],
  components: {
    Preloader,
    Input,
    Button,
  },
  data: () => ({
    isLoading: false,
    postData: {
      title: '',
      color: '#000000',
    },
  }),
  methods: {
    save() {
      this.isLoading = true

      this.$store.dispatch('createCategory', this.postData)
        .then(this.handleResponse)
        .catch(this.handleError)
        .finally(this.afterRequest)
    },
    handleResponse() {
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
.category-popup {
  &__color-picker {
    flex-grow: 1;
    width: auto;
  }
}
</style>