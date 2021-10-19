<template>
  <div class="container">
    <pre>{{ $store.getters.user }}</pre>
  </div>
</template>

<script>
export default {
  name: 'MainView',
}
</script>