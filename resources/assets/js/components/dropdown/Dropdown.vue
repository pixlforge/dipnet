<template>
  <div ref="dropdownMenu">
    <div
      class="dropdown__label"
      role="button"
      @click="toggleOpen">
      <span><strong>{{ label }}</strong></span>
      <i class="fas fa-caret-down"/>
    </div>
    <div
      v-if="open"
      class="dropdown__container">
      <ul class="dropdown__list">
        <li
          v-for="(item, index) in listItems"
          :key="index"
          @click="selectItem(item)">
          {{ item.name | capitalize }}
        </li>
        <li
          v-if="addContactComponent"
          @click="addContact">
          Ajouter un contact
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { eventBus } from "../../app";
import { mapGetters } from "vuex";

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
      required: false,
      default: () => {
        return false;
      }
    }
  },
  data() {
    return {
      open: false
    };
  },
  computed: {
    ...mapGetters(["listContacts"])
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
    },
    addContact() {
      eventBus.$emit("dropdown:add-contact");
      this.open = false;
    }
  }
};
</script>