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
              class="w-[270px] cursor-pointer p-3 text-sm text-n-50"
              :class="activeClass === item.label ? 'activeNav' : ''"
              @click="fetchTableData(item)"
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
import { defineEmits } from 'vue';

const emit = defineEmits(['tableNav']);

const activityNavList = [
  { label: 'Activity Status', apiParams: '' },
  { label: 'Actvity Added', apiParams: '' },
  { label: 'Activity Completion', apiParams: '' },
];
const publisherNavList = [
  { label: 'Publisher Type', apiParams: 'type' },
  { label: 'Data Licence', apiParams: 'data-license' },
  { label: 'Country', apiParams: 'registration-type' },
  { label: 'Registration Type', apiParams: 'country' },
  { label: 'Setup Completeness', apiParams: 'setup' },
];

const currentNavList = ref(publisherNavList);

onMounted(() => {
  console.log(props.tableData, 'as props');
});

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
  tableData: {
    type: [Object],
    required: true,
  },
});
const activeClass = ref(currentNavList.value[0].label);

const fetchTableData = (item) => {
  activeClass.value = item.label;
  emit('tableNav', item.apiParams);
};
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
