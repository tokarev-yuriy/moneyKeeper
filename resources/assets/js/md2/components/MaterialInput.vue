<template>
  <div
    class="input-group"
    :class="`input-group-${variant} ${getStatus(error, success, modelValue)}`"
  >
    <label :class="variant === 'static' ? '' : 'form-label'">{{ label }}</label>
    <input
      :id="id"
      :type="type"
      class="form-control"
      :class="getClasses(size, modelValue)"
      :name="name"
      :value="modelValue"
      :placeholder="placeholder"
      :isRequired="isRequired"
      :disabled="disabled"
      @input="$emit('update:modelValue', $event.target.value)"
    />
  </div>
</template>

<script>
import setMaterialInput from "../assets/js/material-input.js";

export default {
  name: "MaterialInput",
  props: {
    variant: {
      type: String,
      default: "outline",
    },
    label: {
      type: String,
      default: "",
    },
    size: {
      type: String,
      default: "default",
    },
    success: {
      type: Boolean,
      default: false,
    },
    error: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    name: {
      type: String,
      default: "",
    },
    id: {
      type: String,
      required: true,
    },
    modelValue: {
      type: [Number, String],
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    type: {
      type: String,
      default: "text",
    },
    isRequired: {
      type: Boolean,
      default: false,
    },
  },
  mounted() {
    setMaterialInput();
  },
  methods: {
    getClasses: (size, value) => {
      let sizeValue;

      sizeValue = size ? `form-control-${size}` : null;

      let modelValue;

      modelValue = value ? `is-filled` : null;

      return [sizeValue, modelValue].join(' ');
    },
    getStatus: (error, success, value) => {
      let isValidValue;

      if (success) {
        isValidValue = "is-valid";
      } else if (error) {
        isValidValue = "is-invalid";
      } else {
        isValidValue = null;
      }

      let modelValue;

      modelValue = value ? `is-filled` : null;

      return [isValidValue, modelValue].join(' ');;
    },
  },
};
</script>
