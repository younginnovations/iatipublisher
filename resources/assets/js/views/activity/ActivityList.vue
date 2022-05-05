<template>
  <div id="activity-listing-page" class="bg-paper px-10 pt-4 pb-[71px]">
    <div id="activity">
      <PageTitle :showButtons="state.showButtons" />
      <EmptyActivity v-if="isEmpty"> </EmptyActivity>
      <TableLayout @showOrHide="showOrHide" :data="activities" />
      <div class="mt-6">
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
  props: {
    activities: {
      type: [Object],
      required: true,
    },
    page_count: {
      type: [Number, String],
      required: true,
    },
  },
  setup(props) {
    const activities = reactive({});

    onMounted(async () => {
      axios
        .post('/activity/1')
        .then((res) => {
          const response = res.data;
          Object.assign(activities, response.data);

          if (response.data.total < 2) {
            isEmpty.value = true;
          }
        })
        .catch((error) => {
          const { errors } = error.response.data;
        });
    });

    console.log('here', activities);

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
      console.log(active_page);
      axios
        .post('/activity/' + active_page)
        .then((res) => {
          const response = res.data;
          Object.assign(activities, response.data);
        })
        .catch((error) => {
          const { errors } = error.response.data;
        });
    }

    return { activities, state, isEmpty, showOrHide, props, fetchActivities };
  },
});
</script>
