<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <!-- page title -->
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="max-w-sm pb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <div class="flex">
                <a class="font-bold whitespace-nowrap" href="/activities">
                  Your Activities
                </a>
                <span class="mx-4 separator"> / </span>
                <div class="breadcrumb__title">
                  <span class="overflow-hidden breadcrumb__title text-n-30">
                    <a :href="`/activities/${activityId}`">
                      {{ getActivityTitle(activity.title, 'en') ?? 'Untitled' }}
                    </a>
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{ getActivityTitle(activity.title, 'en') ?? 'Untitled' }}
                  </span>
                </div>
                <span class="mx-4 separator"> / </span>

                <div class="breadcrumb__title">
                  <span
                    class="overflow-hidden breadcrumb__title last text-n-30"
                  >
                    Transaction List
                  </span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    Transaction List
                  </span>
                </div>
              </div>
            </nav>
          </div>
          <div class="inline-flex items-center max-w-3xl">
            <div class="mr-3">
              <a :href="'/activities/'+activity.id">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <div class="">
              <h4 class="relative mr-4 font-bold ellipsis__title">
                <span class="overflow-hidden ellipsis__title"
                  >Transaction List</span
                ><span class="ellipsis__title--hover">Transaction List</span>
              </h4>
            </div>
          </div>
        </div>
        <div class="flex flex-col items-end justify-end actions grow">
          <a :href="`/activities/${activityId}/transactions/create`">
            <Btn text="Add Transaction" icon="plus" type="primary" />
          </a>
        </div>
      </div>
    </div>

    <!-- page content -->
    <div class="iati-list-table text-n-40">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="internal_ref" scope="col">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="ascending-arrow" />
                </span>
                <span>Internal Ref</span>
              </a>
            </th>
            <th id="transaction_type" scope="col">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Transaction Type</span>
              </a>
            </th>
            <th id="transaction_value" scope="col">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Transaction Value</span>
              </a>
            </th>
            <th id="transaction_date" scope="col">
              <a
                class="transition duration-500 text-n-50 hover:text-spring-50"
                href="#"
              >
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Transaction Date</span>
              </a>
            </th>
            <th id="status" scope="col">
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
            <th id="action" scope="col">
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
          <tr v-for="(trans, t, index) in transactionsData.data" :key="index">
            <td>
              <a :href="`/activities/${activityId}/transactions/${trans.id}`">
                <span v-if="trans.transaction.reference">{{
                  trans.transaction.reference
                }}</span>
                <span v-else>- - -</span>
              </a>
            </td>
            <td>
              {{
                types.transactionType[
                  trans.transaction.transaction_type[0].transaction_type_code
                ]
              }}
            </td>
            <td class="truncate">{{ trans.transaction.value[0].amount }}</td>
            <td>
              <span v-if="trans.transaction.transaction_date[0].date">
                {{
                  dateFormat(
                    trans.transaction.transaction_date[0].date,
                    'fromNow'
                  )
                }}
              </span>
              <span v-else>- - -</span>
            </td>
            <td><span class="text-spring-50">completed</span></td>
            <td>
              <div class="flex text-n-40">
                <a
                  class="mr-6"
                  :href="`/activities/${trans.activity_id}/transactions/${trans.id}/edit`"
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
      <Pagination :data="transactionsData" @fetch-activities="fetchListings" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, reactive, onMounted } from 'vue';
import Btn from '../../../components/ButtonComponent.vue';
import dateFormat from '../../../composable/dateFormat';
import Pagination from 'Components/TablePagination.vue';
import axios from 'axios';
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'TransactionList',
  components: {
    Btn,
    Pagination,
  },
  props: {
    activity: {
      type: Object,
      required: true,
    },
    transactions: {
      type: Object,
      required: true,
    },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { activity } = toRefs(props);
    const activityId = activity.value.id;
    const transactionsData = reactive({});

    onMounted(async () => {
      axios.get(`/activities/${activityId}/transactions/page/1`).then((res) => {
        const response = res.data;
        Object.assign(transactionsData, response.data);
      });
    });

    function fetchListings(active_page: number) {
      axios
        .get(`/activities/${activityId}/transactions/page/` + active_page)
        .then((res) => {
          const response = res.data;
          Object.assign(transactionsData, response.data);
        });
    }

    return { activityId, dateFormat, transactionsData, getActivityTitle, fetchListings };
  },
});
</script>
