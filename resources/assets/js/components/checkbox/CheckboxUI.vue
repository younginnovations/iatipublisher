<template>
  <label class="checkbox_container">
    <span v-if="props.label"> {{ label }}</span>
    <input type="checkbox" checked />
    <span class="checkmark"></span>
  </label>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps({
  label: {
    type: String,
    default: '',
  },
});
</script>

<style scoped lang="scss">
.checkbox_container {
  display: block;
  position: relative;
  padding-left: 10px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.checkbox_container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 3px;
  left: 0;
  height: 17px;
  width: 17px;
  border-radius: 2px;
  @apply border-2 border-n-20;
}

/* On mouse-over, add a grey background color */
.checkbox_container:hover input ~ .checkmark {
  @apply border-spring-50;
}

/* When the checkbox is checked, add a blue background */
.checkbox_container input:checked ~ .checkmark {
  @apply border-spring-50 bg-spring-50;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: '';
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.checkbox_container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.checkbox_container .checkmark:after {
  left: 4px;
  top: 1px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
