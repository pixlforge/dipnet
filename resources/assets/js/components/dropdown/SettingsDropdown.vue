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
import { filters } from "../../mixins";

export default {
  mixins: [filters],
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
    const escapeHandler = event => {
      if (event.key === "Escape" && this.open) {
        this.open = false;
      }
    };
    document.addEventListener("keydown", escapeHandler);

    const clickHandler = event => {
      let element = this.$refs.dropdownMenu;
      let target = event.target;
      if (element !== target && !element.contains(target)) {
        this.open = false;
      }
    };
    document.addEventListener("click", clickHandler);

    this.$once("hook:destroyed", () => {
      document.removeEventListener("keydown", escapeHandler);
      document.removeEventListener("click", clickHandler);
    });
  },
  methods: {
    toggleOpen() {
      this.open = !this.open;
    },
    selectItem(item) {
      this.$emit("item:selected", item);
      this.toggleOpen();
    }
  }
};
</script>