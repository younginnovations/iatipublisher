<template>
  <tr>
    <td>{{ language.common_lang.measure }}</td>
    <td>
      {{
        measureData
          ? measureType[measureData]
          : language.common_lang.missing.default
      }}
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'IndicatorMeasure',
  components: {},
  props: {
    data: {
      type: String,
      required: true,
    },
    measureType: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const language = window['globalLang'];
    let { data } = toRefs(props);
    const measureData = data.value;
    return { measureData, language };
  },
});
</script>
