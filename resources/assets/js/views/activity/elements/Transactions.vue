<template>
  <div
    v-for="(trans, t) in data"
    :key="t"
    class=""
    :class="{ 'mb-4': Number(t) !== data.length - 1 }"
  >
    <div class="mb-4 text-sm font-bold">
      {{
        types.transactionType[
          trans.transaction.transaction_type[0].transaction_type_code
        ] ?? 'Transaction type not available'
      }}
    </div>
    <template v-for="(val, v) in trans.transaction.value" :key="v">
      <div
        class="text-sm description"
        :class="{ 'mb-4': Number(t) !== trans.transaction.value.length - 1 }"
      >
        {{ val.amount ?? 'Value not available' }} {{ val.currency }}
        {{
          dateFormat(val.date, 'MMMM DD, YYYY')
            ? '- valued at' + ' ' + dateFormat(val.date, 'MMMM DD, YYYY')
            : ''
        }}
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';
import dateFormat from 'Composable/dateFormat';

export default defineComponent({
  name: 'ActivityTransactions',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      transactionType: [];
      languages: [];
    }

    const types = inject('types') as Types;

    return { types, dateFormat };
  },
});
</script>
