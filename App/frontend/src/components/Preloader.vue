<template>
  <div class="preloader" :class="preloaderClasses">
    <div class="preloader__overlay"></div>
    <div class="preloader__inner">
      <div class="preloader__dot top left"></div>
      <div class="preloader__dot top right"></div>
      <div class="preloader__dot bottom left"></div>
      <div class="preloader__dot bottom right"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Preloader',
  props: {
    fullScreen: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    preloaderClasses() {
      return {
        'preloader_full-screen': this.fullScreen,
      }
    },
  },
}
</script>

<style lang="scss">
.preloader {
  --l-dot-color: var(--primary_dark);
  --l-dot-size: 25px;
  --l-dot-gap: 15px;
  --l-preloader-size: calc(var(--l-dot-size) * 2 + var(--l-dot-gap) * 2);
  //
  position: relative;
  //
  min-width: 14rem;
  min-height: 14rem;

  &_full-screen {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    //
    z-index: 100;
  }

  &_full-screen > &__overlay {
    background-color: var(--bg-lighter);
  }

  &__overlay {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    //
    background-color: transparent;
  }

  &__inner {
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
    width: var(--l-preloader-size);
    height: var(--l-preloader-size);
    //
    transform: translate(-50%, -50%);
  }

  &__dot {
    width: var(--l-dot-size);
    height: var(--l-dot-size);
    //
    border-radius: var(--l-dot-size);

    &.top { top: 0 }

    &.bottom { bottom: 0 }

    &.right { right: 0 }

    &.left { left: 0 }

    &.top.left {
      animation: top-left 2s ease-in-out infinite;
      //
      background-color: var(--l-dot-color);
    }

    &.top.right {
      animation: top-right 2s ease-in-out infinite;
      //
      background-color: var(--l-dot-color);
    }

    &.bottom.right {
      animation: bottom-right 2s ease-in-out infinite;
      //
      background-color: var(--l-dot-color);
    }

    &.bottom.left {
      animation: bottom-left 2s ease-in-out infinite;
      //
      background-color: var(--l-dot-color);
    }
  }
}

@keyframes top-left {
  0% { transform: translate(0, 0) }

  25% { transform: translate(calc(100% + var(--l-dot-gap)), 0) }

  50% { transform: translate(calc(100% + var(--l-dot-gap)), calc(100% + var(--l-dot-gap))) }

  75% { transform: translate(0, calc(100% + var(--l-dot-gap))) }

  100% { transform: translate(0, 0) }
}

@keyframes top-right {
  0% { transform: translate(0, 0) }

  25% { transform: translate(0, calc(100% + var(--l-dot-gap))) }

  50% { transform: translate(calc(-100% - var(--l-dot-gap)), calc(100% + var(--l-dot-gap))) }

  75% { transform: translate(calc(-100% - var(--l-dot-gap)), 0) }

  100% { transform: translate(0, 0) }
}

@keyframes bottom-right {
  0% { transform: translate(0, 0) }

  25% { transform: translate(calc(-100% - var(--l-dot-gap)), 0) }

  50% { transform: translate(calc(-100% - var(--l-dot-gap)), calc(-100% - var(--l-dot-gap))) }

  75% { transform: translate(0, calc(-100% - var(--l-dot-gap))) }

  100% { transform: translate(0, 0) }
}

@keyframes bottom-left {
  0% { transform: translate(0, 0) }

  25% { transform: translate(0, calc(-100% - var(--l-dot-gap))) }

  50% { transform: translate(calc(100% + var(--l-dot-gap)), calc(-100% - var(--l-dot-gap))) }

  75% { transform: translate(calc(100% + var(--l-dot-gap)), 0) }

  100% { transform: translate(0, 0) }
}
</style>
