<template>
  <NoteView>
    <Preloader v-if="isLoading" />
    <div class="note-editor" v-else-if="!requestFailed">
      <Input class="note-editor__title" placeholder="Название" name="title" v-model="title" />
      <div v-if="!isShared" class="note-editor__row">
        <div class="note-editor__col">
          <div class="note-editor__col-title">Папка</div>
          <select class="c-input" name="folder_id" id="folder_id" v-model="folder_id">
            <option value="">--- Отсутствует ---</option>
            <option v-for="folder in folders" :key="folder.id" :value="folder.id">{{ folder.title }}</option>
          </select>
        </div>
        <div class="note-editor__col">
          <div class="note-editor__col-title">Категория</div>
          <select class="c-input" name="category_id" id="category_id" v-model="category_id">
            <option value="">--- Отсутствует ---</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.title }}</option>
          </select>
        </div>
      </div>
      <div class="note-editor__row">
        <Textarea class="note-editor__body" name="body" v-model="body" />
      </div>

      <div class="note-editor__attachments">
        <div class="note-editor__row">
          <h4 class="note-editor__section-title">Вложения</h4>
        </div>
        <div class="note-editor__row">
          <div class="note-editor__attachments-list">
            <AttachmentCard
              v-for="attachment in note.attachments"
              :key="attachment.id"
              :attachment="attachment"
              @deleted="removeAttachment"
            />
            <Preloader v-for="(item, i) in processingAttachments" :key="i" />
            <div class="note-editor__add-attachment" @click="openInputDialogue">+</div>
            <input type="file" multiple ref="attachmentsInput" hidden @change="processAttachment">
          </div>
        </div>
      </div>

      <div class="note-editor__row note-editor__row_end">
        <Button appearance="danger" value="Удалить" @click="del" />
        <Button value="Сохранить" @click="update" />
      </div>

      <div v-if="!isShared" class="note-editor__accesses">
        <div class="note-editor__row">
          <h4 class="note-editor__section-title">Доступ</h4>
        </div>
        <div class="note-editor__row">
          <div class="note-editor__col">
            <Input placeholder="E-mail" list="email-datalist" v-model="contributor_email" />
            <datalist id="email-datalist" v-if="contributors_hint">
              <option v-for="contributor in contributors_hint" :key="contributor['id']" :value="contributor['email']">{{ contributor['full_name'] }}</option>
            </datalist>
          </div>
          <div class="note-editor__col">
            <select class="c-input" name="access_level_id" id="access_level_id" v-model="access_level_id">
              <option value="">Выберите уровень доступа</option>
              <option v-for="access_level in accessLevels" :key="access_level.id" :value="access_level.id">{{ access_level.title }}</option>
            </select>
          </div>
          <div class="note-editor__col note-editor__col_shrink">
            <Button value="Дать доступ" @click="addContributor" />
          </div>
        </div>
        <Preloader v-if="isAccessesLoading" />
        <div v-else class="note-editor__contributors-list">
          <ContributorRow
            v-for="contributor in contributors"
            :key="contributor.user.id"
            :contributor="contributor"
            @del="deleteContributor"
          />
        </div>
      </div>
    </div>
    <div v-else>
      <h5>Мы не смогли открыть эту заметку</h5>
      <p>Попробуйте перезагрузить страницу</p>
      <p>Если ошибка повториться, возможно у вас нет доступа к этой заметки</p>
    </div>
  </NoteView>
</template>

<script>
import Preloader from '../../components/Preloader'
import Input from '../../components/controls/Input'
import Textarea from '../../components/controls/Textarea'
import Button from '../../components/controls/Button'
import NoteView from '../../layouts/NoteView'
import ContributorRow from '../../components/NoteView/ContributorRow'
import AttachmentCard from '../../components/NoteView/AttachmentCard'

export default {
  name: 'ViewNote',
  components: {
    NoteView,
    Preloader,
    Input,
    Textarea,
    Button,
    AttachmentCard,
    ContributorRow,
  },
  props: {
    id: String,
  },
  data: () => ({
    isWaiting: false,
    isAccessesLoading: false,
    changes: {},
    note: null,
    processingAttachments: [],
    attachments: [],
    contributors: null,
    contributors_hint: null,
    contributors_hint_debounce_timeout_id: null,
    contributor_email: '',
    access_level_id: '',
  }),
  watch: {
    contributor_email(email) {
      if (this.contributors_hint_debounce_timeout_id) clearTimeout(this.contributors_hint_debounce_timeout_id)

      if (this.contributors_hint?.some(hint => hint['email'] === email)) return

      this.contributors_hint_debounce_timeout_id = setTimeout(() => {
        this.contributors_hint_debounce_timeout_id = null
        this.loadContributorsHint()
      }, 750)
    },
    processingAttachments: {
      handler(value) {
        if (!value[0]) return

        this.$store
          .dispatch('saveAttachment', { note_id: this.id, attachment: value[0] })
          .then((response) => {
            this.processingAttachments.shift()
            this.note.attachments.push(response)
          })
      },
      deep: true,
    },
  },
  computed: {
    isLoading() {
      return this.note === null || this.isWaiting
    },
    isShared() {
      return this.$store.getters.isShared(this.id)
    },
    isAttachments() {
      return !!this.note.attachments.length
    },
    requestFailed() {
      return this.note === false
    },
    title: {
      get() {
        if (!this.note) return ''

        return this.changes['title'] !== undefined ? this.changes['title'] : this.note['title']
      },
      set(value) {
        this.changes['title'] = value
      },
    },
    body: {
      get() {
        if (!this.note) return ''

        return this.changes['body'] !== undefined ? this.changes['body'] : this.note['body']
      },
      set(value) {
        this.changes['body'] = value
      },
    },
    folder_id: {
      get() {
        if (!this.note) return ''

        return this.changes['folder_id'] !== undefined ? this.changes['folder_id'] : this.note['folder'] || ''
      },
      set(value) {
        this.changes['folder_id'] = value
      },
    },
    category_id: {
      get() {
        if (!this.note) return ''

        return this.changes['category_id'] !== undefined ? this.changes['category_id'] : this.note['category'] || ''
      },
      set(value) {
        this.changes['category_id'] = value
      },
    },
    folders() {
      return this.$store.getters.folders
    },
    categories() {
      return this.$store.getters.categories
    },
    accessLevels() {
      return this.$store.getters.accessLevels
    },
    postData() {
      return {
        id: this.note.id,
        ...this.changes,
      }
    },
  },
  methods: {
    async loadNote() {
      this.note = await this.$store.dispatch('loadNote', this.id)
    },
    update() {
      this.isWaiting = true

      this.$store
        .dispatch('updateNote', this.postData)
        .then(this.handleUpdateResponse)
    },
    handleUpdateResponse() {
      this.isWaiting = false
    },
    del() {
      if (!confirm('Вы уверены что хотите удалить заметку')) return

      this.isWaiting = true

      this.$store
        .dispatch('deleteNote', this.id)
        .catch(this.handleDelError)
        .finally(this.afterDelRequest)
    },
    handleDelError(error) {
      console.log(error)
      if (error.response.status === 403) {
        alert(error.response.data.error.message)
      } else alert('Что-то сломалось, мы уже выясняем причину')
    },
    afterDelRequest() {
      this.$router.push('/home')
    },
    loadContributorsHint() {
      if (!this.contributor_email) return

      this.$store
        .dispatch('findUserByEmail', this.contributor_email)
        .then(response => this.contributors_hint = response)
    },
    loadContributors() {
      this.isAccessesLoading = true
      this.$store
        .dispatch('loadContributors', this.id)
        .then(response => this.contributors = response)
        .catch(() => {
          alert('Что-то сломалось, мы уже выясняем причину')
          this.$router.push('/home')
        })
        .finally(() => {
          this.isAccessesLoading = false
        })
    },
    addContributor() {
      this.$store
        .dispatch('addContributor', {
          note_id: this.id,
          email: this.contributor_email,
          access_level_id: this.access_level_id,
        })
        .then(response => {
          this.contributor_email = ''
          this.access_level_id = ''
          this.contributors_hint = null

          let index = this.contributors.findIndex(contributor => contributor.user.id === response.user.id)
          if (index !== -1) this.contributors[index] = response
          else this.contributors.unshift(response)
        })
        .catch(this.handleContributorError)
    },
    handleContributorError(error) {
      if (error.response.status === 422) {
        let errors = error.response.data.error.errors
        let errorMessage = []
        for (let e in errors) if (Object.getOwnPropertyDescriptor(errors, e))
          errorMessage.push(`${errors[e]}`)

        alert(errorMessage.join(', '))
      }
    },
    deleteContributor(contributor_id) {
      this.$store
        .dispatch('deleteContributor', {
          note_id: this.id,
          contributor_id,
        })
        .then(() => {
          this.loadContributors()
        })
        .catch(() => {
          alert('Что-то сломалось, мы уже выясняем причину')
        })
    },
    openInputDialogue() {
      this.$refs.attachmentsInput.click()
    },
    processAttachment(evt) {
      this.processingAttachments.push(...evt.target.files)
      evt.target.value = null
    },
    removeAttachment(id) {
      let index = this.note.attachments.findIndex(attachment => attachment.id === id)
      this.note.attachments.splice(index, 1)
    },
  },
  beforeMount() {
    this.loadNote()
    this.loadContributors()
    this.$store.dispatch('loadAccessLevels')
  }
}
</script>

<style lang="scss">
.note-editor {
  &__attachments-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-items: center;
    gap: 1.5rem;
  }

  &__add-attachment {
    display: grid;
    place-content: center;
    //
    width: 12rem;
    height: 12rem;
    //
    font-size: 7rem;
    line-height: 1em;
    //
    border: .2rem dashed var(--primary_muted);
    color: var(--primary_muted);
    //
    cursor: pointer;
  }
}
</style>