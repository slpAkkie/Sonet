<template>
  <div class="tab-content__group">
    <div class="tab-content__header">
      <h6>Входы в аккаунт</h6>
    </div>
    <div class="tab-content__row">
      <p>Здесь вы видите список устройств, с которых был выполнен вход в ваш аккаунт</p>
    </div>
    <div class="tab-content__row">
      <p v-if="logs === null">Загрузка...</p>
      <ul v-else class="account-tab__log-list">
        <AuthLogRow v-for="(log, index) in logs" :key="log.id" :log="log" :index="index" @deactivated="removeLog" />
      </ul>
    </div>
  </div>

  <div class="tab-content__group">
    <div class="tab-content__header">
      <h6>Удалить аккаунт</h6>
    </div>
    <div class="tab-content__row">
      <p><span class="text_danger">Внимание!</span> Если вы удалите свой аккаунт, его восстановление будет не возможно. Будут удалены все ваши категории, папки, заметки. Заметки так же пропадут у тех, кому вы открыли доступ.</p>
    </div>
    <div v-if="isWaiting" class="tab-content__row">
      <Preloader />
    </div>
    <div v-else class="tab-content__row">
      <Button value="Удалить" appearance="danger" @click="del" />
    </div>
  </div>
</template>

<script>
import Button from '../../components/controls/Button'
import Preloader from '../../components/Preloader'
import AuthLogRow from '../../components/UserSettings/AuthLogRow'


export default {
  name: 'AccountSettingsTab',
  components: {
    Button,
    Preloader,
    AuthLogRow,
  },
  data: () => ({
    isWaiting: false,
    logs: null,
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
    async loadAuthLogs() {
      this.logs = (await this.axios.get('/user/auth-logs')).data.data
    },
    removeLog(index) {
      this.logs.splice(index, 1)
    },
  },
  mounted() {
    this.loadAuthLogs()
  }
}
</script>

<style lang="scss">
.account-tab {
  &__log-row {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 1.5rem;
    //
    margin-bottom: 1rem;

    &_disabled {
      opacity: .5;
      //
      pointer-events: none;
    }
  }

  &__os-log {
    word-break: break-all;
  }

  &__date-log {
    font-size: 1.2rem;
    color: var(--primary_muted);
  }

  &__deactivate {
    margin-left: auto;
  }

  &__current-session {
    margin: 1rem 0 1rem auto;
    //
    color: var(--primary);
    font-size: 1.4rem;
  }

  &__reports {
    &-list {
      margin-bottom: 2rem;
    }

    &-item {
      margin-bottom: 1rem;
    }
  }
}
</style>
