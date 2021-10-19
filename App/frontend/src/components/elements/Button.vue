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
  --border-color: var(--gray-30);
  --background: var(--gray-10);
  --text-color: var(--gray-90);
  //
  padding: .5rem 1.5rem;
  //
  color: var(--text-color);
  font-weight: bold;
  //
  background-color: var(--background);
  border: .1rem solid var(--border-color);
  border-radius: .4rem;
  //
  cursor: pointer;
  transition-property: background-color, color;
  transition-duration: .1s;
  transition-timing-function: ease;
  
  &:hover {
    --background: var(--gray-15);
  }

  &_danger {
    --border-color: var(--red-10);
    --background: var(--red-10);
    --text-color: var(--red-60);

    &:hover {
      --background: var(--red-60);
      --text-color: var(--red-10);
    }
  }
}
</style>
