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
                    <a :href="`/activities/${activityId}`">
                      {{ getActivityTitle(activity.title, 'en') ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ getActivityTitle(activity.title, 'en') ?? 'Untitled' }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span
                    class="overflow-hidden breadcrumb__title last text-n-30"
                  >
                    <a :href="`/activities/${activityId}/result/${resultId}`">
                      {{ getActivityTitle(resultTitle, 'en') ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ getActivityTitle(resultTitle, 'en') ?? 'Untitled' }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span
                    class="overflow-hidden breadcrumb__title last text-n-30"
                  >
                    Indicator List
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    Indicator List
                  </span>
                </div>
              </div>
            </nav>
          </div>
          <div class="inline-flex items-center max-w-3xl">
            <div class="mr-3">
              <a :href="`/activities/${activityId}/result/${resultId}`">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <div class="">
              <h4 class="relative mr-4 font-bold ellipsis__title">
                <span class="overflow-hidden ellipsis__title"
                  >Indicator List</span
                ><span class="ellipsis__title--hover">Indicator List</span>
              </h4>
            </div>
          </div>
        </div>
        <div class="flex flex-col items-end justify-end actions grow">
          <a :href="`/activities/${activityId}/result/1/indicator/create`">
            <Btn text="Add Indicator" icon="plus" type="primary" />
          </a>
        </div>
      </div>
    </div>

    <!-- page content -->
    <div class="iati-list-table text-n-40">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="title" scope="col">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Title</span>
              </a>
            </th>
            <th id="measure" scope="col" width="190px">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Measure</span>
              </a>
            </th>
            <th id="aggregation_status" scope="col" width="208px">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Aggregation Status</span>
              </a>
            </th>
            <th id="complete_status" scope="col" width="180px">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Status</span>
              </a>
            </th>
            <th id="action" scope="col" width="190px">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Action</span>
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(indicator, t, index) in indicatorsData.data" :key="index">
            <td>
              <div class="relative ellipsis">
                <a
                  :href="`/activities/${activity.id}/result/${indicator.result_id}/indicator/${indicator.id}`"
                  class="overflow-hidden ellipsis text-n-50"
                >
                  {{
                    getActivityTitle(
                      indicator.indicator.title[0].narrative,
                      'en'
                    )
                  }}
                </a>
                <div class="w-52">
                  <span class="ellipsis__title--hover">{{
                    getActivityTitle(
                      indicator.indicator.title[0].narrative,
                      'en'
                    )
                  }}</span>
                </div>
              </div>
            </td>
            <td>{{ types.indicatorMeasure[indicator.indicator.measure] }}</td>
            <td class="capitalize">
              {{ indicator.indicator.aggregation_status != 0 }}
            </td>
            <td><span class="text-spring-50">completed</span></td>
            <td>
              <div class="flex text-n-40">
                <a
                  class="mr-6"
                  :href="`/activities/${activity.id}/result/${indicator.result_id}/indicator/${indicator.id}/edit`"
                >
                  <svg-vue icon="edit" class="text-xl"></svg-vue>
                </a>
                <button class="">
                  <svg-vue icon="delete" class="text-xl"></svg-vue>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-6">
      <Pagination
        :data="indicatorsData"
        @fetch-activities="fetchListings"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, reactive, ref, onMounted } from 'vue';
import axios from 'axios';

// components
import Btn from 'Components/ButtonComponent.vue';
import Pagination from 'Components/TablePagination.vue';

// composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'IndicatorList',
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
    indicators: {
      type: Object,
      required: true,
    },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { activity, parentData } = toRefs(props);
    const activityId = activity.value.id,
      resultTitle = parentData.value.result.title,
      resultId = parentData.value.result.id;

    const indicatorsData = reactive({});
    const isEmpty = ref(false);

    onMounted(async () => {
      axios
        .get(`/activities/${activityId}/result/${resultId}/indicator/page/1`)
        .then((res) => {
          const response = res.data;
          Object.assign(indicatorsData, response.data);
          isEmpty.value = response.data.data.length ? false : true;
        });
    });

    function fetchListings(active_page: number) {
      axios
        .get(
          `/activities/${activityId}/result/${resultId}/indicator/page/` +
            active_page
        )
        .then((res) => {
          const response = res.data;
          Object.assign(indicatorsData, response.data);
          isEmpty.value = response.data ? false : true;
        });
    }

    return {
      activityId,
      dateFormat,
      indicatorsData,
      getActivityTitle,
      fetchListings,
      resultTitle,
      resultId,
    };
  },
});
</script>
