<template>
  {{
    code[0].transaction_type_code
      ? type.transactionType[code[0].transaction_type_code]
      : translate.missingText('code')
  }}
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { transaction_type_code: string };
    }
    const code = data.value as ArrayObject;

    const type = inject('types');
    return { code, type, translate };
  },
});
</script>
