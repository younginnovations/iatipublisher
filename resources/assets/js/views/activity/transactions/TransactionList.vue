<template>
  <div class="relative bg-paper px-5 pt-4 pb-[71px] xl:px-10">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      :title="language.common_lang.transaction_list"
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
          <Btn
            :text="
              language.button_lang.add_element.replace(
                ':element',
                language.common_lang.transaction
              )
            "
            icon="plus"
            type="primary"
          />
        </a>
      </div>
    </PageTitle>

    <!-- page content -->
    <div class="iati-list-table text-n-40">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="internal_ref" scope="col">
              <span
                >{{ language.common_lang.internal }}
                {{ language.common_lang.ref }}</span
              >
            </th>
            <th id="transaction_type" scope="col">
              <span
                >{{ language.common_lang.transaction }}
                {{ language.common_lang.type }}</span
              >
            </th>
            <th id="transaction_value" scope="col">
              <span
                >{{ language.common_lang.transaction }}
                {{ language.common_lang.value }}</span
              >
            </th>
            <th id="transaction_date" scope="col">
              <span
                >{{ language.common_lang.transaction }}
                {{ language.common_lang.date }}</span
              >
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
              <span>{{ language.common_lang.action }}</span>
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
                    ? dateFormat(
                        trans.transaction.transaction_date[0].date,
                        'fromNow'
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
          <td colspan="5" class="text-center">
            {{ language.elements_common_lang.transactions }}
            {{ language.common_lang.missing.not_found }}
          </td>
        </tbody>
      </table>
    </div>
    <div class="mt-6">
      <Pagination
        v-if="transactionsData && transactionsData.last_page > 1"
        :data="transactionsData"
        @fetch-activities="fetchListings"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, reactive, onMounted, provide } from 'vue';
import axios from 'axios';

//components
import Btn from 'Components/ButtonComponent.vue';
import Pagination from 'Components/TablePagination.vue';
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/ToastMessage.vue';
import DeleteAction from 'Components/sections/DeleteAction.vue';

//composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';
import { useToggle } from '@vueuse/core';

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
    const language = window['globalLang'];
    const { activity } = toRefs(props);
    const activityId = activity.value.id,
      activityTitle = getActivityTitle(activity.value.title, 'en'),
      activityLink = `/activity/${activityId}`;
    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

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

    const transactionsData = reactive({}) as TransactionInterface;

    onMounted(async () => {
      axios.get(`/activity/${activityId}/transactions/page/1`).then((res) => {
        const response = res.data;
        Object.assign(transactionsData, response.data);
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
      axios
        .get(`/activity/${activityId}/transactions/page/` + active_page)
        .then((res) => {
          const response = res.data;
          Object.assign(transactionsData, response.data);
        });
    }

    // Provide
    provide('parentItemId', activityId);

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: language.activities_lang.your_activities,
        link: '/activities',
      },
      {
        title: activityTitle,
        link: activityLink,
      },
      {
        title: language.common_lang.transaction_list,
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
      language,
    };
  },
});
</script>
