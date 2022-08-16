<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Result List"
      :back-link="activityLink"
    >
      <div class="mb-3">
        <Toast
          v-if="toastData.visibility"
          :message="toastData.message"
          :type="toastData.type"
        />
      </div>
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
              <span>Title</span>
            </th>
            <th id="transaction_value" scope="col" width="190px">
              <span>RESULT TYPE</span>
            </th>
            <th id="transaction_date" scope="col" width="208px">
              <span>AGGREGATION STATUS</span>
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
                  :href="`${activityLink}/result/${result.id}`"
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
            <td>
              {{ types.resultType[result.result.type] ?? 'Not Available' }}
            </td>
            <td class="capitalize">
              {{
                parseInt(result.result.aggregation_status)
                  ? 'True'
                  : result.result.aggregation_status
                  ? 'False'
                  : 'Not Available'
              }}
            </td>
            <td>
              <div class="flex">
                <a
                  class="mr-6 text-n-40"
                  :href="`/activity/${result.activity_id}/result/${result.id}/edit`"
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
        v-if="resultsData && resultsData.last_page > 1"
        :data="resultsData"
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
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/Toast.vue';

// composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'ResultsList',
  components: {
    Btn,
    Pagination,
    PageTitle,
    Toast,
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
    toast: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { activity } = toRefs(props);
    const activityId = activity.value.id,
      activityTitle = activity.value.title,
      activityLink = `/activity/${activityId}`;
    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

    interface ResultsInterface {
      last_page: number;
      data: {
        id: number;
        result: {
          title: {
            narrative: [];
          }[];
          type: string;
          aggregation_status: string;
        };
        activity_id: number;
      }[];
    }

    const resultsData = reactive({}) as ResultsInterface;
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
      axios.get(`/activity/${activityId}/results/page/1`).then((res) => {
        const response = res.data;
        Object.assign(resultsData, response.data);
        isEmpty.value = response.data.data.length ? false : true;
      });

      if (props.toast.message !== '') {
        toastData.type = props.toast.type;
        toastData.visibility = true;
        toastData.message = props.toast.message;
      }

      setTimeout(() => {
        toastData.visibility = false;
      }, 5000);
    });

    function fetchListings(active_page: number) {
      axios
        .get(`/activity/${activityId}/results/page/` + active_page)
        .then((res) => {
          const response = res.data;
          Object.assign(resultsData, response.data);
          isEmpty.value = response.data ? false : true;
        });
    }

    return {
      breadcrumbData,
      activityLink,
      toastData,
      dateFormat,
      resultsData,
      getActivityTitle,
      fetchListings,
    };
  },
});
</script>
