<template>
  {{ code[0].disbursement_channel_code?types[code[0].disbursement_channel_code]: 'Disbursement Channel Code Not Available' }}
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'TransactionDisbursementChannel',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { disbursement_channel_code: string };
    }
    const code = data.value as ArrayObject;
    return { code };
  },
});
</script>
