<template>
  <div ref="dropdownMenu">
    <div class="dropdown__label"
         role="button"
         @click="toggleOpen">
      <span><strong>{{ label | capitalize }}</strong></span>
      <i class="fas fa-caret-down"></i>
    </div>
    <div class="dropdown__container" v-if="open">
      <ul class="dropdown__list dropdown__list--justified">
        <li v-for="(item, index) in listItems"
            @click="selectItem(item)">
          <div>
            {{ item.name | capitalize }}
          </div>
          <div>
            {{ item.width }} x {{ item.height }}
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { eventBus } from '../../app'

  export default {
    props: {
      label: {
        type: String,
        required: true
      },
      listItems: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        open: false
      }
    },
    mixins: [mixins],
    methods: {
      /**
       * Toggle the open state of the dropdown list.
       */
      toggleOpen() {
        this.open = !this.open
      },
      /**
       * Retrieve the reference of the active dropdown and close
       * it if another element is clicked.
       */
      documentClick(event) {
        let el = this.$refs.dropdownMenu
        let target = event.target
        if ((el !== target) && !el.contains(target)) {
          this.open = false
        }
      },
      /**
       * Select an item from the list.
       */
      selectItem(item) {
        this.$emit('itemSelected', item)
        this.toggleOpen()
      },
    },
    created() {
      document.addEventListener('click', this.documentClick)
    },
    destroyed() {
      document.removeEventListener('click', this.documentClick)
    }
  }
</script>