<template>
  {{ financeType[financeData[0].finance_type] }}
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'TransactionFinanceType',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    financeType: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { finance_type: string };
    }
    const financeData = data.value as ArrayObject;
    return { financeData };
  },
});
</script>
