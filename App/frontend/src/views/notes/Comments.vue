<template>
  <div class="page-header">
    <h2 class="page-title">Комментарии {{ amountString }}</h2>
    <Button value="Назад" @click="goBack" />
  </div>

  <Preloader v-if="comments === null" />

  <div v-else>
    <div class="comment-form" :class="commentFormDisabled && 'comment-form_disabled'">
      <div class="comment-form__row">
        <Textarea class="comment-form__textarea" v-model="commentBody" />
      </div>
      <div class="comment-form__footer">
        <Button value="Отправить" @click="sendComment" />
      </div>
    </div>

    <div v-if="amount > 0" class="comments-list">
      <CommentCard
        v-for="(comment, index) in comments"
        :key="comment.id"
        :noteIndex="index"
        :comment="comment"
        @comment:delete="delComment"
      />
    </div>
    <div v-else-if="amount === 0">
      <h6>Комментариев еще нет</h6>
      <p>Оставьте комментарий первым</p>
    </div>
    <div v-else>
      <h6>Загрузка...</h6>
    </div>
  </div>
</template>

<script>
import Button from '../../components/controls/Button'
import Textarea from '../../components/controls/Textarea'
import Preloader from '../../components/Preloader'
import CommentCard from '../../components/CommentView/CommentCard'

export default {
  name: 'ViewNoteComments',
  props: [ 'note_id' ],
  components: {
    Button,
    Textarea,
    Preloader,
    CommentCard,
  },
  data: () => ({
    comments: null,
    commentBody: '',
    commentFormDisabled: false,
  }),
  computed: {
    amount() {
      return this.comments?.length
    },
    amountString() {
      let amount = this.comments?.length
      return amount === undefined ? '' : `(${amount})`
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
    delComment(noteIndex) {
      this.comments.splice(noteIndex, 1)
      this.$store.getters.note(this.note_id).comments_amount -= 1
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
      this.$store.getters.note(this.note_id).comments_amount += 1
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

  &__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
}
</style>