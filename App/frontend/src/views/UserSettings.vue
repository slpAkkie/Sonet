<template>
  <h2 class="page-title">Настройки</h2>
  <div class="tabs">
    <div class="tabs__header">
      <div class="tab" v-for="(tab, i) in tabs" :key="i" @click="activeTab = i" :class="activeTab === i && 'tab_active'">{{ tab.title }}</div>
    </div>
    <div class="tab-content">
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
  mounted() {
    this.$store.dispatch('loadCategories')
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
}

.tab {
  --l-background-color: var(--primary_light);
  --l-text-color: var(--primary_dark);
  //
  display: flex;
  align-items: center;
  //
  padding: 1rem 2rem;
  //
  color: var(--l-text-color);
  font-weight: bold;
  text-align: center;
  //
  background-color: var(--l-background-color);
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

  &:hover, &_active {
    --l-background-color: var(--primary_dark);
    --l-text-color: var(--primary_light);
  }
}

.tab-content {
  padding: 2rem 5rem;
  //
  background-color: var(--bg-lighter);
  border: .1rem solid var(--primary_dark);
  border-radius: 0 0 .4rem .4rem;

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
    //
    margin-bottom: 1rem;

    @media screen and (max-width: 450px) {
      flex-direction: column;
    }
  }
}
</style>