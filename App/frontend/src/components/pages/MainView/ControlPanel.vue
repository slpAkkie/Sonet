<template>
  <div class="control-panel">
    <Button :value="displayMode.text" @click="toggleDisplayMode" />
    <Button value="Добавить" @click="void 0" />
  </div>
</template>

<script>
import Button from '../../../components/elements/Button'

export default {
  name: 'ControlPanel',
  components: {
    Button,
  },
  data: () => ({
    displayModes: [
      {className: 'grid', text: 'Сетка'},
      {className: 'column', text: 'Столбец'},
    ],
    displayModeId: 0,
  }),
  watch: {
    displayModeId() {
      this.$emit('displayMode:update', this.displayMode)
    }
  },
  computed: {
    displayMode() {
      return this.displayModes[this.displayModeId]
    },
  },
  methods: {
    toggleDisplayMode() {
      this.displayModeId = +!this.displayModeId
    },
  },
  mounted() {
    this.$emit('displayMode:update', this.displayMode)
  }
}
</script>

<style lang="scss">

</style>