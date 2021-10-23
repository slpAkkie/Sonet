<template>
  <textarea class="c-textarea" :type="type" :name="name" :id="id || name" :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"></textarea>
</template>

<script>
export default {
  name: 'Textarea',
  props: {
    type: String,
    placeholder: String,
    name: String,
    id: String,
    modelValue: String,
  },
}
</script>

<style lang="scss">
.c-textarea {
  max-width: 100%;
  width: 100%;
  padding: .5rem 1.5rem;
  //
  border: .1rem solid #dadada;
  border-radius: .4rem;
}
</style>