<template>
  <h2 class="page-title">Настройки [{{ activeTab }}]</h2>
  <div class="tabs">
    <div class="tabs__header">
      <div class="tab" v-for="(tab, i) in tabs" :key="i" @click="activeTab = i" :class="activeTab === i && 'tab_active'">{{ tab.title }}</div>
    </div>
    <div class="tabs__content">
      <component :is="tabComponent"></component>
    </div>
  </div>
</template>

<script>
import MainTab from './settingsTabs/MainTab'
import CategoriesTab from './settingsTabs/CategoriesTab'
import DangerTab from './settingsTabs/DangerTab'

export default {
  name: 'UserSettings',
  components: {
    MainTab,
    CategoriesTab,
    DangerTab,
  },
  data: () => ({
    tabs: [
      { title: 'Основные', component: 'MainTab' },
      { title: 'Категории', component: 'CategoriesTab' },
      { title: 'Опасная зона', component: 'DangerTab' },
    ],

    activeTab: 0,
  }),
  computed: {
    tabComponent() {
      return this.tabs[this.activeTab].component
    },
  },
}
</script>

<style lang="scss">
.tabs {
  display: flex;
  flex-direction: column;

  &__header {
    display: flex;
    justify-content: flex-start;
  }

  &__content {
    padding: 2rem 5rem;
    border: .1rem solid var(--blue-50);
    border-radius: 0 0 .4rem .4rem;
  }
}

.tab {
  --background-color: var(--blue-10);
  --text-color: var(--blue-50);
  //
  padding: 1rem 2rem;
  //
  color: var(--text-color);
  font-weight: bold;
  //
  background-color: var(--background-color);
  //
  cursor: pointer;
  transition-property: background-color, color;
  transition-duration: .1s;
  transition-timing-function: ease;

  &:first-child {
    border-radius: .4rem 0 0 0;
  }

  &:last-child {
    border-radius: 0 .4rem 0 0;
  }

  &:hover:not(&_active) {
    --background-color: var(--blue-40);
    --text-color: var(--blue-10);
  }

  &_active {
    --background-color: var(--blue-50);
    --text-color: var(--blue-10);
  }
}
</style>