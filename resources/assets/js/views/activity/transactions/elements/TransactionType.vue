<template>
  {{
    code[0].transaction_type_code
      ? type.transactionType[code[0].transaction_type_code]
      : ''
  }}
  <span
    v-if="!code[0].transaction_type_code"
    class="text-xs italic text-light-gray"
    >N/A</span
  >
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

export default defineComponent({
  name: 'TransactionType',
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
      [index: number]: { transaction_type_code: string };
    }
    const code = data.value as ArrayObject;

    const type = inject('types');
    return { code, type };
  },
});
</script>
