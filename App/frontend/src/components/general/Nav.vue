<template>
  <Button value="Выход" @click="tryLogout" />
</template>

<script>
import Button from "../elements/Button";

export default {
  name: 'Nav',
  emits: [ 'logout' ],
  components: {
    Button
  },
  methods: {
    tryLogout() {
      this.axios.delete('/logout', {
        headers: {
          Authorization: `Bearer ${this.$store.getters.api_token}`
        }
      }).then(() => {
        this.$store.dispatch('removeToken')
        this.$emit('logout')
      }).catch(() => alert('Произошла ошибка'))
    },
  },
}
</script>