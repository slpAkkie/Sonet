<template>
  <div class="comment-row" :class="disabled ? 'comment-row_disabled' : ''">
    <h6 class="comment-row__author">{{ comment.user }}</h6>
    <p class="comment-row__body">{{ comment.body }}</p>
    <div class="comment-row__footer">
      <div class="comment-row__created-at">{{ (new Date(comment.created_at)).toLocaleDateString() }}</div>
      <!-- Disable button if you don't own -->
      <Button appearance="danger" value="Удалить" @click="del" />
    </div>
  </div>
</template>

<script>
import Button from '../controls/Button'

export default {
  name: 'CommentCard',
  props: [ 'comment', 'noteIndex' ],
  data: () => ({
    disabled: false,
  }),
  components: {
    Button,
  },
  methods: {
    del() {
      this.disabled = true

      this.$store.dispatch('deleteComment', this.comment.id)
        .then(this.handleResponse)
        .catch(this.handleError)
        .finally(this.afterRequest)
    },
    handleResponse() {
      this.$emit('comment:delete', this.noteIndex)
    },
    handleError(error) {
      // TODO: Handle error
      console.log(error)
    },
    afterRequest() {
      this.disabled = false
    },
  },
}
</script>

<style lang="scss">
.comment-row {
  &_disabled {
    opacity: .5;
    //
    pointer-events: none;
  }
}
</style>