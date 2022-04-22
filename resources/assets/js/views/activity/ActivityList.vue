<template>
  <div id="activity-listing-page" class="bg-paper px-10 pt-4 pb-[71px]">
    <div id="activity">
      <PageTitle :showButtons="state.showButtons" />
      <EmptyActivity v-if="isEmpty"> </EmptyActivity>
      <TableLayout @showOrHide="showOrHide" />
      <div class="mt-6">
        <Pagination />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';

import EmptyActivity from './partials/EmptyActivity.vue';
import TableLayout from './partials/TableLayout.vue';
import Pagination from '../../components/Pagination.vue';
import PageTitle from './partials/PageTitle.vue';

export default defineComponent({
  name: 'activity-component',
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    TableLayout,
  },
  setup() {
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

    return { state, isEmpty, showOrHide };
  },
});
</script>
