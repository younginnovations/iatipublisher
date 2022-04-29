<template>
  <div id="activity-listing-page" class="bg-paper px-10 pt-4 pb-[71px]">
    <div id="activity">
      <PageTitle :showButtons="state.showButtons" />

      <!--  If no data then show empty state   -->
      <!--      <EmptyActivity/>-->
      <!--   Else listing view   -->
      <TableLayout @showOrHide="showOrHide" />
      <div class="mt-6">
        <Pagination />
      </div>
      <ToastMessage />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue';

import EmptyActivity from './partials/EmptyActivity.vue';
import TableLayout from './partials/TableLayout.vue';
import Pagination from '../../components/Pagination.vue';
import PageTitle from './partials/PageTitle.vue';
import ToastMessage from '../../components/ToastMessage.vue';
import PopupModal from '../../components/PopupModal.vue';

export default defineComponent({
  name: 'activity-component',
  components: {
    EmptyActivity,
    PageTitle,
    Pagination,
    ToastMessage,
    TableLayout,
    PopupModal,
  },
  setup() {
    const state = reactive({
      showButtons: false,
    });

    const showOrHide = (data = Array) => {
      if (data.length > 0) {
        state.showButtons = true;
      } else {
        state.showButtons = false;
      }
    };

    return { state, showOrHide };
  },
});
</script>
