<template>
  <li class="account-tab__log-row" :class="disabled ? 'account-tab__log-row_disabled' : ''">
    <span class="account-tab__os-log">{{ os }}</span> <span class="account-tab__date-log">Последнее действие: {{ update_at }} | Вход {{ created_at }}</span> <Button v-if="!log.current" appearance="danger" value="Деактивировать" class="account-tab__deactivate" @click="deactivate" /> <span class="account-tab__current-session" v-else>Текущий сеанс</span>
  </li>
</template>

<script>
import Button from '../controls/Button'

export default {
  name: 'AuthLogRow',
  props: [ 'log', 'index' ],
  components: {
    Button,
  },
  data: () => ({
    disabled: false,
  }),
  computed: {
    os() {
      let found = this.log['user_agent'].match(/\([^;]*;\s([^;]*);\s[^;]*\)/)
      return found ? found[1] : 'Не известная ОС'
    },
    update_at() {
      return (new Date(this.log['updated_at'])).toLocaleString()
    },
    created_at() {
      return (new Date(this.log['created_at'])).toLocaleString()
    },
  },
  methods: {
    async deactivate() {
      this.disabled = true
      await this.axios.delete(`user/auth-logs/${this.log.id}`)

      this.$emit('deactivated', this.index)
      this.disabled = false
    },
  },
}
</script>

<style lang="scss">

</style>