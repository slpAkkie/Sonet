<template>
  <div class="auth-form__wrapper">
    <router-view @auth:event="forwardAuthEvent" />
  </div>
</template>

<script>

export default {
  name: 'AuthLayout',
  emits: [ 'auth:event' ],
  methods: {
    forwardAuthEvent(...params) {
      this.$emit('auth:event', ...params)
    },
  },
}
</script>

<style lang="scss">
.auth-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;

  &__wrapper {
    width: 30rem;
    margin: 5rem auto;
  }

  &__error-message {
    margin: 0 0 .5rem 0;
    //
    color: #db3b2a;
    font-size: 1.4rem;
  }
}
</style>
