<template>
  <div ref="dropdownMenu">
    <div
      class="dropdown__label"
      @click="toggleOpen">
      <span><strong>{{ label }}</strong></span>
      <i class="fas fa-caret-down"/>
    </div>
    <div
      v-if="open"
      class="dropdown__container">
      <ul class="dropdown__list">
        <li
          v-for="contact in listContacts"
          :key="contact.id"
          @click="selectItem(contact)">
          {{ contact.name | capitalize }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import mixins from "../../mixins";

export default {
  mixins: [mixins],
  props: {
    label: {
      type: String,
      required: false,
      default: () => {
        return "";
      }
    },
    companyId: {
      type: Number,
      required: false,
      default: () => {
        return null;
      }
    }
  },
  data() {
    return {
      open: false
    };
  },
  computed: {
    listContacts() {
      return this.$store.getters.listContacts.filter(contact => {
        return contact.company_id == this.companyId;
      });
    }
  },
  created() {
    document.addEventListener("click", this.documentClick);
  },
  destroyed() {
    document.removeEventListener("click", this.documentClick);
  },
  methods: {
    /**
     * Toggle the open state of the dropdown list.
     */
    toggleOpen() {
      this.open = !this.open;
    },
    /**
     * Retrieve the reference of the active dropdown and close
     * it if another element is clicked.
     */
    documentClick(event) {
      let el = this.$refs.dropdownMenu;
      let target = event.target;
      if (el !== target && !el.contains(target)) {
        this.open = false;
      }
    },
    /**
     * Select an item from the list.
     */
    selectItem(item) {
      this.$emit("itemSelected", item);
      this.toggleOpen();
    }
  }
};
</script>