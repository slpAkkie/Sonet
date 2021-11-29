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

  &__attachments-wrapper {
    justify-content: flex-start !important;
  }

  &__attachments-list {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 1.5rem;
  }

  &__add-attachment {
    display: grid;
    place-content: center;
    //
    width: 12rem;
    height: 12rem;
    //
    font-size: 7rem;
    line-height: 1em;
    //
    border: .2rem dashed var(--gray-50);
    color: var(--gray-80);
    //
    cursor: pointer;
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