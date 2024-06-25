<template>
  <div>
    <RollingLoader header="Publishing Activities" />
    <p
      class="mt-2.5 rounded-lg bg-paper p-4 text-sm leading-[22px] tracking-normal text-n-50"
    >
      This process may take some time. You can minimize this tab and continue
      working on other tasks.
    </p>
  </div>
  <div class="mt-6 rounded-lg border border-n-20">
    <div
      class="rounded-t-lg bg-n-10 px-6 py-4 font-bold leading-[18px] tracking-normal text-n-50"
    >
      Activity
    </div>
    <ul
      class="space-y-4 divide-y divide-n-20 px-6 pb-4 text-sm leading-[22px] tracking-normal text-n-50"
    >
      <li class="pt-4">EU-Angola Dialogue Facility</li>
      <li class="pt-4">
        UNFPA Angola Improved national population data systems to map and
        address inequalities; to advance the achievement of the Sustainable
        Development Goals and the commitments of the Programme of Action of the
        International Conference on Population and Development; and to
        strengthen interventions in humanitarian crises activities
      </li>
      <li class="pt-4">
        Support Program on Public Finance Management and Financial Sector reform
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import RollingLoader from '../RollingLoaderComponent.vue';
</script>

<style scoped></style>
