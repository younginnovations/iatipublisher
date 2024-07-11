<template>
  <div :class="className">
    <svg-vue :icon="iconName" :class="iconClass" />
    <!-- eslint-disable vue/no-v-html -->
    <span
      v-if="typeof message === 'string'"
      class="whitespace-nowrap"
      v-html="message"
    ></span>
    <div v-if="typeof message === 'object'">
      <!-- eslint-disable vue/no-v-html -->
      <p v-for="(m, k) in message" :key="k" v-html="m"></p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref, watch } from 'vue';

const props = defineProps({
  message: { type: String, required: true },
  type: { type: [Boolean, String], required: true },
});

const className = ref('');
const iconName = ref('');
const iconClass = ref('');

const updateUI = () => {
  if (typeof props.type === 'string' && props.type === 'warning') {
    iconName.value = 'exclamation-warning';
    className.value =
      'rounded-lg bg-eggshell border border-camel-40 py-3 px-5 inline-flex items-center space-x-1 text-sm leading-normal text-n-50';
    iconClass.value = 'h-5';
  } else if (props.type) {
    className.value =
      'rounded-lg bg-mint border border-spring-50 py-3 px-5 inline-flex items-center space-x-1 text-sm leading-normal text-n-50';
    iconName.value = 'check-circle';
  } else {
    iconName.value = 'times-circle';
    className.value =
      'rounded-lg bg-crimson-10 border border-crimson-20 py-3 px-5 inline-flex items-center space-x-1 text-sm leading-normal text-n-50';
  }
};

// Initial call to updateUI
updateUI();

// Watch for changes in props.type
watch(() => props.type, updateUI);
</script>
