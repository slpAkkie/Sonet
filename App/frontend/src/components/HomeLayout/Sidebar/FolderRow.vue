<template>
  <div class="folder-row">
    <router-link :to="link" class="folder-row__title link_static">{{ title }}</router-link>
    <div v-if="withControls" class="folder-row__controls">
      <Button value="Удалить" appearance="danger" @click="del" />
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
    title: {
      type: String,
      required: true,
    },
    id: {
      type: Number,
      required: false,
      default: null,
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
  computed: {
    link() {
      return this.linkTo || `/home/folder/${this.id}`
    },
  },
  methods: {
    del() {
      this.$store
        .dispatch('deleteFolder', this.id)
        .then(this.handleResponse)
    },
    handleResponse() {
      this.$router.go(0)
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

  &:hover {
    color: var(--white);
    background-color: var(--blue-50);
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
        background-color: var(--blue-50);
        //
        transform: translateY(-50%);
      }
    }
  }
}
</style>