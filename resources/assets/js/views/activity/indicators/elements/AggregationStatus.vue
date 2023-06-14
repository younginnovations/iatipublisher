<template>
  <tr>
    <td>{{ language.common_lang.aggregation_status }}</td>
    <td class="capitalize">
      {{
        parseInt(data)
          ? 'True'
          : data
          ? language.common_lang.false
          : language.common_lang.missing.default
      }}
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'IndicatorAggregationStatus',
  components: {},
  props: {
    data: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const language = window['globalLang'];
    let { data } = toRefs(props);
    const statusData = data.value;
    return { statusData, language };
  },
});
</script>
