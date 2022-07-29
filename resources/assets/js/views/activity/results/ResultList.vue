<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <!-- page title -->
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="max-w-sm pb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <div class="flex">
                <a class="font-bold whitespace-nowrap" href="/activities">
                  Your Activities
                </a>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span
                    class="overflow-hidden breadcrumb__title last text-n-30"
                  >
                    Result List
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    Result List
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
                <span class="overflow-hidden ellipsis__title">
                  Result List
                </span>
              </h4>
            </div>
          </div>
        </div>
        <div class="flex flex-col items-end justify-end actions grow">
          <a :href="`/activities/${activityId}/result/create`">
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
                <span>Title</span>
              </a>
            </th>
            <th id="transaction_value" scope="col" width="190px">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>RESULT TYPE</span>
              </a>
            </th>
            <th id="transaction_date" scope="col" width="208px">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>AGGREGATION STATUS</span>
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
          <tr v-for="(result, t, index) in resultsData.data" :key="index">
            <td>
              <div class="relative ellipsis">
                <a
                  :href="`/activities/${activityId}/result/${result.id}`"
                  class="overflow-hidden ellipsis text-n-50"
                >
                  {{ getActivityTitle(result.result.title[0].narrative, 'en') }}
                </a>
                <div class="w-52">
                  <span class="ellipsis__title--hover">{{
                    getActivityTitle(result.result.title[0].narrative, 'en')
                  }}</span>
                </div>
              </div>
            </td>
            <td>{{ types.resultType[result.result.type] }}</td>
            <td class="capitalize">
              {{ result.result.aggregation_status != 0 }}
            </td>
            <td><span class="text-spring-50">completed</span></td>
            <td>
              <div class="flex">
                <a
                  class="mr-6 text-n-40"
                  :href="`/activities/${result.activity_id}/transactions/${result.id}/edit`"
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
      <Pagination
        :page-count="resultsData.last_page"
        @fetch-activities="fetchListings"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, toRefs, onMounted, reactive } from 'vue';
import axios from 'axios';

// components
import Btn from 'Components/ButtonComponent.vue';
import Pagination from 'Components/TablePagination.vue';

// composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'ResultsList',
  components: {
    Btn,
    Pagination,
  },
  props: {
    activity: {
      type: Object,
      required: true,
    },
    results: {
      type: Object,
      required: true,
    },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { activity, results } = toRefs(props);
    const activityId = activity.value.id;
    // const resultsData = results.value.reverse();

    const resultsData = reactive({});
    const isEmpty = ref(false);

    onMounted(async () => {
      axios.get(`/activities/${activityId}/result/page/1`).then((res) => {
        const response = res.data;
        Object.assign(resultsData, response.data);
        isEmpty.value = response.data.data.length ? false : true;
      });
    });

    function fetchListings(active_page: number) {
      axios
        .get(`/activities/${activityId}/result/page/` + active_page)
        .then((res) => {
          const response = res.data;
          Object.assign(resultsData, response.data);
          isEmpty.value = response.data ? false : true;
        });
    }

    return {
      activityId,
      dateFormat,
      resultsData,
      getActivityTitle,
      fetchListings,
    };
  },
});
</script>
