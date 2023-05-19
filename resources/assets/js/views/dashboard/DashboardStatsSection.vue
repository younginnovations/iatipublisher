<template>
  <section class="flex space-x-6">
    <div class="min-w-[390px] rounded bg-white p-4">
      <div v-if="currentView !== 'users'">
        <div class="border-b border-n-20 pb-4">
          <div class="flex items-center justify-between">
            <span
              v-if="currentView === 'publisher'"
              class="text-xs uppercase text-n-40"
              >Total No. of Publisher Registration in IATI</span
            >
            <span v-else class="text-xs uppercase text-n-40"
              >Total No. of Activities in IATI</span
            >

            <svg-vue icon="question-mark" class="text-base text-n-40" />
          </div>
          <div class="my-1 text-2xl text-bluecoral">
            <!-- total count -->
            2545
          </div>
        </div>
        <div class="border-b border-n-20 py-4">
          <div class="flex items-center justify-between">
            <span
              v-if="currentView === 'publisher'"
              class="text-xs uppercase text-n-40"
              >Last registered publisher</span
            >
            <span v-else class="text-xs uppercase text-n-40">
              Last Publisher with Activity Update
            </span>

            <svg-vue icon="question-mark" class="text-base text-n-40" />
          </div>
          <div class="mb-1 mt-2 text-2xl text-bluecoral">
            <!-- latest registered -->
            Heart of One
          </div>
          <div class="my-1 text-xs italic text-n-40">
            <!-- latest registered date -->
            Registered Date:Mar 2, 2023
          </div>
        </div>
        <div class="border-b border-n-20 py-4">
          <div class="flex items-center justify-between space-x-5">
            <span
              v-if="currentView === 'publisher'"
              class="text-xs uppercase text-n-40"
              >No. of Publishers Inactive (not logged in) since 6 Months in
              IATI</span
            >
            <span v-else class="text-xs uppercase text-n-40">
              Total No. of Publishers with No Activity in IATI
            </span>
            <div>
              <svg-vue icon="question-mark" class="text-base text-n-40" />
            </div>
          </div>
          <div class="my-1 text-2xl text-bluecoral">
            <!-- total count -->
            128
          </div>
        </div>
      </div>
      <div v-else>
        <div class="mb-2 flex items-center space-x-2.5">
          <span class="text-sm text-bluecoral"
            >Different users in IATI Publishers</span
          >
          <svg-vue icon="question-mark" class="text-base text-n-40" />
        </div>
        <table class="w-full">
          <thead>
            <tr class="bg-n-10">
              <td class="py-3 px-6 text-xs font-bold uppercase text-n-40">
                users
              </td>
              <td class="py-3 px-6 text-xs font-bold uppercase text-n-40">
                total
              </td>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b border-n-20">
              <td class="px-6 py-2.5 text-sm text-bluecoral">Super Admin</td>
              <td class="px-6 py-2.5 text-sm text-n-50">22</td>
            </tr>
            <tr class="border-b border-n-20">
              <td class="px-6 py-2.5 text-sm text-bluecoral">IATI Admin</td>
              <td class="px-6 py-2.5 text-sm text-n-50">22</td>
            </tr>
            <tr class="border-b border-n-20">
              <td class="px-6 py-2.5 text-sm text-bluecoral">
                Organisation Admin
              </td>
              <td class="px-6 py-2.5 text-sm text-n-50">22</td>
            </tr>
            <tr class="border-b border-n-20">
              <td class="px-6 py-2.5 text-sm text-bluecoral">General Users</td>
              <td class="px-6 py-2.5 text-sm text-n-50">22</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="mt-10 text-xs italic text-n-40">
        This widget is not affected by the date range
      </p>
    </div>
    <div class="flex w-full flex-col justify-between rounded bg-white p-4">
      <div>
        <div class="flex space-x-2.5 px-2 text-xs uppercase text-n-40">
          <p>Total No. of Publisher Registration</p>
          <svg-vue icon="question-mark" class="text-base text-n-40" />
        </div>
        <div class="my-1 px-2 text-3xl text-bluecoral">1701</div>
      </div>
      <DashboardGraph />
    </div>
  </section>
</template>
<script lang="ts" setup>
import { ref, defineProps } from 'vue';
import DashboardGraph from './DashboardGraph.vue';

const props = defineProps({
  currentView: {
    type: String,
    required: true,
  },
});
</script>
<style></style>
