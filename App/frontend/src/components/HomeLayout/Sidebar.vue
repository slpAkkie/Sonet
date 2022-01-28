<template>
  <aside class="sidebar">
    <div class="sidebar__header">
      <h4 class="sidebar__title">Папки</h4>
      <Button value="+" @click="openNewFolder" />
    </div>
    <hr class="sidebar__separator">
    <div class="sidebar__list">
      <FolderRow :data="{ title: 'Мои заметки' }" :withControls="false" linkTo="/home" />
      <FolderRow :data="{ title: 'Без папки' }" :withControls="false" linkTo="/home/without-folder" />
      <FolderRow :data="{ title: 'Доступные мне' }" :withControls="false" linkTo="/home/shared" />
    </div>
    <hr class="sidebar__separator sidebar__separator_inactive">
    <Preloader v-if="isFolderLoading" :show="true" />
    <div v-if="isFolders" class="sidebar__list">
      <FolderRow
          v-for="folder in folders"
          :key="folder.id"
          :data="folder"
      />
    </div>
    <h6 v-if="!isFolderLoading && !isFolders" class="text_center">Собственных папок нет</h6>
  </aside>

  <FolderPopup
      v-if="openedPopup"
      @popup:close="closePopup"
  />
</template>

<script>
import Preloader from '../Preloader'
import Button from '../controls/Button'
import FolderRow from './Sidebar/FolderRow'
import FolderPopup from './Sidebar/FolderPopup'

export default {
  name: 'Sidebar',
  components: {
    Button,
    FolderRow,
    FolderPopup,
    Preloader,
  },
  data: () => ({
    openedPopup: false,
    folderDeleting: false,
  }),
  computed: {
    isFolderLoading() {
      return !this.$store.getters.foldersLoaded
    },
    isFolders() {
      return !!this.$store.getters.folders.length
    },
    folders() {
      return this.$store.getters.folders
    },
  },
  methods: {
    openNewFolder() {
      this.openedPopup = true
    },
    closePopup() {
      this.openedPopup = false
    },
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
  background-color: var(--bg-lighter);
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
    background-color: var(--primary);

    &_inactive {
      background-color: var(--primary_light);
    }
  }
}
</style>
