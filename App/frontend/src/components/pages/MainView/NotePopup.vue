<template>
  <div class="note-popup__overlay" @click="$emit('cancel')"></div>
  <div class="note-popup">
    <Preloader :play="loading" />
    <div class="note-popup__close" @click="$emit('cancel')">Закрыть</div>
    <form action="/" method="post" class="note-popup__form">
      <Input v-model="data.title" />
      <Textarea v-model="data.body" />
      <Button value="Сохранить" @click="startSaving" />
    </form>
  </div>
</template>

<script>
import Input from '../../elements/Input'
import Button from '../../elements/Button'
import Textarea from '../../elements/Textarea'
import Preloader from '../../general/Preloader'

export default {
  name: 'NotePopup',
  emits: [ 'close', 'cancel' ],
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
    loading: {
      type: Boolean,
    },
  },
  data: () => ({
    data: {
      title: '',
      body: '',
    },
  }),
  methods: {
    startSaving() {
      if (this.loading) return

      this.$emit('close', this.data)
    },
  },
  mounted() {
    this.data = this.noteData
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
  max-width: 35rem;
  padding: 3rem;
  margin: 0 auto;
  //
  background-color: var(--white);
  border-radius: .4rem;
  box-shadow: 0 0 1.5rem 0 var(--gray-90-08);

  &__overlay {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    //
    background-color: var(--white-25);
  }

  &__close {
    margin-bottom: 1rem;
    //
    text-align: right;
    //
    cursor: pointer;
  }

  &__form {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 1.5rem;
  }
}
</style>