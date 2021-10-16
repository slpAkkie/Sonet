<template>
  <input class="c-input" :type="type" :name="name" :id="id || name" :placeholder="placeholder" @input="$emit('update:modelValue', $event.target.value)">
</template>

<script>
export default {
  name: 'Input',
  props: {
    type: String,
    placeholder: String,
    name: String,
    id: String,
  },
}
</script>

<style lang="scss">
.c-input {
  padding: .5rem 1.5rem;
  //
  border: .1rem solid #dadada;
  border-radius: .4rem;
}
</style>
