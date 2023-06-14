<template>
  {{
    code[0].transaction_type_code
      ? type.transactionType[code[0].transaction_type_code]
      : language.common_lang.missing.element.replace(
          ':element',
          language.common_lang.code
        )
  }}
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
    const language = window['globalLang'];
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { transaction_type_code: string };
    }
    const code = data.value as ArrayObject;

    const type = inject('types');
    return { code, type, language };
  },
});
</script>
