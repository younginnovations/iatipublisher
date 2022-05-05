<template>
  <div id="activity-listing-page" class="bg-paper px-10 pt-4 pb-[71px]">
    <div id="activity">
      <PageTitle :showButtons="state.showButtons" />
      <EmptyActivity v-if="isEmpty"> </EmptyActivity>
      <TableLayout
        v-if="!isEmpty"
        @showOrHide="showOrHide"
        :data="activities"
      />
      <div class="mt-6" v-if="!isEmpty">
        <Pagination
          :page_count="activities.last_page"
          :current_page="activities.current_page"
          @fetchActivities="fetchActivities"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref, onMounted } from 'vue';
import axios from 'axios';

import EmptyActivity from './partials/EmptyActivity.vue';
import TableLayout from './partials/TableLayout.vue';
import Pagination from '../../components/Pagination.vue';
import PageTitle from './partials/PageTitle.vue';
import PopupModal from '../../components/PopupModal.vue';

export default defineComponent({
  name: 'activity-component',
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    TableLayout,
    PopupModal,
  },
  setup() {
    const activities = reactive({});

    onMounted(async () => {
      axios
        .get('/activity/page')
        .then((res) => {
          const response = res.data;
          Object.assign(activities, response.data);
          isEmpty.value = response.data ? false : true;
        })
        .catch((error) => {
          const { errors } = error.response.data;
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
      axios
        .get('/activity/page/' + active_page)
        .then((res) => {
          const response = res.data;
          Object.assign(activities, response.data);
          isEmpty.value = response.data ? false : true;
        })
        .catch((error) => {
          const { errors } = error.response.data;
        });
    }

    return { activities, state, isEmpty, showOrHide, fetchActivities };
  },
});
</script>
