<template>
  <div
    id="activity-listing-page"
    class="listing__page bg-paper px-10 pt-4 pb-[71px]"
  >
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

<style lang="scss">
.listing__page {
  height: calc(100vh - 60px);
}
</style>
