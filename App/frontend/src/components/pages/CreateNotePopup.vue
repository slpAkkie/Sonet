<template>
  <div class="create-note-popup__overlay" @click="$emit('cancel')"></div>
  <div class="create-note-popup">
    <Preloader :play="loading">
      <form action="/" method="post" class="create-note-popup__form">
        <Input v-model="data.title" />
        <Textarea v-model="data.body" />
        <Button value="Сохранить" @click="startSaving" />
      </form>
    </Preloader>
  </div>
</template>

<script>
import Input from '../elements/Input'
import Button from '../elements/Button'
import Textarea from '../elements/Textarea'
import Preloader from "../general/Preloader";

export default {
  name: 'CreateNotePopup',
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
}
</script>

<style lang="scss">
.create-note-popup {
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

  &__form {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 1.5rem;
  }
}
</style>