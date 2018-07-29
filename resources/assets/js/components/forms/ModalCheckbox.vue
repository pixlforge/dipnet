<template>
  <div class="modal__group">
    <label
      :for="id"
      class="modal__label">
      <input
        :id="id"
        :name="name"
        :checked="value"
        type="checkbox"
        @input="$emit('input', $event.target.checked)">
      <slot name="label"/>
    </label>
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
      type: [Boolean, String],
      required: true
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
    }
  }
};
</script>

