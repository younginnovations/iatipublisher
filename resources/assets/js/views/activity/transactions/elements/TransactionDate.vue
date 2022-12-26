<template>
  {{
    date[0].date ? dateFormat(date[0].date) : language.common_lang.missing.date
  }}
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import dateFormat from './../../../../composable/dateFormat';

export default defineComponent({
  name: 'TransactionDate',
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
      [index: number]: { date: Date };
    }
    const date = data.value as ArrayObject;
    return { date, dateFormat, language };
  },
});
</script>
