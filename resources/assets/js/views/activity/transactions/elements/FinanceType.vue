<template>
  <div class="text-sm">
    {{
      !isEmpty(financeData[0].finance_type)
        ? type.financeType[financeData[0].finance_type]
        : 'Finance Type Missing'
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import isEmpty from '../../../../composable/helper';

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
  methods: { isEmpty },
});
</script>
