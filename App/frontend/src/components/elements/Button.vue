<template>
  <input class="c-button" :type="type" :value="value">
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
      type: String
    },
  },
}
</script>

<style lang="scss">
.c-button {
  padding: .5rem 1.5rem;
  //
  font-weight: bold;
  //
  border: .1rem solid #dadada;
  border-radius: .4rem;
  //
  cursor: pointer;
  transition: background-color .1s ease;
  
  &:hover {
    background-color: #cecece;
  }
}
</style>
