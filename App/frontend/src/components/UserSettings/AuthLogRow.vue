<template>
  <li class="account-tab__log-row" :class="disabled ? 'account-tab__log-row_disabled' : ''">
    <div><div class="account-tab__os-log">{{ os }}</div><div class="account-tab__date-log"><div>Последнее действие: {{ update_at }}</div><div>Вход {{ created_at }}</div></div></div><Button v-if="!log.current" appearance="danger" value="Выйти" class="account-tab__deactivate" @click="deactivate" /> <span class="account-tab__current-session" v-else>Текущий сеанс</span>
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
      let found = this.log['user_agent'].match(/\(([^)]*)\)/)
      if (!found) return this.log['user_agent'].split(' ')[0]

      found = found[1].split('; ')
      return found[0] === 'Linux' ? found[1] : found[0]
    },
    update_at() {
      return (new Date(this.log['updated_at'])).toLocaleString().slice(0, -3)
    },
    created_at() {
      return (new Date(this.log['created_at'])).toLocaleString().slice(0, -3)
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