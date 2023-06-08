<template>
  <div class="mt-6 w-full bg-white py-6 px-14">
    <div v-if="currentView === 'user'">
      <h6 class="text-xs uppercase text-n-40">users by organisation</h6>

      <table class="mt-2 w-full text-left">
        <thead class="bg-n-10 text-xs font-bold uppercase text-n-40">
          <tr>
            <th><div class="py-3 px-8">Organisation</div></th>
            <th><div class="py-3 px-8">admin</div></th>
            <th><div class="py-3 px-8">general</div></th>
            <th><div class="py-3 px-8">active</div></th>
            <th><div class="py-3 px-8">deactivated</div></th>
            <th><div class="py-3 px-8">total</div></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="organisation in tableData"
            :key="organisation.id"
            class="border-b border-n-20 text-sm text-bluecoral"
          >
            <td>
              <div class="py-3 px-8">{{ organisation.publisher_name }}</div>
            </td>
            <td>
              <div class="py-3 px-8 text-center">
                {{ organisation.admin_user_count }}
              </div>
            </td>

            <td>
              <div class="py-3 px-8 text-center">
                {{ organisation.general_user_count }}
              </div>
            </td>

            <td>
              <div class="py-3 px-8 text-center">
                {{ organisation.active_user_count }}
              </div>
            </td>

            <td>
              <div class="py-3 px-8 text-center">
                {{ organisation.deactivated_user_count }}
              </div>
            </td>

            <td>
              <div class="py-3 px-8 text-center">
                {{ organisation.total_user_count }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
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
          <ul class="mt-4 mr-6 min-h-[300px]">
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
            <thead
              class="bg-[#F1F7F9] text-xs font-bold uppercase text-[#68797E]"
            >
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
                    {{ completeNess?.completeSetup?.count }}
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
                  <div class="px-4 py-3 text-right">
                    {{ completeNess?.completeSetup?.count }}
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-sm text-bluecoral">
                  <div class="py-3 pl-8 text-left">
                    Publisher settings not completed
                  </div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">
                    {{ completeNess?.incompleteSetup?.types?.publisher }}
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-sm text-bluecoral">
                  <div class="py-3 pl-8 text-left">
                    Default values not completed
                  </div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">
                    {{ completeNess?.incompleteSetup?.types?.defaultValue }}
                  </div>
                </td>
              </tr>
              <tr class="border-b border-n-20">
                <td class="text-sm text-bluecoral">
                  <div class="py-3 pl-8 text-left">
                    Both publishing settings and default value not completed
                  </div>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">
                    {{ completeNess?.incompleteSetup?.types?.both }}
                  </div>
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
  { label: 'Activity Status', apiParams: 'status' },
  { label: 'Actvity Added', apiParams: 'method' },
  { label: 'Activity Completion', apiParams: 'completeness' },
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
    fetchTableData(currentNavList.value[0]);

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
  activeClass.value = item.label;
  title.value = item.label;
  console.log(item, 'item');
  if (props.currentView === 'user') {
    (item.label = 'user'), (item.apiParams = 'page/1');
  }

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
