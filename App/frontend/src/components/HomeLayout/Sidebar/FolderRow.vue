<template>
  <div class="folder-row" :class="isWaiting && 'folder-row_disabled'">
    <router-link :to="link" ref="link" class="folder-row__title link_static">{{ data.title }} <span class="folder-row__amount" v-if="data.notes_amount">[{{ data.notes_amount }}]</span></router-link>
    <div v-if="withControls" class="folder-row__controls">
      <Button value="-" appearance="danger" @click="del" />
    </div>
  </div>
</template>

<script>
import Button from '../../controls/Button'

export default {
  name: 'FolderRow',
  components: {
    Button,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
    withControls: {
      type: Boolean,
      default: true,
    },
    linkTo: {
      type: String,
      default: null,
    },
  },
  data: () => ({
    isWaiting: false,
  }),
  computed: {
    link() {
      return this.linkTo || `/home/folder/${this.data.id}`
    },
  },
  methods: {
    del() {
      if (!confirm('Вы уверены что хотите удалить папку')) return

      this.isWaiting = true
      this.$store
        .dispatch('deleteFolder', this.data.id)
        .catch(() => {
          this.isWaiting = false
        })
    },
  },
}
</script>

<style lang="scss">
.folder-row {
  display: flex;
  align-items: center;
  //
  padding: 0 1rem;
  margin: .75rem 0;
  //
  transition-property: background-color, color;
  transition-timing-function: ease;
  transition-duration: .1s;
  cursor: pointer;

  &_disabled {
    opacity: .5;
    pointer-events: none;
  }

  &:hover:not(&_disabled) {
    color: var(--bg-lighter);
    background-color: var(--c-info);
  }

  &__title {
    display: block;
    flex-grow: 1;
    //
    padding: .7rem 0;

    &.link_exact-active {
      position: relative;

      &::before {
        content: '';
        //
        position: absolute;
        top: 50%;
        left: -1rem;
        //
        width: .3rem;
        height: 100%;
        //
        background-color: var(--c-info);
        //
        transform: translateY(-50%);
      }
    }
  }

  &__amount {
    color: var(--primary_muted);
  }
}
</style>