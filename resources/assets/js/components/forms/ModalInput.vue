<template>
  <div class="modal__group">
    <label
      :for="id"
      class="modal__label">
      <slot name="label"/>
    </label>
    <span
      v-if="required"
      class="modal__required"
      v-text="'*'"/>
    <input
      :type="type"
      :id="id"
      :name="name"
      :autofocus="autofocus"
      :required="required"
      :value="value"
      :disabled="disabled"
      :class="{ 'modal__input--disabled': disabled }"
      class="modal__input"
      @input="$emit('input', $event.target.value)">
    <div
      class="modal__alert">
      <slot name="errors"/>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: [String, Number],
      required: false,
      default: null
    },
    id: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: false,
      default() {
        return this.id;
      }
    },
    type: {
      type: String,
      required: false,
      default: "text"
    },
    required: {
      type: Boolean,
      required: false,
      default: false
    },
    autofocus: {
      type: Boolean,
      required: false,
      default: false
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false
    }
  }
};
</script>

