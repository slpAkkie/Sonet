<template>
  <input class="c-button" :class="`c-button_${appearance}`" :type="type" :value="value">
</template>

<script>
export default {
  name: "Button",
  props: {
    type: {
      type: String,
      default: 'button',
    },
    value: {
      type: String,
      required: true,
    },
    appearance: {
      type: String,
      default: 'default',
    },
  },
}
</script>

<style lang="scss">
.c-button {
  --l-border-color: var(--c-info_inactive);
  --l-background: var(--c-info_inactive);
  --l-text-color: var(--c-info);
  //
  padding: .5rem 1.5rem;
  //
  color: var(--l-text-color);
  font-weight: bold;
  //
  background-color: var(--l-background);
  border: .1rem solid var(--l-border-color);
  border-radius: .4rem;
  //
  cursor: pointer;
  transition-property: background-color, border-color, color;
  transition-duration: .1s;
  transition-timing-function: ease;
  
  &:hover {
    --l-background: var(--c-info);
    --l-text-color: var(--c-info_inactive);
  }

  &_danger {
    --l-border-color: var(--c-danger_inactive);
    --l-background: var(--c-danger_inactive);
    --l-text-color: var(--c-danger);

    &:hover {
      --l-border-color: var(--c-danger);
      --l-background: var(--c-danger);
      --l-text-color: var(--c-danger_inactive);
    }
  }
}
</style>
