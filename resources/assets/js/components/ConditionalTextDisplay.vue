<template>
  <template v-if="condition">
    {{ successText }}
  </template>
  <template v-else>
    <!--Send failureText as prop, or empty string if failureText is empty.-->
    <template v-if="showFailureTextAsPlainText">
      {{ failureText }}
    </template>
    <template v-else>
      <MissingDataItem :item="failureText || ''" />
    </template>
  </template>
</template>
<script setup lang="ts">
import { defineProps } from 'vue';
import MissingDataItem from 'Components/MissingDataItem.vue';

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps({
  condition: {
    type: Object as () => unknown,
    required: true,
  },
  successText: {
    type: [String, Number],
    required: true,
  },
  // eslint-disable-next-line vue/require-default-prop
  failureText: {
    type: String,
    required: false,
  },
  showFailureTextAsPlainText: {
    type: Boolean,
    required: false,
  },
});
</script>
