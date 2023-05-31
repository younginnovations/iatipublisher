<template>
  <section class="flex space-x-6">
    <div class="min-w-[450px] rounded bg-white p-4">
      <div v-if="currentView !== 'user'">
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
            {{ total }}
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
          <div>
            <div class="mb-1 mt-2 text-2xl text-bluecoral">
              <!-- latest registered -->
              {{
                lastRegistered?.name
                  ? lastRegistered?.name
                  : lastRegistered?.publisher_name
                  ? lastRegistered?.publisher_name
                  : 'untitled'
              }}
            </div>
            <div class="my-1 text-xs italic text-n-40">
              <!-- latest registered date -->
              Registered Date: {{ formatDate(lastRegistered?.created_at) }}
            </div>
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
          <div
            v-if="currentView === 'publisher'"
            class="my-1 text-2xl text-bluecoral"
          >
            <!-- total count -->
            {{ inactivePublisher }}
          </div>
          <div v-else class="my-1 text-2xl text-bluecoral">
            <!-- total count -->
            {{ publisherWithoutActivity }}
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
              <td class="py-3 text-xs font-bold uppercase text-n-40">active</td>
              <td class="py-3 text-xs font-bold uppercase text-n-40">
                disabled
              </td>
              <td class="py-3 text-xs font-bold uppercase text-n-40">total</td>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b border-n-20">
              <td class="px-6 py-2.5 text-sm text-bluecoral">IATI Admin</td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ iatiAdminStats?.active }}
              </td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ iatiAdminStats?.disabled }}
              </td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ iatiAdminStats?.active + iatiAdminStats?.disabled }}
              </td>
            </tr>
            <tr class="border-b border-n-20">
              <td class="px-6 py-2.5 text-sm text-bluecoral">
                Organisation Admin
              </td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ orgAdminStats?.active }}
              </td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ orgAdminStats?.disabled }}
              </td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ orgAdminStats?.active + orgAdminStats?.disabled }}
              </td>
            </tr>
            <tr class="border-b border-n-20">
              <td class="px-6 py-2.5 text-sm text-bluecoral">General Users</td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ genUserStats?.active }}
              </td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ genUserStats?.disabled }}
              </td>
              <td class="px-6 py-2.5 text-sm text-n-50">
                {{ genUserStats?.active + genUserStats?.disabled }}
              </td>
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
import { ref, defineProps, onMounted, watch } from 'vue';
import DashboardGraph from './DashboardGraph.vue';
import axios from 'axios';
import moment from 'moment';

const props = defineProps({
  currentView: {
    type: String,
    required: true,
  },
});
const total = ref();
const inactivePublisher = ref();
const publisherWithoutActivity = ref();
const lastRegistered = ref();

const iatiAdminStats = ref();
const orgAdminStats = ref();
const genUserStats = ref();

onMounted(() => {
  fetchStatsData();
});

const formatDate = (date) => {
  return moment(date).format('MMMM DD, YYYY');
};

watch(
  () => props.currentView,
  () => {
    fetchStatsData();
  }
);
const fetchStatsData = () => {
  axios.get(`/dashboard/${props.currentView}/stats`).then((res) => {
    const response = res.data;
    console.log(response);
    total.value = response.data.totalCount;
    lastRegistered.value = response.data.lastRegisteredPublisher;
    if (props.currentView === 'publisher') {
      inactivePublisher.value = response.data.inActivePublisher;
    }
    if (props.currentView === 'activity') {
      publisherWithoutActivity.value = response.data.publisherWithoutActivity;
    }
    if (props.currentView === 'user') {
      iatiAdminStats.value = response.data.iati_admin;
      orgAdminStats.value = response.data.admin;
      genUserStats.value = response.data.general_user;
      console.log(iatiAdminStats.value?.active);
    }
  });
};
</script>
<style></style>
