<template>

  <div class="preloader">
    <slot></slot>
    <div v-if="play" class="preloader__overlay"></div>
    <div v-if="play" class="preloader__inner">
      <div class="preloader__dot top left"></div>
      <div class="preloader__dot top right"></div>
      <div class="preloader__dot bottom left"></div>
      <div class="preloader__dot bottom right"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Preloader",
  props: {
    play: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style lang="scss">
.preloader {
  --dot-color: var(--blue-50);

  position: relative;

  &__overlay {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    //
    background-color: rgba(255, 255, 255, .75);
  }

  &__inner {
    --dot-size: 25px;
    --dot-gap: 15px;
    --preloader-size: calc(var(--dot-size) * 2 + var(--dot-gap) * 2);
    //
    position: absolute;
    top: 50%;
    left: 50%;
    //
    display: grid;
    grid-template-areas:
                      'a b'
                      'd c';
    grid-template-columns: 50% 50%;
    grid-template-rows: 50% 50%;
    place-items: center;
    //
    width: var(--preloader-size);
    height: var(--preloader-size);
    //
    transform: translate(-50%, -50%);
  }

  &__dot {
    width: var(--dot-size);
    height: var(--dot-size);
    //
    border-radius: var(--dot-size);

    &.top { top: 0 }

    &.bottom { bottom: 0 }

    &.right { right: 0 }

    &.left { left: 0 }

    &.top.left {
      animation: top-left 2s ease-in-out infinite;
      //
      background-color: var(--dot-color);
    }

    &.top.right {
      animation: top-right 2s ease-in-out infinite;
      //
      background-color: var(--dot-color);
    }

    &.bottom.right {
      animation: bottom-right 2s ease-in-out infinite;
      //
      background-color: var(--dot-color);
    }

    &.bottom.left {
      animation: bottom-left 2s ease-in-out infinite;
      //
      background-color: var(--dot-color);
    }
  }
}

@keyframes top-left {
  0% { transform: translate(0, 0) }

  25% { transform: translate(calc(100% + var(--dot-gap)), 0) }

  50% { transform: translate(calc(100% + var(--dot-gap)), calc(100% + var(--dot-gap))) }

  75% { transform: translate(0, calc(100% + var(--dot-gap))) }

  100% { transform: translate(0, 0) }
}

@keyframes top-right {
  0% { transform: translate(0, 0) }

  25% { transform: translate(0, calc(100% + var(--dot-gap))) }

  50% { transform: translate(calc(-100% - var(--dot-gap)), calc(100% + var(--dot-gap))) }

  75% { transform: translate(calc(-100% - var(--dot-gap)), 0) }

  100% { transform: translate(0, 0) }
}

@keyframes bottom-right {
  0% { transform: translate(0, 0) }

  25% { transform: translate(calc(-100% - var(--dot-gap)), 0) }

  50% { transform: translate(calc(-100% - var(--dot-gap)), calc(-100% - var(--dot-gap))) }

  75% { transform: translate(0, calc(-100% - var(--dot-gap))) }

  100% { transform: translate(0, 0) }
}

@keyframes bottom-left {
  0% { transform: translate(0, 0) }

  25% { transform: translate(0, calc(-100% - var(--dot-gap))) }

  50% { transform: translate(calc(100% + var(--dot-gap)), calc(-100% - var(--dot-gap))) }

  75% { transform: translate(calc(100% + var(--dot-gap)), 0) }

  100% { transform: translate(0, 0) }
}
</style>