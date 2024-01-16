<template>
  <div class="text-sm">
    {{
      financeData[0].finance_type
        ? type.financeType[financeData[0].finance_type]
        : translate.missing('finance_type')
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'TransactionFinanceType',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
  },
  setup(props) {
    const translate = new Translate();
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { finance_type: string };
    }
    const financeData = data.value as ArrayObject;
    const type = inject('types');

    return { financeData, type, translate };
  },
});
</script>
