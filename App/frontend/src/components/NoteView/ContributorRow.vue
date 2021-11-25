<template>
  <div class="contributor-row">
    <div class="contributor-row__data-cell contributor-row__data-cell_grow contributor-row__email">{{ contributor['user']['email'] }}</div>
    <div class="contributor-row__data-cell contributor-row__data-cell_grow contributor-row__full-name">{{ contributor['user']['full_name'] }}</div>
    <div class="contributor-row__data-cell contributor-row__access-level">{{ contributor['access_level'] }}</div>
    <div class="contributor-row__data-cell contributor-row__controls">
      <Button value="Удалить" appearance="danger" @click="del" />
    </div>
  </div>
</template>

<script>
import Button from '../controls/Button'

export default {
  name: 'ContributorRow',
  components: {
    Button,
  },
  props: {
    contributor: {
      type: Object,
      required: true,
    },
  },
  methods: {
    del() {
      this.$emit('del', this.contributor.user.id)
    },
  },
}
</script>

<style lang="scss">
.contributor-row {
  display: flex;
  justify-content: space-between;
  align-items: stretch;
  gap: .2rem;
  //
  background-color: var(--blue-50);

  &__data-cell {
    display: flex;
    align-items: center;
    //
    padding: 1.5rem 1.5rem;
    //
    background-color: var(--white);

    &_grow {
      flex-grow: 1;
    }
  }

  &__access-level {
    //
    width: 16.5rem;
  }

  &__controls {
    justify-content: center;
    //
    width: 11.5rem;
  }

  &__access-level {
    background-color: var(--blue-10);
  }
}
</style>