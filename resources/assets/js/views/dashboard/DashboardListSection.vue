<template>
  <div class="mt-6 w-full bg-white py-6 px-14">
    <div v-if="currentView === 'user'">
      <h6 class="text-xs uppercase text-n-40">users by organisation</h6>
    </div>

    <div v-else>
      <div class="flex">
        <div class="border-r border-n-20">
          <h6
            v-if="currentView === 'activity'"
            class="text-xs uppercase text-n-40"
          >
            activity data
          </h6>
          <h6 v-else class="text-xs uppercase text-n-40">
            Publisher segregated by
          </h6>
          <ul class="mt-4 mr-6">
            <li
              v-for="item in currentNavList"
              :key="item.label"
              class="w-[270px] p-3 text-sm text-n-50"
              :class="activeClass === item.label ? 'activeNav' : ''"
              @click="activeClass = item.label"
            >
              {{ item.label }}
            </li>
          </ul>
        </div>
        <div></div>
      </div>
      <!-- <div v-else>
        <h6 class="text-xs uppercase text-n-40">Publisher segregated by</h6>
      </div> -->
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref, defineProps, watch, onMounted } from 'vue';
import axios from 'axios';

const activityNavList = [
  { label: 'Activity Status', api: '' },
  { label: 'Actvity Added', api: '' },
  { label: 'Activity Completion', api: '' },
];
const publisherNavList = [
  { label: 'Publisher Type', api: '' },
  { label: 'Data Licence', api: '' },
  { label: 'Country', api: '' },
  { label: 'Registration Type', api: '' },
  { label: 'Setup Completeness', api: '' },
];

const currentNavList = ref(publisherNavList);
watch(
  () => props.currentView,
  (value) => {
    if (value === 'activity') {
      currentNavList.value = activityNavList;
    } else {
      currentNavList.value = publisherNavList;
    }

    activeClass.value = currentNavList.value[0].label;
  }
);

const props = defineProps({
  currentView: {
    type: String,
    required: true,
  },
});
const activeClass = ref(currentNavList.value[0].label);
</script>
<style lang="scss">
.activeNav {
  @apply relative mb-2 rounded bg-bluecoral text-white;

  &::after {
    content: ' ';
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    width: 100%;
    height: 1px;
    background-color: #d5dcde;
  }
}
</style>
