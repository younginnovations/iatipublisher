<template>
  <tr v-for="index in 5" :key="index">
    <td class="title"><Shimmer /></td>
    <td><Shimmer /></td>
    <td class="check-column"><Shimmer /></td>
  </tr>
</template>

<script setup lang="ts">
import Shimmer from 'Components/ShimmerLoading.vue';
</script>
