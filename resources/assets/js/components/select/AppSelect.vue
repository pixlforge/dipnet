<template>
  <div ref="select">
    <div
      :class="{ 'dropdown__label--large': large, 'dropdown__label--darker': darker, 'dropdown__label--disabled': disabled }"
      role="button"
      class="dropdown__label"
      @click="toggleOpen">
      <span><slot/></span>
      <span v-if="!disabled">
        <i class="fas fa-caret-down"/>
      </span>
    </div>
    <div
      v-if="open && !disabled"
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

      <!-- Formats -->
      <ul
        v-if="formats"
        class="dropdown__list">
        <li
          v-for="option in options"
          :key="option.label"
          @click.prevent="selectOption(option)">
          {{ `${option.label} (${option.value.width} x ${option.value.height})` }}
        </li>
      </ul>

      <!-- Standard list -->
      <ul
        v-if="!variant && !formats && !disabled"
        class="dropdown__list">
        <template v-if="!userIsSolo">
          <li
            v-for="option in options"
            :key="option.value"
            @click.prevent="selectOption(option)">
            <template v-if="option.value === 'express'">
              <i class="fas fa-bolt fa-sm"/>
            </template>
            {{ option.label | capitalize }}
          </li>
        </template>
        <hr v-if="allowPickup && !userIsSolo">
        <li
          v-if="allowPickup"
          @click.prevent="selectOption({ label: 'récupérer sur place', value: '' })">
          <i class="fas fa-person-carry fa-sm"/>
          Récupérer sur place
        </li>
        <hr v-if="(allowCreateContact || allowCreateBusiness) && !userIsSolo">
        <li
          v-if="allowCreateContact && !userIsSolo"
          @click.prevent="openAddContactPanel">
          <i class="fal fa-plus fa-sm"/>
          Ajouter un contact
        </li>
        <li
          v-if="allowCreateBusiness"
          @click.prevent="openAddBusinessPanel">
          <i class="fal fa-plus fa-sm"/>
          Ajouter une affaire
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { eventBus } from "../../app";
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
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false
    },
    allowPickup: {
      type: Boolean,
      required: false,
      default: false
    },
    allowCreateContact: {
      type: Boolean,
      required: false,
      default: false
    },
    allowCreateBusiness: {
      type: Boolean,
      required: false,
      default: false
    },
    allowExpressDelivery: {
      type: Boolean,
      required: false,
      default: false
    },
    component: {
      type: Object,
      required: false,
      default() {
        return {};
      }
    },
    userIsSolo: {
      type: Boolean,
      required: false,
      default: false
    },
    formats: {
      type: Boolean,
      required: false,
      default: false
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
    },
    openAddContactPanel() {
      eventBus.$emit("add-contact:open", this.component);
      this.open = false;
    },
    openAddBusinessPanel() {
      eventBus.$emit("add-business:open");
      this.open = false;
    }
  }
};
</script>

<style scoped>
li svg {
  transform: translate(-5px, -1px);
}

hr {
  color: #f9f9f9;
  border-style: solid;
}
</style>
