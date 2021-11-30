<template>
  <div class="attachment-card" @click="openAttachment" :class="isWaiting && 'attachment-card_disabled'">
    <span class="attachment-card__title">{{ title }}</span>
    <Button value="Удалить" ref="delButton" appearance="danger" @click="del" />
  </div>
</template>

<script>
import Button from '../controls/Button'

export default {
  name: 'AttachmentCard',
  components: {
    Button,
  },
  props: {
    attachment: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    isWaiting: false,
  }),
  computed: {
    title() {
      return `${this.attachment.title.slice(0, 8).trim()}${this.attachment.title.length > 8 ? '...' : ''}`
    },
    link() {
      return `//api.akkie.ru/storage/${this.attachment.path}`
    },
  },
  methods: {
    del() {
      this.isWaiting = true

      this.$store.dispatch('deleteAttachment', this.attachment.id)
        .then(() => {
          this.$emit('deleted', this.attachment.id)
        })
      .finally(() => { this.isWaiting = false })
    },
    openAttachment(evt) {
      if (evt.target === this.$refs.delButton.$el) return

      window.open(this.link, '_blank');
    },
  },
}
</script>

<style lang="scss">
.attachment-card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  //
  width: 12rem;
  height: 12rem;
  padding: 2rem 1.5rem;
  //
  border: .2rem dashed var(--primary_muted);
  color: var(--c-text);
  //
  cursor: pointer;

  &_disabled {
    opacity: .5;
    //
    pointer-events: none;
  }

  &__title {
    text-align: center;
    word-break: break-all;
  }
}
</style>