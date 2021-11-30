<template>
  <div class="tab-content__header">
    <h6>Удалить аккаунт</h6>
  </div>
  <div class="tab-container__row">
    <p><span class="text_highlight">Внимание!</span> Если вы удалите свой аккаунт, его восстановление будет не возможно. Будут удалены все ваши категории, папки, заметки. Заметки так же пропадут у тех, кому вы открыли доступ.</p>
  </div>
  <div v-if="isWaiting" class="tab-container__row">
    <Preloader />
  </div>
  <div v-else class="tab-container__row">
    <Button value="Удалить" appearance="danger" @click="del" />
  </div>
</template>

<script>
import Button from '../../components/controls/Button'
import Preloader from '../../components/Preloader'

export default {
  name: 'DangerSettingsTab',
  components: {
    Button,
    Preloader,
  },
  data: () => ({
    isWaiting: false,
  }),
  methods: {
    del() {
      if (!confirm('Вы уверены что хотите навсегда удалить свой аккаунт?')) return

      this.isWaiting = true

      this.$store
        .dispatch('deleteUser')
        .then(() => {
          this.$router.push('/logout')
        })
        .catch(() => {
          this.isWaiting = false
        })
    },
  },
}
</script>
