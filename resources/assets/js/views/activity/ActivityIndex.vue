<template>
  <div
    id="activity-listing-page"
    class="page-height bg-paper px-5 pt-4 pb-[71px] xl:px-10"
  >
    <div id="activity">
      <Loader v-if="isLoading"></Loader>
      <PageTitle />
      <div class="overflow-hidden" :class="{ 'bg-white': isEmpty }">
        <ErrorMessage :is-empty="isEmpty"></ErrorMessage>
        <EmptyActivity v-if="isEmpty" />
        <TableLayout v-if="!isEmpty" :data="activities" @show-or-hide="showOrHide" />
        <div v-if="!isEmpty" class="mt-6">
          <Pagination
            v-if="activities && activities.last_page > 1"
            :data="activities"
            @fetch-activities="fetchActivities"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, provide, reactive, ref, watch } from "vue";
import { watchIgnorable } from "@vueuse/core";
import axios from "axios";

import EmptyActivity from "./partials/EmptyActivity.vue";
import TableLayout from "./partials/TableLayout.vue";
import Pagination from "Components/TablePagination.vue";
import PageTitle from "./partials/PageTitle.vue";
import Loader from "Components/Loader.vue";
import ErrorMessage from "Components/ErrorMessage.vue";

export default defineComponent({
  name: "ActivityComponent",
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    TableLayout,
    Loader,
    ErrorMessage,
  },
  props: {
    toast: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    interface ActivitiesInterface {
      last_page: number;
    }
    const activities = reactive({}) as ActivitiesInterface;
    const isLoading = ref(true);
    const currentURL = window.location.href;
    let endpoint = "";
    let showEmptyTemplate = false;

    if (currentURL.includes("?")) {
      const queryString = window.location.search;
      endpoint = `/activities/page${queryString}`;
    } else {
      endpoint = `/activities/page`;
      showEmptyTemplate = true;
    }

    //for session message
    const toastData = reactive({
      visibility: false,
      message: "",
      type: true,
    });

    // for publish button
    const toastMessage = reactive({
      message: "",
      type: false,
    });

    onMounted(() => {
      if (props.toast.message !== "") {
        toastData.type = props.toast.type;
        toastData.visibility = true;
        toastData.message = props.toast.message;
      }

      setTimeout(() => {
        toastData.visibility = false;
      }, 5000);
    });

    onMounted(async () => {
      axios.get(endpoint).then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isLoading.value = false;

        if (showEmptyTemplate) {
          isEmpty.value = !response.data.data.length;
        }
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
      let queryString = "";
      if (currentURL.includes("?")) {
        queryString = window.location.search;
      }
      axios.get("/activities/page/" + active_page + queryString).then((res) => {
        const response = res.data;
        Object.assign(activities, response.data);
        isEmpty.value = !response.data;
      });
    }

    const { ignoreUpdates } = watchIgnorable(toastData, () => undefined, {
      flush: "sync",
    });
    watch(
      () => toastData.visibility,
      () => {
        setTimeout(() => {
          toastData.visibility = false;
          ignoreToastUpdate();
        }, 2000);
      }
    );

    const ignoreToastUpdate = () => {
      ignoreUpdates(() => {
        toastData.message = "";
      });
    };

    provide("toastMessage", toastMessage);
    provide("toastData", toastData);

    return {
      activities,
      state,
      isEmpty,
      isLoading,
      showOrHide,
      fetchActivities,
      toastData,
      toastMessage,
    };
  },
});
</script>

<style lang="scss">
.page-height {
  min-height: calc(100vh - 60px);
}
</style>
