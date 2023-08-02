<template>
  <tr>
    <td>{{ translate.commonText('measure') }}</td>
    <td>
      {{ measureData ? measureType[measureData] : translate.missing() }}
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    let { data } = toRefs(props);
    const measureData = data.value;
    return { measureData, translate };
  },
});
</script>
