<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Result List"
      :back-link="activityLink"
    >
      <a :href="`${activityLink}/result/create`">
        <Btn text="Add Result" icon="plus" type="primary" />
      </a>
    </PageTitle>

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
                  :href="`/activities/${result.activity_id}/result/${result.id}/edit`"
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
      <Pagination :data="resultsData" @fetch-activities="fetchListings" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, toRefs, onMounted, reactive } from 'vue';
import axios from 'axios';

// components
import Btn from 'Components/ButtonComponent.vue';
import Pagination from 'Components/TablePagination.vue';
import PageTitle from 'Components/sections/PageTitle.vue';

// composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'ResultsList',
  components: {
    Btn,
    Pagination,
    PageTitle,
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
    const { activity } = toRefs(props);
    const activityId = activity.value.id,
      activityTitle = activity.value.title,
      activityLink = `/activities/${activityId}`;

    const resultsData = reactive({});
    const isEmpty = ref(false);

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: 'Your Activities',
        link: '/activities',
      },
      {
        title: getActivityTitle(activityTitle, 'en'),
        link: activityLink,
      },
      {
        title: 'Result List',
        link: '',
      },
    ];

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
      breadcrumbData,
      activityLink,
      dateFormat,
      resultsData,
      getActivityTitle,
      fetchListings,
    };
  },
});
</script>
