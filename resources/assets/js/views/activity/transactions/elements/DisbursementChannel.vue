<template>
  <div class="text-sm">
    {{
      code[0].disbursement_channel_code
        ? type.disbursementChannel[code[0].disbursement_channel_code]
        : translate.missing('disbursement_channel_code')
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { disbursement_channel_code: string };
    }
    const code = data.value as ArrayObject;
    const type = inject('types');
    return { code, type, translate };
  },
});
</script>
