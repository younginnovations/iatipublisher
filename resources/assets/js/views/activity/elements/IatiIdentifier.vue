<template>
  <div class="identifier-content">
    <div v-if="data" class="text-sm">
      <span class="whitespace-pre">
        {{ data }}
      </span>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'IatiIdentifier',
  props: {
    data: {
      type: String,
      required: true,
    },
  },
  setup() {
    return {};
  },
});
</script>
