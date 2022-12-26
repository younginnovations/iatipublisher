<template>
  <div class="text-sm">
    {{
      code[0].disbursement_channel_code
        ? type.disbursementChannel[code[0].disbursement_channel_code]
        : language.common_lang.missing.element.replace(
            ':element',
            language.common_lang.disbursement_channel_code
          )
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

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
    const language = window['globalLang'];
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { disbursement_channel_code: string };
    }
    const code = data.value as ArrayObject;
    const type = inject('types');
    return { code, type, language };
  },
});
</script>
