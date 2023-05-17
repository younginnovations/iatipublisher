<template>
  <div class="py-8 px-6">
    <div class="mb-3 outline">
      <div class="flex gap-x-2">
        <button
          class="flex w-[140px] justify-center rounded border border-n-20 py-2"
        >
          <span> Publisher</span>
        </button>
        <button
          class="flex w-[140px] justify-center rounded border border-n-20 py-2"
        >
          <span>Activity</span>
        </button>
        <button
          class="flex w-[140px] justify-center rounded border border-n-20 py-2"
        >
          <span>Users</span>
        </button>
      </div>
    </div>
    <DashboardGraph />
  </div>
</template>

<script setup lang="ts">
import DashboardGraph from './DashboardGraph.vue';
</script>
