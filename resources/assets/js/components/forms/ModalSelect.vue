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
    <select
      :id="id"
      :name="name"
      :autofocus="autofocus"
      :required="required"
      :value="value"
      class="modal__select"
      @input="$emit('input', $event.target.value)">
      <option
        value=""
        selected/>
      <option
        v-for="option in options"
        :key="option.value"
        :value="option.value"
        :selected="value == option.value"
        v-text="option.label"/>
    </select>
    <div
      class="modal__alert">
      <slot name="errors"/>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    options: {
      type: Array,
      required: false,
      default() {
        return [];
      }
    },
    value: {
      type: [String, Number],
      required: false,
      default: ""
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
    required: {
      type: Boolean,
      required: false,
      default: false
    },
    autofocus: {
      type: Boolean,
      required: false,
      default: false
    }
  }
};
</script>

