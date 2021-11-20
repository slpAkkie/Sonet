<template>
  <aside class="sidebar">
    <div class="sidebar__header">
      <h4 class="sidebar__title">Папки</h4>
      <Button value="Новая папка" @click="openNewFolder" />
    </div>
    <hr class="sidebar__separator">
    <div class="sidebar__list">
      <FolderRow title="Мои заметки" :withControls="false" @folder:select="selectAll" />
      <FolderRow title="Без папки" :withControls="false" @folder:select="selectWithoutFolder" />
      <FolderRow title="Доступные мне" :withControls="false" @folder:select="selectShared" />
    </div>
    <hr class="sidebar__separator sidebar__separator_inactive">
    <Preloader :play="isLoading" />
    <template v-if="!isLoading">
      <div v-if="isFolders" class="sidebar__list">
        <FolderRow
            v-for="folder in folders"
            :key="folder.id"
            :id="folder.id"
            :title="folder.title"
            @folder:select="selectFolder"
            @folder:del="delFolder"
        />
      </div>
      <p v-else class="text_center">Собственных папок нет</p>
    </template>
  </aside>

  <FolderPopup
      v-if="openedPopup"
      @popup:close="closePopup"
      :folderData="{}"
  />
</template>

<script>
import Button from '../elements/Button'
import FolderRow from './FolderRow'
import FolderPopup from '../pages/MainView/FolderPopup'
import Preloader from './Preloader'

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
    isLoading() {
      return this.folderDeleting || !this.foldersLoaded
    },
    foldersLoaded() {
      return this.$store.getters.foldersLoaded
    },
    folders() {
      return this.$store.getters.folders
    },
    isFolders() {
      return !!this.$store.getters.folders.length
    },
  },
  methods: {
    openNewFolder() {
      this.openedPopup = true
    },
    closePopup() {
      this.openedPopup = false
    },
    selectAll() {
      this.openFolder()
    },
    selectShared() {
      this.openFolder(-2)
    },
    selectWithoutFolder() {
      this.openFolder(-1)
    },
    selectFolder(id) {
      this.openFolder(id)
    },
    openFolder(folderId = null, path = '/') {
      this.$store.commit('folderQuery', folderId)

      let routerLocationRaw = { path: path }
      if (folderId) routerLocationRaw.query = { folder: folderId }

      this.$router.push(routerLocationRaw)
    },
    delFolder(id) {
      this.folderDeleting = true

      this.$store
        .dispatch('deleteFolder', id)
        .then(() => this.handleResponse(id))
        .catch(this.handleError)
        .finally(() => this.folderDeleting = false)
    },
    handleResponse(id) {
      if (+this.$route.query.folder === id) this.selectAll()
    },
    handleError() {
      //
    },
  },
  beforeCreate() {
    this.$store.dispatch('loadFolders')
  }
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
