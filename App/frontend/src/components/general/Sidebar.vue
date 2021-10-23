<template>
  <aside class="sidebar">
    <div class="sidebar__header">
      <h4 class="sidebar__title">Папки</h4>
      <Button value="Новая папка" />
    </div>
    <hr class="sidebar__separator">
    <div class="sidebar__list">
      <FolderRow title="Все заметки" :withControls="false" />
      <FolderRow title="Без категории" :withControls="false" />
      <FolderRow title="Доступные мне" :withControls="false" />
    </div>
    <hr class="sidebar__separator sidebar__separator_inactive">
    <div class="sidebar__list">
      <p class="text_center">Собственных папок нет</p>
    </div>
  </aside>
</template>

<script>
import Button from '../elements/Button'
import FolderRow from "./FolderRow";

export default {
  name: 'Sidebar',
  components: {
    Button,
    FolderRow,
  },
}
</script>

<style lang="scss">
.sidebar {
  position: sticky;
  top: 3rem;
  //
  padding: 1.5rem;
  //
  background-color: var(--white);
  border-radius: .4rem;

  &__header {
    display: flex;
    align-items: center;
  }

  &__title {
    flex-grow: 1;
  }

  &__separator {
    height: .2rem;
    margin: 1rem auto;
    //
    background-color: var(--blue-50);

    &_inactive {
      background-color: var(--gray-30);
    }
  }
}
</style>
