<template>
  <div
    id="activity-listing-page"
    class="listing__page bg-paper px-10 pt-4 pb-[71px]"
  >
    <div id="activity">
      <PageTitle :show-buttons="state.showButtons" />
      <Toast
          v-if="toastData.visibility"
          :message="toastData.message"
          :type="toastData.type"
      />
      <Toast
          v-if="toastMessage.message"
          class="mr-3.5"
          :message="toastMessage.message"
          :type="toastMessage.type"
      />
      <EmptyActivity v-if="isEmpty" />
      <TableLayout
        v-if="!isEmpty"
        :data="activities"
        @show-or-hide="showOrHide"
      />
      <div v-if="!isEmpty" class="mt-6">
        <Pagination :data="activities" @fetch-activities="fetchActivities" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, provide, reactive, ref} from 'vue';
import axios from 'axios';

import EmptyActivity from './partials/EmptyActivity.vue';
import TableLayout from './partials/TableLayout.vue';
import Pagination from 'Components/TablePagination.vue';
import PageTitle from './partials/PageTitle.vue';
import Toast from 'Components/Toast.vue';

export default defineComponent({
  name: 'ActivityComponent',
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    TableLayout,
    Toast,
  },
  props: {
    toast: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const activities = reactive({});

    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

    onMounted(() => {
      if (props.toast.message !== '') {
        toastData.type = props.toast.type;
        toastData.visibility = true;
        toastData.message = props.toast.message;
      }

      setTimeout(() => {
        toastData.visibility = false;
      }, 5000);
    });

    const toastMessage = reactive({
      message: '',
      type: false,
    });

    onMounted(async () => {
      axios.get('/activity/page').then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isEmpty.value = response.data.data.length ? false : true;
      });
    });

    const state = reactive({
      showButtons: false,
    });

    const isEmpty = ref(false);

    const showOrHide = (data = Array) => {
      if (data.length > 0) {
        state.showButtons = true;
      } else {
        state.showButtons = false;
      }
    };

    function fetchActivities(active_page: number) {
      axios.get('/activity/page/' + active_page).then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isEmpty.value = response.data ? false : true;
      });
    }

    provide('toastMessage', toastMessage);

    return { activities, state, isEmpty, showOrHide, fetchActivities, toastData,toastMessage, };
  },
});
</script>

<style lang="scss">
.listing__page {
  min-height: calc(100vh - 60px);
}
</style>
