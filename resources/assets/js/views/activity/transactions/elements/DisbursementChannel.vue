<template>
  <div class="text-sm">
    {{
      !isEmpty(code[0].disbursement_channel_code)
        ? type.disbursementChannel[code[0].disbursement_channel_code]
        : 'Disbursement Channel Code Missing'
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import isEmpty from '../../../../composable/helper';

export default defineComponent({
  name: 'TransactionDisbursementChannel',
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
      [index: number]: { disbursement_channel_code: string };
    }
    const code = data.value as ArrayObject;
    const type = inject('types');
    return { code, type };
  },
  methods: { isEmpty },
});
</script>
