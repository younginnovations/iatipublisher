<template>
  <tr>
    <td>{{ language.common_lang.ascending }}</td>
    <td>
      {{
        parseInt(data)
          ? language.common_lang.true
          : data
          ? language.common_lang.false
          : language.common_lang.missing.default
      }}
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'IndicatorAscending',
  components: {},
  props: {
    data: {
      type: String,
      required: true,
    },
  },
  setup() {
    const language = window['globalLang'];
    return { language };
  },
});
</script>
