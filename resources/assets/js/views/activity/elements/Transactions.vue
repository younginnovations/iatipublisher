<template>
  <div
    v-for="(trans, t) in data"
    :key="t"
    class=""
    :class="{ 'mb-4': Number(t) !== data.length - 1 }"
  >
    <div class="mb-4 inline-flex text-sm font-bold">
      {{
        types.transactionType[
          trans.transaction.transaction_type[0].transaction_type_code
        ] ?? translate.missingText('transaction_type')
      }}
      <div class="ml-2">
        <Btn
          :text="translate.button('edit')"
          icon="edit"
          :link="`/activity/${trans.activity_id}/transaction/${trans.id}/edit`"
        />
      </div>
    </div>
    <template v-for="(val, v) in trans.transaction.value" :key="v">
      <div
        class="description text-sm"
        :class="{ 'mb-4': Number(t) !== trans.transaction.value.length - 1 }"
      >
        {{
          val.amount
            ? Number(val.amount).toLocaleString()
            : translate.missingText('element', 'common.value')
        }}
        {{ val.currency }}
        {{
          dateFormat(val.date, 'MMMM DD, YYYY')
            ? `- ${translate.commonText('valued_at').toLowerCase()}` +
              ' ' +
              dateFormat(val.date, 'MMMM DD, YYYY')
            : ''
        }}
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';
import dateFormat from 'Composable/dateFormat';
import Btn from 'Components/buttons/Link.vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ActivityTransactions',
  components: {
    Btn,
  },
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

    const translate = new Translate();
    const types = inject('types') as Types;

    return { types, dateFormat, translate };
  },
});
</script>
