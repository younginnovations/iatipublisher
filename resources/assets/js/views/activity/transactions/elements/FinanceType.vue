<template>
  <div class="text-sm">
    {{
      financeData[0].finance_type
        ? type.financeType[financeData[0].finance_type]
        : ''
    }}
    <span
      v-if="!financeData[0].finance_type"
      class="text-xs italic text-light-gray"
      >N/A</span
    >
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

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
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { finance_type: string };
    }
    const financeData = data.value as ArrayObject;
    const type = inject('types');

    return { financeData, type };
  },
});
</script>
