<template>
  <button
    :type="type"
    :role="role"
    :class="classes"
    :disabled="disabled"
    @click="clicked">
    <slot>Button</slot>
  </button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      required: false,
      default: ""
    },
    role: {
      type: String,
      required: false,
      default: "button"
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false
    },
    primary: {
      type: Boolean,
      required: false,
      default: false
    },
    red: {
      type: Boolean,
      required: false,
      default: false
    },
    orange: {
      type: Boolean,
      required: false,
      default: false
    },
    purple: {
      type: Boolean,
      required: false,
      default: false
    },
    grey: {
      type: Boolean,
      required: false,
      default: false
    },
    long: {
      type: Boolean,
      required: false,
      default: false
    },
    big: {
      type: Boolean,
      required: false,
      default: false
    },
    small: {
      type: Boolean,
      required: false,
      default: false
    },
    iconOnly: {
      type: Boolean,
      required: false,
      default: false
    }
  },
  data() {
    return {
      classes: {
        button__primary: this.primary,
        "button__primary--red": this.red,
        "button__primary--orange": this.orange,
        "button__primary--purple": this.purple,
        "button__primary--grey": this.grey,
        "button__primary--long": this.long,
        "button__primary--big": this.big,
        "button__primary--small": this.small,
        "button__primary--icon-only": this.iconOnly
      }
    };
  },
  methods: {
    clicked(event) {
      this.$emit("click", event);
    }
  }
};
</script>

