<template>
  <div class="control-panel">
    <Input v-model="searchQuery" placeholder="Поиск..." />
    <Button value="Новая заметка" @click="createNewNote" />
  </div>
</template>

<script>
import Input from '../controls/Input'
import Button from '../controls/Button'

export default {
  name: 'ControlPanel',
  components: {
    Button,
    Input,
  },
  computed: {
    searchQuery: {
      get() {
        return this.$store.state.searchQuery
      },
      set(value) {
        this.$store.commit('updateSearchQuery', value)
      },
    },
  },
  methods: {
    createNewNote() {
      this.$router.push('/notes/create')
    },
  },
}
</script>

<style lang="scss">
.control-panel {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 1.5rem;
  //
  margin-bottom: 1.5rem;
}
</style>