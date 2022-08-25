<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Periods List"
      :back-link="indicatorLink"
    >
      <div class="mb-3">
        <Toast
          v-if="toastData.visibility"
          :message="toastData.message"
          :type="toastData.type"
        />
      </div>
      <a :href="`${periodLink}/create`">
        <Btn text="Add Period" icon="plus" type="primary" />
      </a>
    </PageTitle>

    <div class="iati-list-table text-n-40">
      <table>
        <thead>
          <tr class="text-left bg-n-10">
            <th id="transaction_type" scope="col">
              <span>Start Date - End Date</span>
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
                :href="`${periodLink}/${pe.id}`"
              >
                {{
                  pe.period.period_start[0].date
                    ? dateFormat(pe.period.period_start[0].date)
                    : 'Not Available'
                }}
                -
                {{
                  pe.period.period_end[0].date
                    ? dateFormat(pe.period.period_end[0].date)
                    : 'Not Available'
                }}
              </a>
            </td>
            <td>
              <div class="flex">
                <a class="mr-6 text-n-40" :href="`${periodLink}/${pe.id}/edit`">
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
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/Toast.vue';

// composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'PeriodList',
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
    period: {
      type: Array,
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
      resultTitle = parentData.value.result.title,
      resultId = parentData.value.result.id,
      resultLink = `${activityLink}/result/${resultId}`,
      indicatorTitle = parentData.value.indicator.title,
      indicatorId = parentData.value.indicator.id,
      indicatorLink = `/result/${resultId}/indicator/${indicatorId}`,
      periodLink = `/indicator/${indicatorId}/period`;

    const periodsData = reactive({});
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
        link: '/activity',
      },
      {
        title: getActivityTitle(activityTitle, 'en'),
        link: activityLink,
      },
      {
        title: getActivityTitle(resultTitle, 'en'),
        link: resultLink,
      },
      {
        title: getActivityTitle(indicatorTitle, 'en'),
        link: indicatorLink,
      },
      {
        title: 'Periods List',
        link: '',
      },
    ];

    onMounted(async () => {
      axios.get(`/indicator/${indicatorId}/periods/page/1`).then((res) => {
        const response = res.data;
        Object.assign(periodsData, response.data);
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
        .get(`/indicator/${indicatorId}/periods/page/` + active_page)
        .then((res) => {
          const response = res.data;
          Object.assign(periodsData, response.data);
          isEmpty.value = response.data ? false : true;
        });
    }

    return {
      breadcrumbData,
      indicatorLink,
      periodLink,
      dateFormat,
      periodsData,
      getActivityTitle,
      fetchListings,
      indicatorId,
      toastData,
    };
  },
});
</script>
