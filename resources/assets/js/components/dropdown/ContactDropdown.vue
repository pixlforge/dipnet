<template>
  <div ref="dropdownMenu">
    <div class="dropdown__label"
         @click="toggleOpen">
      <span><strong>{{ label }}</strong></span>
      <i class="fas fa-caret-down"></i>
    </div>
    <div class="dropdown__container" v-if="open">
      <ul class="dropdown__list">
        <li v-for="(contact, index) in listContacts"
            @click="selectItem(contact)">
          {{ contact.name | capitalize }}
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
        required: false
      },
      companyId: {
        type: Number,
        required: false
      }
    },
    data() {
      return {
        open: false
      }
    },
    computed: {
      listContacts() {
        return this.$store.getters.listContacts.filter(contact => {
          return contact.company_id == this.companyId
        })
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