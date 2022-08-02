<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="breadcrumb">
              <p>
                <a href="/activities" class="font-bold"> Your Activities </a>
                <span class="mx-4 separator"> / </span>
                <span class="text-n-30">
                  <a :href="`/activities/${activity.id}`">{{
                    activityTitle
                  }}</a>
                </span>
                <span class="mx-4 separator"> / </span>
                <span class="last text-n-30">{{
                  transactionData.reference??'Untitled'
                }}</span>
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a :href="`/activities/${activity.id}`">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h4 class="mr-4 font-bold">
              {{ transactionData.reference??'Untitled' }} - Transaction detail
            </h4>
          </div>
        </div>
      </div>
    </div>

    <div class="activities">
      <aside class="activities__sidebar">
        <Notes class="mb-4" />
        <div class="px-6 py-4 rounded-lg indicator bg-eggshell text-n-50">
          <ul class="text-sm font-bold leading-relaxed">
            <li v-for="(rData, r, ri) in transactionData" :key="ri">
              <a v-smooth-scroll :href="`#${r}`" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                {{ r }}
              </a>
            </li>
          </ul>
        </div>
      </aside>
      <div class="activities__content">
        <div class="flex justify-end mb-11">
          <a
            :href="`/activities/${transaction.activity_id}/transactions/${transaction.id}/edit`"
            class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit Transaction</span>
          </a>
        </div>
        <div class="flex flex-wrap -mx-3 -mt-3 activities__content--elements">
          <template v-for="(post, key) in transactionData" :key="key">
            <TransactionElement
              :data="post"
              :element-name="key.toString()"
              :edit-url="`/activities/${transaction.activity_id}/result/${transaction.id}`"
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
import { defineComponent, toRefs } from 'vue';
import dateFormat from '../../../composable/dateFormat';
import getActivityTitle from './../../../composable/title';
import Notes from './../partials/ElementsNote.vue';
import TransactionElement from './../transactions/TransactionElement.vue';

export default defineComponent({
  name: 'TransactionDetail',
  components: {
    Notes,
    TransactionElement,
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
  },
  setup(props) {
    const { activity, transaction } = toRefs(props);
    const linkClasses =
      'flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-relaxed mb-2 shadow-default';

    // titles
    const activityTitle = getActivityTitle(activity.value.title, 'en');
    const transactionData = transaction.value.transaction;

    return { activityTitle, dateFormat, transactionData, linkClasses };
  },
});
</script>
