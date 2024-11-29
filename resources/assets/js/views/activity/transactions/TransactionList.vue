<template>
  <div class="relative bg-paper px-5 pb-[71px] pt-4 xl:px-10">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      title="Transaction List"
      :back-link="activityLink"
    >
      <div class="flex items-center space-x-3">
        <Toast
          v-if="toastData.visibility"
          :message="toastData.message"
          :type="toastData.type"
          class="mr-3"
        />
        <a :href="`${activityLink}/transaction/create`">
          <Btn text="Add Transaction" icon="plus" type="primary" />
        </a>
      </div>
    </PageTitle>

    <FilteringPills
      v-if="showPills"
      :pills="titles"
      @filter-by="handleFilter"
    />

    <!-- page content -->
    <div class="iati-list-table text-n-40">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="internal_ref" scope="col">
              <span>Internal Ref</span>
            </th>
            <th
              id="transaction_type"
              scope="col"
              class="cursor-pointer transition-all duration-300 hover:text-spring-50"
              :class="{ 'text-spring-50': currentlySortedBy === 'type' }"
              @click="sortByOrder('type', true)"
            >
              <div class="flex items-center">
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      columnDirections.type === 'asc'
                        ? 'ascending'
                        : 'descending'
                    }-arrow`"
                  />
                </span>
                <span>Transaction Type</span>
              </div>
            </th>
            <th
              id="transaction_value"
              scope="col"
              class="cursor-pointer transition-all duration-300 hover:text-spring-50"
              :class="{ 'text-spring-50': currentlySortedBy === 'value' }"
              @click="sortByOrder('value', true)"
            >
              <div class="flex items-center">
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      columnDirections.value === 'asc'
                        ? 'ascending'
                        : 'descending'
                    }-arrow`"
                  />
                </span>
                <span>Transaction Value</span>
              </div>
            </th>
            <th
              id="transaction_date"
              scope="col"
              class="cursor-pointer transition-all duration-300 hover:text-spring-50"
              :class="{ 'text-spring-50': currentlySortedBy === 'date' }"
              @click="sortByOrder('date', true)"
            >
              <div class="flex items-center">
                <span class="sorting-indicator">
                  <svg-vue
                    :icon="`${
                      columnDirections.date === 'asc'
                        ? 'ascending'
                        : 'descending'
                    }-arrow`"
                  />
                </span>
                <span>Transaction Date</span>
              </div>
            </th>
            <!--            <th id="status" scope="col">-->
            <!--              <a-->
            <!--                class="transition duration-500 text-n-50 hover:text-spring-50"-->
            <!--                href="#"-->
            <!--              >-->
            <!--                <span class="sorting-indicator descending">-->
            <!--                  <svg-vue icon="descending-arrow" />-->
            <!--                </span>-->
            <!--                <span>Status</span>-->
            <!--              </a>-->
            <!--            </th>-->
            <th id="action" scope="col">
              <span>Action</span>
            </th>
          </tr>
        </thead>
        <tbody v-if="transactionsData.data && transactionsData.data.length > 0">
          <tr v-for="(trans, t, index) in transactionsData.data" :key="index">
            <td
              class="cursor-pointer"
              @click="handleNavigate(`${activityLink}/transaction/${trans.id}`)"
            >
              <div class="ellipsis relative">
                <a :href="`${activityLink}/transaction/${trans.id}`">
                  <span>{{
                    trans.transaction.reference &&
                    trans.transaction.reference !== ''
                      ? trans.transaction.reference
                      : '- - -'
                  }}</span>
                </a>
                <div class="w-52">
                  <span class="ellipsis__title--hover">{{
                    trans.transaction.reference &&
                    trans.transaction.reference !== ''
                      ? trans.transaction.reference
                      : '- - -'
                  }}</span>
                </div>
              </div>
            </td>
            <td
              class="cursor-pointer"
              @click="handleNavigate(`${activityLink}/transaction/${trans.id}`)"
            >
              {{
                types.transactionType[
                  trans.transaction.transaction_type[0].transaction_type_code
                ] ?? '- - -'
              }}
            </td>
            <td
              class="cursor-pointer truncate"
              @click="handleNavigate(`${activityLink}/transaction/${trans.id}`)"
            >
              {{
                trans.transaction.value[0].amount
                  ? Number(trans.transaction.value[0].amount).toLocaleString()
                  : '- - -'
              }}
            </td>
            <td
              class="cursor-pointer"
              @click="handleNavigate(`${activityLink}/transaction/${trans.id}`)"
            >
              <span>
                {{
                  trans.transaction.transaction_date[0].date
                    ? moment(trans.transaction.transaction_date[0].date).format(
                        'YYYY-MM-DD'
                      )
                    : '- - -'
                }}
              </span>
            </td>
            <!--            <td><span class="text-spring-50">completed</span></td>-->
            <td>
              <div class="flex text-n-40">
                <a
                  class="mr-6"
                  :href="`${activityLink}/transaction/${trans.id}/edit`"
                >
                  <svg-vue icon="edit" class="text-xl"></svg-vue>
                </a>
                <DeleteAction :item-id="trans.id" item-type="transaction" />
              </div>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <td colspan="5" class="text-center">Transactions not found</td>
        </tbody>
      </table>
    </div>
    <div class="mt-6">
      <Pagination
        v-if="transactionsData && transactionsData.last_page > 1"
        :data="transactionsData"
        :reset="isPaginationReset"
        @fetch-activities="fetchListings"
      />
    </div>
  </div>
</template>

<script lang="ts">
import {
  ref,
  defineComponent,
  toRefs,
  reactive,
  onMounted,
  provide,
  computed,
} from 'vue';
import axios from 'axios';

//components
import Btn from 'Components/ButtonComponent.vue';
import Pagination from 'Components/TablePagination.vue';
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/ToastMessage.vue';
import DeleteAction from 'Components/sections/DeleteAction.vue';
import FilteringPills from 'Components/FilteringPills.vue';

//composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';
import { useToggle } from '@vueuse/core';
import moment from 'moment';

// toggle state for modal popup
let [deleteValue, deleteToggle] = useToggle();

export default defineComponent({
  name: 'TransactionList',
  components: {
    Btn,
    Pagination,
    PageTitle,
    Toast,
    DeleteAction,
    FilteringPills,
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
    toast: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { activity } = toRefs(props);
    const activityId = activity.value.id,
      activityTitle = getActivityTitle(activity.value.title, 'en'),
      activityLink = `/activity/${activityId}`;
    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });
    const searchTerm = ref('all');
    const currentlySortedBy = ref('');
    const columnDirections = ref({
      type: 'ascending',
      value: 'ascending',
      date: 'ascending',
    });
    const activePage = ref(1);
    const showPills = ref(false);
    const isPaginationReset = ref(false);

    interface TransactionInterface {
      last_page: number;
      data: {
        id: number;
        transaction: {
          reference: string;
          transaction_type: {
            transaction_type_code: string;
          }[];
          value: {
            amount: string;
          }[];
          transaction_date: {
            date: Date;
          }[];
        };
        activity_id: number;
      }[];
    }

    interface TitleInterface {
      title: string;
      searchTerm: string;
      count: number;
    }

    const transactionsData = reactive({}) as TransactionInterface;

    const countData = ref({
      all: 0,
      incoming_funds: 0,
      outgoing_commitment: 0,
      disbursement: 0,
      expenditure: 0,
      others: 0,
    });

    const titles = computed<TitleInterface[]>(() => [
      { title: 'All', searchTerm: 'all', count: countData.value.all },
      {
        title: 'Incoming Funds',
        searchTerm: 'incoming_funds',
        count: countData.value.incoming_funds,
      },
      {
        title: 'Outgoing Commitment',
        searchTerm: 'outgoing_commitment',
        count: countData.value.outgoing_commitment,
      },
      {
        title: 'Disbursement',
        searchTerm: 'disbursement',
        count: countData.value.disbursement,
      },
      {
        title: 'Expenditure',
        searchTerm: 'expenditure',
        count: countData.value.expenditure,
      },
      { title: 'Others', searchTerm: 'others', count: countData.value.others },
    ]);

    const fetchTransactions = async (
      activityId: string,
      searchTerm: string,
      order: string | undefined,
      direction: string
    ) => {
      try {
        const params = new URLSearchParams({
          filterBy: searchTerm,
          direction,
          ...(order && { orderBy: order }),
        });
        const response = await axios.get(
          `/activity/${activityId}/transactions/page/${
            activePage.value
          }?${params.toString()}`
        );
        return response.data.data;
      } catch (error) {
        console.error('Error fetching transactions:', error);
        throw error;
      }
    };

    const sortingDirection = (type: string) => {
      columnDirections.value[type] =
        columnDirections.value[type] === 'asc' ? 'desc' : 'asc';
    };

    const sortByOrder = async (order: string, sort?: boolean) => {
      currentlySortedBy.value = order;

      if (sort) {
        sortingDirection(order);
      }

      try {
        const direction = order ? columnDirections.value[order] : 'asc';
        const data = await fetchTransactions(
          activityId,
          searchTerm.value,
          order,
          direction
        );
        Object.assign(transactionsData, data.transactions);
      } catch (error) {
        console.log('Error', error);
      }
    };

    const handleFilter = (filterType: string) => {
      searchTerm.value = filterType;
      sortByOrder(currentlySortedBy.value);
      resetPagination();
    };

    const resetPagination = () => {
      activePage.value = 1;
      isPaginationReset.value = true;
      setTimeout(() => {
        isPaginationReset.value = false;
      }, 100);
    };

    onMounted(async () => {
      await axios
        .get(`/activity/${activityId}/transactions/page/1`)
        .then((res) => {
          const response = res.data;
          Object.assign(transactionsData, response.data.transactions);
          countData.value = response.data.stats;
          showPills.value = true;
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

    function handleNavigate(path) {
      window.location.href = path;
    }

    function fetchListings(active_page: number) {
      activePage.value = active_page;
      const params = new URLSearchParams({
        filterBy: searchTerm.value,
        direction: currentlySortedBy.value
          ? columnDirections.value[currentlySortedBy.value]
          : 'asc',
        ...(currentlySortedBy.value && { orderBy: currentlySortedBy.value }),
      });

      axios
        .get(
          `/activity/${activityId}/transactions/page/${active_page}?${params.toString()}`
        )
        .then((res) => {
          const response = res.data;
          Object.assign(transactionsData, response.data.transactions);
        })
        .catch((error) => {
          console.error('Error fetching paginated data:', error);
        });
    }

    // Provide
    provide('parentItemId', activityId);

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: 'Your Activities',
        link: '/activities',
      },
      {
        title: activityTitle,
        link: activityLink,
      },
      {
        title: 'Transaction List',
        link: '',
      },
    ];

    return {
      breadcrumbData,
      activityLink,
      dateFormat,
      transactionsData,
      getActivityTitle,
      fetchListings,
      toastData,
      deleteValue,
      deleteToggle,
      handleNavigate,
      sortingDirection,
      sortByOrder,
      titles,
      handleFilter,
      currentlySortedBy,
      columnDirections,
      showPills,
      isPaginationReset,
    };
  },
  computed: {
    moment() {
      return moment;
    },
  },
});
</script>
