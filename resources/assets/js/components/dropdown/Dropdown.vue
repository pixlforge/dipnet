<template>
  <div ref="dropdownMenu">
    <div class="dropdown__label"
         role="button"
         @click="toggleOpen">
      <span><strong>{{ label }}</strong></span>
      <i class="fas fa-caret-down"></i>
    </div>
    <div class="dropdown__container" v-if="open">
      <ul class="dropdown__list">
        <li v-for="(item, index) in listItems"
            @click="selectItem(item)">
          {{ item.name | capitalize }}
        </li>
        <li v-if="addContactComponent"
            @click="addContact">
          Ajouter un contact
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  import mixins from '../../mixins'
  import { eventBus } from '../../app'
  import { mapGetters } from 'vuex'

  export default {
    props: {
      label: {
        type: String,
        required: true
      },
      listItems: {
        type: Array,
        required: true
      },
      addContactComponent: {
        type: Boolean,
        required: false
      }
    },
    data() {
      return {
        open: false
      }
    },
    computed: {
      ...mapGetters([
        'listContacts'
      ])
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
      /**
       * Trigger the AddContact component from a parent component.
       */
      addContact() {
        eventBus.$emit('dropdownAddContact')
        this.open = false
      }
    },
    created() {
      document.addEventListener('click', this.documentClick)
    },
    destroyed() {
      document.removeEventListener('click', this.documentClick)
    }
  }
</script>