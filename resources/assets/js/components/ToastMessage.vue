<template>
  <div :class="className">
    <svg-vue :icon="props.type ? 'check-circle' : 'times-circle'" />
    <span v-if="typeof message === 'string'">{{ message }}</span>
    <div v-if="typeof message === 'object'">
      <p v-for="(m, k) in message" :key="k">{{ m }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, ref } from 'vue';

const props = defineProps({
  message: { type: String, required: true },
  type: { type: Boolean, required: true },
});

const className = ref('');
className.value = props.type
  ? 'rounded-lg bg-mint border border-spring-10 py-3 px-5 inline-flex items-center space-x-1 text-sm leading-normal text-n-50'
  : 'rounded-lg bg-crimson-10 border border-crimson-20 py-3 px-5 inline-flex items-center space-x-1 text-sm leading-normal text-n-50';
</script>
