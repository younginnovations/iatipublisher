<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <PageTitle
      :breadcrumb-data="breadcrumbData"
      :title="`${transactionData.reference ?? 'Untitled'} - Transaction detail`"
      :back-link="`${activityLink}/transaction`"
    >
      <div class="mb-3">
        <Toast
          v-if="toastData.visibility"
          :message="toastData.message"
          :type="toastData.type"
        />
      </div>
      <Btn
        text="Edit Transaction"
        :link="`${activityLink}/transaction/${transaction.id}/edit`"
        icon="edit"
      />
    </PageTitle>

    <div class="activities">
      <aside class="activities__sidebar">
        <Notes class="mb-4" />
        <div
          class="sticky top-0 px-6 py-4 rounded-lg indicator bg-eggshell text-n-50"
        >
          <ul class="text-sm font-bold leading-relaxed">
            <li v-for="(rData, r, ri) in transactionData" :key="ri">
              <a v-smooth-scroll :href="`#${String(r)}`" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                {{ r }}
              </a>
            </li>
          </ul>
        </div>
      </aside>
      <div class="activities__content">
        <div></div>
        <div class="flex flex-wrap -mx-3 -mt-3 activities__content--elements">
          <template v-for="(post, key) in transactionData" :key="key">
            <TransactionElement
              :data="post"
              :element-name="key.toString()"
              :edit-url="`/activity/${transaction.activity_id}/transaction/${transaction.id}`"
              :width="
                key.toString() === 'value' ||
                key.toString() === 'transaction_type' ||
                key.toString() === 'transaction_date' ||
                key.toString() === 'reference' ||
                key.toString() === 'disbursement_channel' ||
                key.toString() === 'humanitarian'
                  ? ''
                  : 'full'
              "
              :types="types"
            />
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, onMounted, reactive } from 'vue';
//components
import Btn from 'Components/buttons/Link.vue';
import PageTitle from 'Components/sections/PageTitle.vue';
import Toast from 'Components/Toast.vue';
//composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';
import Notes from 'Activity/partials/ElementsNote.vue';
import TransactionElement from './TransactionElement.vue';

export default defineComponent({
  name: 'TransactionDetail',
  components: {
    Notes,
    TransactionElement,
    Btn,
    PageTitle,
    Toast,
  },
  props: {
    activity: {
      type: Object,
      required: true,
    },
    transaction: {
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
    const { activity, transaction } = toRefs(props);
    const linkClasses =
      'flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-relaxed mb-2 shadow-default';

    const toastData = reactive({
      visibility: false,
      message: '',
      type: true,
    });

    // titles
    const transactionData = transaction.value.transaction;

    const activityId = activity.value.id,
      activityTitle = getActivityTitle(activity.value.title, 'en'),
      activityLink = `/activity/${activityId}`,
      transactionLink = `${activityLink}/transaction/${transaction.value.id}`;

    /**
     * Breadcrumb data
     */
    const breadcrumbData = [
      {
        title: 'Your Activities',
        link: '/activity',
      },
      {
        title: activityTitle,
        link: activityLink,
      },
      {
        title: 'Transaction',
        link: '',
      },
    ];

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

    return {
      activityTitle,
      dateFormat,
      transactionData,
      linkClasses,
      breadcrumbData,
      activityLink,
      transactionLink,
      toastData,
    };
  },
});
</script>
