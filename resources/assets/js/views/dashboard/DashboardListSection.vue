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
        <div class="w-full px-4">
          <table class="w-full">
            <thead class="bg-[#F1F7F9] text-xs uppercase text-[#68797E]">
              <tr>
                <th>
                  <div class="px-4 py-3 text-left">{{ title }}</div>
                </th>
                <td class="mx-8 my-3 w-[100px]">
                  <div class="px-4 py-3 text-right">total</div>
                </td>
              </tr>
            </thead>
            <tbody v-if="title === 'Setup Completeness'">
              <tr class="border-b border-n-20">
                <td class="text-sm text-bluecoral">
                  <div class="px-4 py-3 text-left">
                    Publishers with complete setup
                  </div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">
                    {{ completeNess.completeSetup.count }}
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-sm text-bluecoral">
                  <div class="px-4 py-3 text-left">
                    Publishers with incomplete setup
                  </div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">99</div>
                </td>
              </tr>
              <tr>
                <td class="text-sm text-bluecoral">
                  <div class="py-3 pl-8 text-left">
                    Publisher settings not completed
                  </div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">99</div>
                </td>
              </tr>
              <tr>
                <td class="text-sm text-bluecoral">
                  <div class="py-3 pl-8 text-left">
                    Default values not completed
                  </div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">99</div>
                </td>
              </tr>
              <tr class="border-b border-n-20">
                <td class="text-sm text-bluecoral">
                  <div class="py-3 pl-8 text-left">
                    Both publishing settings and default value not completed
                  </div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">99</div>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr
                v-for="item in tableData"
                :key="item.id"
                class="border-b border-n-20"
              >
                <td class="text-sm text-bluecoral">
                  <div class="px-4 py-3 text-left">{{ item.label }}</div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">{{ item.total }}</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- <div v-else>
        <h6 class="text-xs uppercase text-n-40">Publisher segregated by</h6>
      </div> -->
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref, defineProps, watch, onMounted, inject, Ref } from 'vue';
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
  { label: 'Country', apiParams: 'country' },
  { label: 'Registration Type', apiParams: 'registration-type' },
  { label: 'Setup Completeness', apiParams: 'setup' },
];

const currentNavList = ref(publisherNavList);
const title = ref(currentNavList.value[0].label);
onMounted(() => {
  console.log(props.tableData, 'as props');
  fetchTableData(currentNavList.value[0]);
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
    title.value = currentNavList.value[0].label;
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
  tableHeader: {
    type: String,
    required: true,
  },
});
const activeClass = ref(currentNavList.value[0].label);

const fetchTableData = (item) => {
  console.log('fetch ', completeNess);
  activeClass.value = item.label;
  title.value = item.label;
  emit('tableNav', item);
};
const completeNess = inject('completeNess') as Ref;
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
