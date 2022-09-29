<template>
  <div class="relative bg-paper px-5 xl:px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Indicator List"
      :back-link="`${resultLink}`"
    >
      <Toast
        v-if="toastData.visibility"
        :message="toastData.message"
        :type="toastData.type"
        class="mr-3"
      />
      <a :href="`${indicatorLink}/create`">
        <Btn text="Add Indicator" icon="plus" type="primary" />
      </a>
    </PageTitle>

    <div class="iati-list-table text-n-40">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="title" scope="col">
              <span>Title</span>
            </th>
            <th id="measure" scope="col" width="190px">
              <span>Measure</span>
            </th>
            <th id="aggregation_status" scope="col" width="208px">
              <span>Aggregation Status</span>
            </th>
            <th id="action" scope="col" width="190px">
              <span>Action</span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(indicator, t, index) in indicatorsData.data" :key="index">
            <td>
              <div class="ellipsis relative">
                <a
                  :href="`/result/${indicator.result_id}/indicator/${indicator.id}`"
                  class="ellipsis overflow-hidden text-n-50"
                >
                  {{ getActivityTitle(indicator.indicator.title[0].narrative, "en") }}
                </a>
                <div class="w-52">
                  <span class="ellipsis__title--hover">{{
                    getActivityTitle(indicator.indicator.title[0].narrative, "en")
                  }}</span>
                </div>
              </div>
            </td>
            <td>{{ types.indicatorMeasure[indicator.indicator.measure] }}</td>
            <td class="capitalize">
              {{
                parseInt(indicator.indicator.aggregation_status)
                  ? "True"
                  : indicator.indicator.aggregation_status
                  ? "False"
                  : "Not Available"
              }}
            </td>
            <td>
              <div class="flex text-n-40">
                <a
                  class="mr-6"
                  :href="`/result/${indicator.result_id}/indicator/${indicator.id}/edit`"
                >
                  <svg-vue icon="edit" class="text-xl"></svg-vue>
                </a>
                <DeleteAction :item-id="indicator.id" item-type="indicator" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-6">
      <Pagination
        v-if="indicatorsData && indicatorsData.last_page > 1"
        :data="indicatorsData"
        @fetch-activities="fetchListings"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, reactive, ref, onMounted, provide } from "vue";
import axios from "axios";

// components
import Btn from "Components/ButtonComponent.vue";
import Pagination from "Components/TablePagination.vue";
import PageTitle from "Components/sections/PageTitle.vue";
import Toast from "Components/Toast.vue";
import DeleteAction from "Components/sections/DeleteAction.vue";

// composable
import dateFormat from "Composable/dateFormat";
import getActivityTitle from "Composable/title";

export default defineComponent({
  name: "IndicatorList",
  components: {
    Btn,
    Pagination,
    PageTitle,
    Toast,
    DeleteAction,
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
      resultTitle = getActivityTitle(parentData.value.result.title, "en"),
      resultLink = `${activityLink}/result/${resultId}`,
      indicatorLink = `/result/${resultId}/indicator`;

    interface IndicatorInterface {
      last_page: number;
      data: {
        result_id: number;
        id: number;
        indicator: {
          title: {
            narrative: [];
          }[];
          measure: string;
          aggregation_status: string;
        };
        activity_id: number;
      }[];
    }
    const indicatorsData = reactive({}) as IndicatorInterface;
    const isEmpty = ref(false);
    const toastData = reactive({
      visibility: false,
      message: "",
      type: true,
    });

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: "Your Activities",
        link: "/activities",
      },
      {
        title: getActivityTitle(activityTitle, "en"),
        link: `/activity/${activityId}`,
      },
      {
        title: resultTitle,
        link: `/activity/${activityId}/result/${resultId}`,
      },
      {
        title: "Indicator List",
        link: "",
      },
    ];

    onMounted(async () => {
      axios.get(`/result/${resultId}/indicators/page/1`).then((res) => {
        const response = res.data;
        Object.assign(indicatorsData, response.data);
        isEmpty.value = response.data.data.length ? false : true;
      });

      if (props.toast.message !== "") {
        toastData.type = props.toast.type;
        toastData.visibility = true;
        toastData.message = props.toast.message;
      }

      setTimeout(() => {
        toastData.visibility = false;
      }, 5000);
    });

    function fetchListings(active_page: number) {
      axios.get(`/result/${resultId}/indicators/page/` + active_page).then((res) => {
        const response = res.data;
        Object.assign(indicatorsData, response.data);
        isEmpty.value = response.data ? false : true;
      });
    }

    // provide
    provide("parentItemId", resultId);

    return {
      activityId,
      dateFormat,
      indicatorsData,
      getActivityTitle,
      fetchListings,
      resultLink,
      indicatorLink,
      breadcrumbData,
      toastData,
      resultId,
    };
  },
});
</script>
