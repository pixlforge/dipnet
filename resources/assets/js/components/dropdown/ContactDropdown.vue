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
export default {
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