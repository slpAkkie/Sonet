<template>
  <slot></slot>
</template>

<script>
export default {
  name: 'NoteViewLayout',
}
</script>

<style lang="scss">
.note-editor {
  &__title {
    margin-bottom: 1.5rem;
    padding: 1rem 2rem;
    //
    font-size: 2.5rem;
    font-weight: bold;
  }

  &__body {
    min-height: 25rem;
    //
    resize: vertical;
  }

  &__row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
    //
    margin-bottom: 1.5rem;

    &_end {
      justify-content: flex-end;
    }

    &_breakable {
      @media screen and (max-width: 749px) {
        flex-wrap: wrap;
      }
    }
  }

  &__controls {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 1.5rem;
    //
    margin-bottom: 1.5rem;

    @media screen and (max-width: 749px) {
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;

      &>* {
        flex-grow: 1;
        width: 100%;
      }
    }
  }

  &__col {
    flex-grow: 1;

    &_shrink {
      flex-grow: unset;
    }

    &-title {
      margin-bottom: .5rem;
    }
  }
}
</style>