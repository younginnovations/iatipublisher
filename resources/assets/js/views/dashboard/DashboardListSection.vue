<template>
  <div
    class="mt-6 w-full bg-white px-6 py-6"
    :class="{ '!px-14': currentView !== 'user' }"
  >
    <div v-if="currentView === 'user'">
      <h6 class="text-xs uppercase text-n-40">users by organisation</h6>
      <div class="w-full overflow-x-scroll">
        <table class="mt-2 mb-8 w-full overflow-x-scroll text-left">
          <thead class="bg-n-10 text-xs font-bold uppercase text-n-40">
            <tr>
              <th>
                <div
                  class="flex min-w-[400px] items-center space-x-2 py-3 px-8"
                >
                  <button
                    class="p-1"
                    @click="
                      () => {
                        filter.sort === 'asc'
                          ? (filter.sort = 'desc')
                          : (filter.sort = 'asc');
                        filter.orderBy = 'organisation';
                        sortTable();
                      }
                    "
                  >
                    <svg-vue
                      v-if="
                        filter.sort === 'asc' &&
                        filter.orderBy === 'organisation'
                      "
                      class="text-sm"
                      icon="ascending-arrow"
                    ></svg-vue>
                    <svg-vue
                      v-else
                      class="text-sm"
                      icon="descending-arrow"
                    ></svg-vue>
                  </button>
                  <span>Organisation</span>
                </div>
              </th>
              <th>
                <div class="flex items-center space-x-2 py-3 px-8">
                  <button
                    class="p-1"
                    @click="
                      () => {
                        filter.sort === 'asc'
                          ? (filter.sort = 'desc')
                          : (filter.sort = 'asc');
                        filter.orderBy = 'admin';
                        sortTable();
                      }
                    "
                  >
                    <svg-vue
                      v-if="filter.sort === 'asc' && filter.orderBy === 'admin'"
                      class="text-sm"
                      icon="ascending-arrow"
                    ></svg-vue>
                    <svg-vue
                      v-else
                      class="text-sm"
                      icon="descending-arrow"
                    ></svg-vue>
                  </button>
                  <span>admin</span>
                </div>
              </th>
              <th>
                <div class="flex items-center space-x-2 py-3 px-8">
                  <button
                    class="p-1"
                    @click="
                      () => {
                        filter.sort === 'asc'
                          ? (filter.sort = 'desc')
                          : (filter.sort = 'asc');
                        filter.orderBy = 'general';
                        sortTable();
                      }
                    "
                  >
                    <svg-vue
                      v-if="
                        filter.sort === 'asc' && filter.orderBy === 'general'
                      "
                      class="text-sm"
                      icon="ascending-arrow"
                    ></svg-vue>
                    <svg-vue
                      v-else
                      class="text-sm"
                      icon="descending-arrow"
                    ></svg-vue>
                  </button>
                  <span>general</span>
                </div>
              </th>
              <th>
                <div class="flex items-center space-x-2 py-3 px-8">
                  <button
                    class="p-1"
                    @click="
                      () => {
                        filter.sort === 'asc'
                          ? (filter.sort = 'desc')
                          : (filter.sort = 'asc');
                        filter.orderBy = 'active';
                        sortTable();
                      }
                    "
                  >
                    <svg-vue
                      v-if="
                        filter.sort === 'asc' && filter.orderBy === 'active'
                      "
                      class="text-sm"
                      icon="ascending-arrow"
                    ></svg-vue>
                    <svg-vue
                      v-else
                      class="text-sm"
                      icon="descending-arrow"
                    ></svg-vue>
                  </button>
                  <span>active</span>
                </div>
              </th>
              <th>
                <div class="flex items-center space-x-2 py-3 px-8">
                  <button
                    class="p-1"
                    @click="
                      () => {
                        filter.sort === 'asc'
                          ? (filter.sort = 'desc')
                          : (filter.sort = 'asc');
                        filter.orderBy = 'deactivated';
                        sortTable();
                      }
                    "
                  >
                    <svg-vue
                      v-if="
                        filter.sort === 'asc' &&
                        filter.orderBy === 'deactivated'
                      "
                      class="text-sm"
                      icon="ascending-arrow"
                    ></svg-vue>
                    <svg-vue
                      v-else
                      class="text-sm"
                      icon="descending-arrow"
                    ></svg-vue>
                  </button>
                  <span>deactivated</span>
                </div>
              </th>
              <th>
                <div class="flex items-center space-x-2 py-3 px-8">
                  <button
                    class="p-1"
                    @click="
                      () => {
                        filter.sort === 'asc'
                          ? (filter.sort = 'desc')
                          : (filter.sort = 'asc');
                        filter.orderBy = 'total';
                        sortTable();
                      }
                    "
                  >
                    <svg-vue
                      v-if="filter.sort === 'asc' && filter.orderBy === 'total'"
                      class="text-sm"
                      icon="ascending-arrow"
                    ></svg-vue>
                    <svg-vue
                      v-else
                      class="text-sm"
                      icon="descending-arrow"
                    ></svg-vue></button
                  ><span>total </span>
                </div>
              </th>
            </tr>
          </thead>
          <!-- change this code -->
          <tbody v-if="showTableLoader">
            <tr>
              <td class="py-3 px-8">
                <ShimmerLoading class="!rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
            </tr>
            <tr>
              <td class="py-3 px-8">
                <ShimmerLoading class="!rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
            </tr>
            <tr>
              <td class="py-3 px-8">
                <ShimmerLoading class="!rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
              <td class="py-3 px-8">
                <ShimmerLoading class="mx-auto !w-20 !rounded-sm" />
              </td>
            </tr>
          </tbody>
          <tbody v-else-if="tableData.length === 0">
            <tr class="w-full">
              <div class="p-10 text-center text-n-50">No data found</div>
            </tr>
          </tbody>
          <tbody v-else>
            <tr
              v-for="organisation in tableData.data"
              :key="organisation?.id"
              class="border-b border-n-20 text-sm text-bluecoral"
            >
              <td>
                <a
                  class="... block truncate py-3 px-8"
                  :href="`/users?organization=${organisation.organization_id}`"
                  >{{ truncateText(organisation.organisation, 50) }}</a
                >
              </td>
              <td>
                <p class="block py-3 px-8 text-center">
                  {{ organisation.admin_user_count }}
                </p>
              </td>

              <td>
                <p class="block py-3 px-8 text-center">
                  {{ organisation.general_user_count }}
                </p>
              </td>

              <td>
                <p class="block py-3 px-8 text-center">
                  {{ organisation.active_user_count }}
                </p>
              </td>

              <td>
                <p class="block py-3 px-8 text-center">
                  {{ organisation.deactivated_user_count }}
                </p>
              </td>

              <td>
                <p class="block py-3 px-8 text-center">
                  {{ organisation.total_user_count }}
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <Pagination
        v-if="tableData.last_page > 1"
        :data="tableData"
        @fetch-activities="(page) => triggerpagination(page)"
      />

      <p class="mt-10 text-xs italic text-n-40">
        This widget is not affected by the date range
      </p>
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
              :class="activeClass === item?.label ? 'activeNav' : ''"
              @click="
                () => {
                  currentpage = 1;

                  fetchTableData(item);
                  currentItem = item;
                  resetpagination = true;
                }
              "
            >
              {{ item?.label }}
            </li>
          </ul>
        </div>
        <div class="w-full px-4">
          <table class="w-full">
            <thead
              v-if="
                currentView === 'activity' && title === 'Activity Completion'
              "
              class="bg-[#F1F7F9] text-xs font-bold uppercase text-[#68797E]"
            >
              <tr>
                <th>
                  <div class="px-4 py-3 text-left">{{ title }}</div>
                </th>
                <td class="mx-8 my-3 w-[100px]">
                  <div class="px-4 py-3 text-right">published</div>
                </td>
                <td class="mx-8 my-3 w-[100px]">
                  <div class="px-4 py-3 text-right">draft</div>
                </td>
                <td class="mx-8 my-3 w-[100px]">
                  <div class="px-4 py-3 text-right">total</div>
                </td>
              </tr>
            </thead>
            <thead
              v-else
              class="bg-[#F1F7F9] text-xs font-bold uppercase text-[#68797E]"
            >
              <tr>
                <th>
                  <div class="flex items-center space-x-2 px-4 py-3 text-left">
                    <button
                      v-if="
                        currentView === 'publisher' &&
                        title !== 'Setup Completeness' &&
                        title !== 'Registration Type'
                      "
                      class="p-1"
                      @click="
                        () => {
                          filter.sort === 'asc'
                            ? (filter.sort = 'desc')
                            : (filter.sort = 'asc');
                          filter.orderBy = sortElement.apiParams;
                          sortTable();
                        }
                      "
                    >
                      <svg-vue
                        v-if="
                          filter.sort === 'asc' &&
                          filter.orderBy === sortElement.apiParams
                        "
                        class="text-sm"
                        icon="ascending-arrow"
                      ></svg-vue>
                      <svg-vue
                        v-else
                        class="text-sm"
                        icon="descending-arrow"
                      ></svg-vue>
                    </button>

                    <span>{{ title }} </span>
                  </div>
                </th>
                <td class="mx-8 my-3 w-[100px]">
                  <div class="flex items-center space-x-2 px-4 py-3 text-right">
                    <button
                      v-if="
                        currentView === 'publisher' &&
                        title !== 'Setup Completeness' &&
                        title !== 'Registration Type'
                      "
                      class="p-1"
                      @click="
                        () => {
                          filter.sort === 'asc'
                            ? (filter.sort = 'desc')
                            : (filter.sort = 'asc');
                          filter.orderBy = 'count';
                          sortTable();
                        }
                      "
                    >
                      <svg-vue
                        v-if="
                          filter.sort === 'asc' && filter.orderBy === 'count'
                        "
                        class="text-sm"
                        icon="ascending-arrow"
                      ></svg-vue>
                      <svg-vue
                        v-else
                        class="text-sm"
                        icon="descending-arrow"
                      ></svg-vue>
                    </button>
                    <span>total</span>
                  </div>
                </td>
              </tr>
            </thead>
            <tbody v-if="showTableLoader">
              <tr>
                <td class="py-3 px-8">
                  <ShimmerLoading class="!rounded-sm" />
                </td>
                <td class="py-3 px-8">
                  <ShimmerLoading class="!w-10 !rounded-sm" />
                </td>
              </tr>
              <tr>
                <td class="py-3 px-8">
                  <ShimmerLoading class="!rounded-sm" />
                </td>
                <td class="py-3 px-8">
                  <ShimmerLoading class="!w-10 !rounded-sm" />
                </td>
              </tr>
              <tr>
                <td class="py-3 px-8">
                  <ShimmerLoading class="!rounded-sm" />
                </td>
                <td class="py-3 px-8">
                  <ShimmerLoading class="!w-10 !rounded-sm" />
                </td>
              </tr>
            </tbody>
            <tbody
              v-else-if="
                tableData.length === 0 || tableData?.data?.length === 0
              "
              class="text-center shadow-md"
            >
              <div class="p-10">No data found</div>
            </tbody>
            <tbody
              v-else-if="
                title === 'Setup Completeness' && currentView === 'publisher'
              "
            >
              <tr class="border-b border-n-20">
                <td class="text-sm text-bluecoral">
                  <a
                    class="px-4 py-3 text-left"
                    :href="`/list-organisations?completeness=Publishers_with_complete_setup`"
                  >
                    Publishers with complete setup
                  </a>
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
                    {{ completeNess?.incompleteSetup?.count }}
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-sm text-bluecoral">
                  <a
                    class="py-3 pl-8 text-left"
                    :href="`/list-organisations?completeness=Publishers_settings_not_completed`"
                  >
                    Publisher settings not completed
                  </a>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">
                    {{ completeNess?.incompleteSetup?.types?.publisher }}
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-sm text-bluecoral">
                  <a
                    class="py-3 pl-8 text-left"
                    :href="`/list-organisations?completeness=Default_values_not_completed`"
                  >
                    Default values not completed
                  </a>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">
                    {{ completeNess?.incompleteSetup?.types?.defaultValue }}
                  </div>
                </td>
              </tr>
              <tr class="border-b border-n-20">
                <td class="text-sm text-bluecoral">
                  <a
                    class="py-3 pl-8 text-left"
                    :href="`/list-organisations?completeness=Both_publishing_settings_and_default_values_not_completed`"
                  >
                    Both publishing settings and default value not completed
                  </a>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">
                    {{ completeNess?.incompleteSetup?.types?.both }}
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody
              v-else-if="
                title === 'Registration Type' &&
                currentView === 'publisher' &&
                registrationType.length == 0
              "
              class="text-center shadow-md"
            >
              <div class="p-10">No data found</div>
            </tbody>
            <tbody
              v-else-if="
                title === 'Registration Type' && currentView === 'publisher'
              "
            >
              <tr
                v-for="item in registrationType"
                :key="item?.id"
                class="border-b border-n-20"
              >
                <td class="text-sm text-bluecoral">
                  <a
                    class="py-3 pl-8 text-left"
                    :href="`/list-organisations?registration-type=${item?.registration_type}`"
                  >
                    {{
                      item?.registration_type === 'new_org'
                        ? 'New Organisation'
                        : 'Existing Organisation'
                    }}
                  </a>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">
                    {{ item.count }}
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody
              v-else-if="
                title !== 'Setup Completeness' && currentView === 'publisher'
              "
            >
              <tr
                v-for="item in tableData.data"
                :key="item?.id"
                class="border-b border-n-20"
              >
                <td class="text-sm text-bluecoral">
                  <a
                    :href="`/list-organisations?${currentItem?.apiParams}=${item.id}`"
                    class="px-4 py-3 text-left capitalize"
                  >
                    <!-- {{ item?.label.replace(/_/g, ' ') }} -->
                    {{ item['label'] }}
                  </a>
                </td>
                <td class="text-sm text-[#2A2F30]">
                  <div class="px-4 py-3 text-right">{{ item?.total }}</div>
                </td>
              </tr>
            </tbody>
            <tbody
              v-else-if="
                currentView === 'activity' && title !== 'Activity Completion'
              "
            >
              <tr
                v-for="(item, index) in tableData"
                :key="item?.id"
                class="border-b border-n-20"
              >
                <td class="text-sm text-bluecoral">
                  <div class="px-4 py-3 text-left">
                    {{ index }}
                  </div>
                </td>
                <td class="text-center text-sm text-[#2A2F30]">
                  <div class="px-4 py-3">{{ item }}</div>
                </td>
              </tr>
            </tbody>
            <tbody
              v-else-if="
                currentView === 'activity' && title === 'Activity Completion'
              "
            >
              <tr
                v-for="(item, index) in tableData"
                :key="item?.id"
                class="border-b border-n-20"
              >
                <td class="text-sm text-bluecoral">
                  <div class="px-4 py-3 text-left">
                    {{ index }}
                  </div>
                </td>
                <td class="text-center text-sm text-[#2A2F30]">
                  <div class="px-4 py-3">
                    {{ Number(item?.published ?? 0) }}
                  </div>
                </td>
                <td class="text-center text-sm text-[#2A2F30]">
                  <div class="px-4 py-3">{{ Number(item?.draft ?? 0) }}</div>
                </td>
                <td class="text-center text-sm text-[#2A2F30]">
                  <div class="px-4 py-3">
                    {{
                      Number(item?.published ?? 0) + Number(item?.draft ?? 0)
                    }}
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody v-else class="text-center shadow-md">
              <div class="p-10">No data found</div>
            </tbody>
          </table>
          <Pagination
            v-if="
              title !== 'Setup Completeness' &&
              title !== 'Registration Type' &&
              tableData.paginatedData?.last_page > 1 &&
              currentView === 'publisher'
            "
            class="mt-4"
            :reset="resetpagination"
            :data="tableData.paginatedData"
            @fetch-activities="(page) => triggerpagination(page)"
          />
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
import Pagination from 'Components/TablePagination.vue';
import ShimmerLoading from 'Components/ShimmerLoading.vue';
import { truncateText } from 'Composable/utils';

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

const emit = defineEmits(['tableNav']);

const activityNavList = [
  { label: 'Activity Status', apiParams: 'status' },
  { label: 'Activity Added', apiParams: 'method' },
  { label: 'Activity Completion', apiParams: 'completeness' },
];
const publisherNavList = [
  { label: 'Publisher Type', apiParams: 'publisher-type' },
  { label: 'Data Licence', apiParams: 'data-license' },
  { label: 'Country', apiParams: 'country' },
  { label: 'Registration Type', apiParams: 'registration-type' },
  { label: 'Setup Completeness', apiParams: 'setup' },
];
const currentpage = ref(1);
const resetpagination = ref(false);
const filter = ref({ orderBy: '', sort: '' });
const sortElement = ref({ label: '', apiParams: '' });
const userNavlist = [{ label: 'user', apiParams: '' }];
const currentItem = ref({
  label: 'Publisher Type',
  apiParams: 'publisher-type',
});
const currentNavList = ref(publisherNavList);
const title = ref(currentNavList.value[0]?.label);
onMounted(() => {
  fetchTableData(currentNavList.value[0]);
});
const sortTable = () => {
  fetchTableData(currentItem.value, false);
};
const triggerpagination = (page) => {
  currentpage.value = page;
  resetpagination.value = false;
  fetchTableData(currentItem.value);
};

watch(
  () => props.currentView,
  (value) => {
    if (value === 'activity') {
      currentItem.value = { label: 'Activity Status', apiParams: 'status' };

      currentNavList.value = activityNavList;
    } else if (value === 'publisher') {
      currentItem.value = {
        label: 'Publisher Type',
        apiParams: 'publisher-type',
      };

      currentNavList.value = publisherNavList;
    } else {
      currentNavList.value = userNavlist;
      currentItem.value = {
        label: 'user',
        apiParams: '',
      };
    }
    fetchTableData(currentNavList.value[0]);

    activeClass.value = currentNavList.value[0]?.label;
    title.value = currentNavList.value[0]?.label;
  }
);

const activeClass = ref(currentNavList.value[0]?.label);

const fetchTableData = (item, tabChange = true) => {
  activeClass.value = item?.label;
  title.value = item?.label;
  sortElement.value = item;
  emit('tableNav', item, filter, currentpage.value, tabChange);
};
const completeNess = inject('completeNess') as Ref;
const registrationType = inject('registrationType') as Ref;
const showTableLoader = inject('showTableLoader') as Ref;
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
