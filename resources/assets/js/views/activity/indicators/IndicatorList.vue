<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Indicator List"
      :back-link="`${resultLink}`"
    >
      <div class="mb-3">
        <Toast
          v-if="toastData.visibility"
          :message="toastData.message"
          :type="toastData.type"
        />
      </div>
      <a :href="`${resultLink}/indicator/create`">
        <Btn text="Add Indicator" icon="plus" type="primary" />
      </a>
    </PageTitle>

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
                  :href="`/result/${indicator.result_id}/indicator/${indicator.id}`"
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
                  :href="`/result/${indicator.result_id}/indicator/${indicator.id}/edit`"
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
      <Pagination :data="indicatorsData" @fetch-activities="fetchListings" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, reactive, ref, onMounted } from 'vue';
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
  name: 'IndicatorList',
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
    toast: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { activity, parentData } = toRefs(props);

    const activityId = activity.value.id,
      activityTitle = activity.value.title,
      activityLink = `/activity/${activityId}`,
      resultId = parentData.value.result.id,
      resultTitle = getActivityTitle(parentData.value.result.title, 'en'),
      resultLink = `${activityLink}/result/${resultId}`;

    const indicatorsData = reactive({});
    const isEmpty = ref(false);
    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

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
        link: `/activity/${activityId}`,
      },
      {
        title: resultTitle,
        link: `/activity/${activityId}/result/${resultId}`,
      },
      {
        title: 'Indicator List',
        link: '',
      },
    ];

    onMounted(async () => {
      axios
        .get(`/result/${resultId}/indicator/page/1`)
        .then((res) => {
          const response = res.data;
          Object.assign(indicatorsData, response.data);
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
        .get(
          `/result/${resultId}/indicator/page/` +
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
      resultLink,
      breadcrumbData,
      toastData,
    };
  },
});
</script>
