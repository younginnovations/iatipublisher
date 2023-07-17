<template>
  <tr v-for="row in rowCount" :key="row">
    <td v-for="col in colCount" :key="col" class="w-full p-3">
      <ShimmerLoading class="w-full !rounded-sm p-3" />
    </td>
  </tr>
</template>
<script setup lang="ts">
import { defineProps } from 'vue';
import ShimmerLoading from './ShimmerLoading.vue';
defineProps({
  rowCount: { type: Number, required: true },
  colCount: { type: Number, required: false, default: 1 },
});
</script>
