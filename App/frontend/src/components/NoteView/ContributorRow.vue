<template>
  <div class="contributor-row">
    <div class="contributor-row__group contributor-row__group_contributor-info">
      <div class="contributor-row__data-cell contributor-row__data-cell_grow contributor-row__email">{{ contributor['user']['email'] }}</div>
      <div class="contributor-row__data-cell contributor-row__data-cell_grow contributor-row__full-name">{{ contributor['user']['full_name'] }}</div>
    </div>
    <div class="contributor-row__group contributor-row__group_access-info">
      <div class="contributor-row__data-cell contributor-row__access-level">{{ contributor['access_level'] }}</div>
      <div class="contributor-row__data-cell contributor-row__controls">
        <Button value="Удалить" appearance="danger" @click="del" />
      </div>
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
  background-color: var(--primary);

  @media screen and (max-width: 949px) {
    gap: 0;
  }

  &__group {
    flex-grow: 1;
    display: flex;
    justify-content: space-between;
    gap: .2rem;

    @media screen and (max-width: 949px) {
      gap: 0;
    }

    &_contributor-info {
      @media screen and (max-width: 949px) {
        flex-direction: column;
      }
    }

    &_access-info {
      @media screen and (max-width: 949px) {
        display: flex;
        justify-content: space-between;
      }
    }
  }

  &__data-cell {
    display: flex;
    align-items: center;
    //
    padding: 1.5rem 1.5rem;
    //
    background-color: var(--bg-lighter);

    @media screen and (max-width: 949px) {
      flex-grow: 1;
    }

    &_grow {
      flex-grow: 1;
    }
  }

  &__email {
    @media screen and (max-width: 949px) {
      font-weight: bold;
      font-size: 1.8rem;
      //
      padding-bottom: .5rem;
    }
  }

  &__full-name {
    @media screen and (max-width: 949px) {
      padding-top: 0;
      //
      font-size: 1.4rem;
    }
  }

  &__access-level {
    flex-grow: 1;
  }

  &__controls {
    justify-content: center;
    //
    width: 11.5rem;

    @media screen and (max-width: 949px) {
      width: unset;
    }
  }

  &__access-level {
    color: var(--primary_dark);
    //
    background-color: var(--primary_light);
  }
}
</style>