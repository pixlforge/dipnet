<template>
  <div ref="select">
    <div
      :class="{ 'dropdown__label--large': large, 'dropdown__label--darker': darker }"
      role="button"
      class="dropdown__label"
      @click="toggleOpen">
      <span><slot/></span>
      <i class="fas fa-caret-down"/>
    </div>
    <div
      v-if="open"
      class="dropdown__container">

      <!-- Print types list -->
      <ul
        v-if="variant === 'printTypes'"
        class="dropdown__list">
        <li class="dropdown__section-title">
          <div>Noir &amp; blanc</div>
          <div>
            <img
              src="/img/icons/black-white.png"
              alt="Icône noir et blanc">
          </div>
        </li>
        <li
          v-for="option in options"
          v-if="option.greyscale"
          :key="option.value"
          @click="selectOption(option)"
          v-text="option.label"/>
        <li class="dropdown__section-title">
          <div>
            Couleur
          </div>
          <div>
            <img
              src="/img/icons/colors.png"
              alt="Icône couleur">
          </div>
        </li>
        <li
          v-for="option in options"
          v-if="!option.greyscale"
          :key="option.value"
          @click="selectOption(option)">
          {{ option.label | capitalize }}
        </li>
      </ul>

      <!-- Standard list -->
      <ul
        v-if="!variant"
        class="dropdown__list">
        <li
          v-for="option in options"
          :key="option.value"
          @click="selectOption(option)">
          {{ option.label | capitalize }}
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
    options: {
      type: Array,
      required: true
    },
    large: {
      type: Boolean,
      required: false,
      default: false
    },
    darker: {
      type: Boolean,
      required: false,
      default: false
    },
    variant: {
      type: String,
      required: false,
      default: ""
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
      let element = this.$refs.select;
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
    selectOption(option) {
      this.$emit("input", option);
      this.open = false;
    }
  }
};
</script>

