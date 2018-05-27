<template>
  <div ref="dropdownMenu">
    <div
      class="dropdown__label"
      @click="toggleOpen">
      <span>{{ label | capitalize }}</span>
      <i class="fas fa-caret-down"/>
    </div>
    <div
      v-if="open"
      class="dropdown__container">
      <ul class="dropdown__list">
        <li v-if="items.length <= 0">Aucun contact</li>
        <li
          v-for="business in items"
          :key="business"
          @click="selectItem(business)">
          {{ business.name }}
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
      required: true
    },
    items: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      open: false
    };
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