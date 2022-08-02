<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <!-- page title -->
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="pb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <div class="flex">
                <a class="font-bold whitespace-nowrap" href="/activities">
                  Your Activities
                </a>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span class="overflow-hidden breadcrumb__title text-n-30">
                    <a :href="`/activities/${activity.id}`">
                      {{ getActivityTitle(activity.title, 'en') ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ getActivityTitle(activity.title, 'en') ?? 'Untitled' }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span class="overflow-hidden breadcrumb__title text-n-30">
                    <a
                      :href="`/activities/${activity.id}/result/${resultId}/indicator`"
                    >
                      {{ getActivityTitle(resultTitle, 'en') ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ getActivityTitle(resultTitle, 'en') ?? 'Untitled' }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span class="overflow-hidden breadcrumb__title text-n-30">
                    <a
                      :href="`/activities/${activity.id}/result/${resultId}/indicator/${indicatorId}`"
                    >
                      {{ getActivityTitle(indicatorTitle, 'en') ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{
                      getActivityTitle(parentData.indicator.title, 'en') ??
                      'Untitled'
                    }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span
                    class="overflow-hidden breadcrumb__title last text-n-30"
                  >
                    Periods List
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    Periods List
                  </span>
                </div>
              </div>
            </nav>
          </div>
          <div class="inline-flex items-center max-w-3xl">
            <div class="mr-3">
              <a :href="`/activities/${activityId}`">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <div class="">
              <h4 class="relative mr-4 font-bold ellipsis__title">
                <span class="overflow-hidden ellipsis__title">Periods List</span
                ><span class="ellipsis__title--hover">Periods List</span>
              </h4>
            </div>
          </div>
        </div>

        <div class="flex flex-col items-end justify-end actions grow">
          <a :href="`/activities/${activityId}/result/1/indicator/create`">
            <Btn text="Add Results" icon="plus" type="primary" />
          </a>
        </div>
      </div>
    </div>

    <!-- page content -->
    <div class="iati-list-table text-n-40">
      <table>
        <thead>
          <tr class="text-left bg-n-10">
            <th id="transaction_type" scope="col">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Start Date - End Date</span>
              </a>
            </th>
            <th id="complete-status" scope="col" width="180px">
              <span>Status</span>
            </th>
            <th id="action" scope="col" width="177px">
              <span>Action</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(pe, p) in periodsData.data" :key="p">
            <td>
              <a
                class="text-sm font-bold leading-relaxed text-n-50"
                :href="`/activities/${activity.id}/result/${resultId}/indicator/${indicatorId}/period/${pe.id}`"
              >
                {{ dateFormat(pe.period.period_start[0].date) }} -
                {{ dateFormat(pe.period.period_end[0].date) }}
              </a>
            </td>
            <td><span class="text-spring-50">completed</span></td>
            <td>
              <div class="flex">
                <a
                  class="mr-6 text-n-40"
                  :href="`/activities/${activity.id}/result/${resultId}/indicator/${indicatorId}/period/${pe.id}`"
                >
                  <svg-vue icon="edit" class="text-xl"></svg-vue>
                </a>
                <a class="text-n-40" href="#">
                  <svg-vue icon="delete" class="text-xl"></svg-vue>
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-6">
      <Pagination :data="periodsData" @fetch-activities="fetchListings" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, onMounted, ref, reactive } from 'vue';
import axios from 'axios';
// components
import Btn from 'Components/ButtonComponent.vue';
import Pagination from 'Components/TablePagination.vue';

// composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'PeriodList',
  components: {
    Btn,
    Pagination,
  },
  props: {
    activity: {
      type: Object,
      required: true,
    },
    parentData: {
      type: Object,
      required: true,
    },
    period: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    const { activity, parentData } = toRefs(props);
    const activityId = activity.value.id,
      resultTitle = parentData.value.result.title,
      resultId = parentData.value.result.id,
      indicatorTitle = parentData.value.result.title,
      indicatorId = parentData.value.result.id;

    const periodsData = reactive({});
    const isEmpty = ref(false);

    onMounted(async () => {
      axios
        .get(
          `/activities/${activityId}/result/${resultId}/indicator/${indicatorId}/period/page/1`
        )
        .then((res) => {
          const response = res.data;
          Object.assign(periodsData, response.data);
          isEmpty.value = response.data.data.length ? false : true;
        });
    });

    function fetchListings(active_page: number) {
      axios
        .get(
          `/activities/${activityId}/result/${resultId}/indicator/${indicatorId}/period/page/` +
            active_page
        )
        .then((res) => {
          const response = res.data;
          Object.assign(periodsData, response.data);
          isEmpty.value = response.data ? false : true;
        });
    }

    return {
      activityId,
      resultTitle,
      resultId,
      indicatorTitle,
      indicatorId,
      dateFormat,
      periodsData,
      getActivityTitle,
      fetchListings,
    };
  },
});
</script>
