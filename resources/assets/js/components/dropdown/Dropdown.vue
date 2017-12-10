<template>
  <div @click="toggle" class="v-dropdown">
    <slot></slot>
    <div class="v-dropdown-container" v-if="visible">
      <div class="v-dropdown-triangle"></div>
      <ul class="v-dropdown-list">
        <li class="v-dropdown-list-item"
            v-for="(item, index) in data"
            v-text="item.name"
            @click="selectItem(item)">
        </li>
        <li class="v-dropdown-list-item"
            v-if="addContactComponent"
            @click="addContact">
          Ajouter un contact
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  import { eventBus } from '../../app'

  export default {
    props: [
      'data',
      'addContactComponent'
    ],
    data() {
      return {
        visible: false
      }
    },
    methods: {

      /**
       * Toggle the dropdown visibility.
       */
      toggle() {
        this.visible = !this.visible
      },

      /**
       * Select an item from the list and send it to the parent component.
       */
      selectItem(item) {
        this.$emit('itemWasSelected', item)
      },

      /**
       * Trigger the AddContact component from a parent component.
       */
      addContact() {
        eventBus.$emit('dropdownAddContact')
      }
    }
  }
</script>
