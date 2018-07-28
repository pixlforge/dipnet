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