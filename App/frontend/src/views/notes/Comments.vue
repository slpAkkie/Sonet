<template>
  <div class="page-header">
    <h2 class="page-title">Комментарии ({{ amount }})</h2>
    <Button value="Назад" @click="goBack" />
  </div>

  <div class="comment-form" :class="commentFormDisabled && 'comment-form_disabled'">
    <div class="comment-form__row">
      <Textarea class="comment-form__textarea" v-model="commentBody" />
    </div>
    <div class="comment-form__footer">
      <Button value="Отправить" @click="sendComment" />
    </div>
  </div>

  <div v-if="amount > 0" class="comments-list">
    <div class="comment-row" v-for="comment in comments" :key="comment.id">
      <h6 class="comment-row__author">{{ comment.user }}</h6>
      <p class="comment-row__body">{{ comment.body }}</p>
      <div class="comment-row__created-at">{{ (new Date(comment.created_at)).toLocaleDateString() }}</div>
    </div>
  </div>
  <div v-else-if="amount === 0">
    <h6>Комментариев еще нет</h6>
    <p>Оставьте комментарий первым</p>
  </div>
  <div v-else>
    <h6>Загрузка...</h6>
  </div>
</template>

<script>
import Button from '../../components/controls/Button'
import Textarea from '../../components/controls/Textarea'

export default {
  name: 'ViewNoteComments',
  props: [ 'note_id' ],
  components: {
    Button,
    Textarea,
  },
  data: () => ({
    comments: null,
    commentBody: '',
    commentFormDisabled: false,
  }),
  computed: {
    amount() {
      let amount = this.comments?.length
      return amount === undefined ? '...' : amount
    },
    postData() {
      return {
        commentBody: this.commentBody,
        note_id: this.note_id,
      }
    },
  },
  methods: {
    async loadComments() {
      this.comments = await this.$store.dispatch('loadComments', this.note_id)
    },
    goBack() {
      this.$router.push(`/notes/${this.note_id}`)
    },
    sendComment() {
      this.commentFormDisabled = true

      this.$store.dispatch('addComment', this.postData)
        .then(this.handleResponse)
        .catch(this.handleError)
        .finally(this.afterRequest)
    },
    handleResponse(response) {
      this.comments.unshift(response)
      this.commentBody = ''
    },
    handleError(error) {
      // TODO: Error handler
      console.log(error)
    },
    afterRequest() {
      this.commentFormDisabled = false
    },
  },
  mounted() {
    this.loadComments()
  }
}
</script>

<style lang="scss">
.page-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 1.5rem;
}

.comment-form {
  &_disabled {
    opacity: .5;
    //
    pointer-events: none;
  }

  &__row {
    margin-bottom: 1.5rem;
  }

  &__textarea {
    min-height: 8rem;
    resize: vertical;
  }

  &__footer {
    display: flex;
    justify-content: flex-end;
  }
}

.comments-list {
  margin-top: 2.5rem;
}

.comment-row {
  margin-bottom: 2rem;
  padding: 1rem;
  //
  background-color: var(--bg-lighter);
  border-radius: .4rem;

  &__body {
    margin-top: 1rem;
    margin-bottom: 1rem;
  }

  &__created-at {
    color: var(--primary_muted);
    font-size: 1.4rem;
  }
}
</style>