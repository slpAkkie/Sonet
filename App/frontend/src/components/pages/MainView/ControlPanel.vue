<template>
  <div class="control-panel">
    <Button :value="displayMode.text" @click="toggleDisplayMode" />
    <Button value="Добавить" @click="$emit('popup:new')" />
  </div>
</template>

<script>
import Button from '../../../components/elements/Button'

export default {
  name: 'ControlPanel',
  emits: [ 'displayMode:update', 'popup:new' ],
  components: {
    Button,
  },
  data: () => ({
    displayModes: [
      { className: 'grid', text: 'Сетка' },
      { className: 'column', text: 'Столбец' },
    ],
    displayModeId: 0,
  }),
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
  mounted() {
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