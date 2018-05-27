<template>
  <div ref="dropdownMenu">
    <div
      class="dropdown__label"
      role="button"
      @click="toggleOpen">
      <span><strong>{{ label | capitalize }}</strong></span>
      <i class="fas fa-caret-down"/>
    </div>
    <div
      v-if="open"
      class="dropdown__container">
      <ul class="dropdown__list dropdown__list--justified">
        <li
          v-for="item in listItems"
          :key="item"
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
import mixins from "../../mixins";

export default {
  mixins: [mixins],
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