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
import AccountTab from './settingsTabs/AccountTab'

export default {
  name: 'UserSettings',
  components: {
    MainTab,
    CategoriesTab,
    AccountTab,
  },
  data: () => ({
    tabs: [
      { title: 'Основные', component: 'MainTab' },
      { title: 'Категории', component: 'CategoriesTab' },
      { title: 'Аккаунт', component: 'AccountTab' },
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

    @media screen and (max-width: 749px) {
      justify-content: stretch;
    }
  }
}

.tab {
  --l-background-color: var(--primary_light);
  --l-text-color: var(--primary_dark);
  //
  display: grid;
  place-content: center;
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

  @media screen and (max-width: 749px) {
    flex-grow: 1;
  }

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

  @media screen and (max-width: 749px) {
    padding: 2rem;
  }

  &__row {
    margin-bottom: 1.5rem;
  }

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
    //
    margin-bottom: 2rem;

    @media screen and (max-width: 450px) {
      flex-direction: column;
      align-items: flex-start;
    }
  }
}
</style>