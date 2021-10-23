<template>
  <div class="control-panel">
    <Input v-model="searchQuery" placeholder="Поиск..." />
    <Button :value="displayMode.text" @click="toggleDisplayMode" />
    <Button value="Добавить" @click="$emit('popup:new')" />
  </div>
</template>

<script>
import Button from '../../../components/elements/Button'
import Input from '../../elements/Input'

export default {
  name: 'ControlPanel',
  emits: [ 'displayMode:update', 'popup:new' ],
  components: {
    Button,
    Input,
  },
  data: () => ({
    displayModes: [
      { className: 'grid', text: 'Сетка' },
      { className: 'column', text: 'Столбец' },
    ],
    displayModeId: null,
    searchQuery: '',
  }),
  watch: {
    displayModeId(newValue) {
      this.$store.commit('setDisplayModeId', newValue)
    },
    searchQuery(newValue) {
      this.$store.commit('setSearchQuery', newValue)
    },
  },
  computed: {
    displayMode() {
      return this.displayModes[this.displayModeId]
    },
  },
  methods: {
    toggleDisplayMode() {
      this.displayModeId = +!this.displayModeId
      this.$emit('displayMode:update', this.displayMode)
    },
  },
  beforeMount() {
    this.displayModeId = this.$store.getters.displayModeId
    this.$emit('displayMode:update', this.displayMode)
  }
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