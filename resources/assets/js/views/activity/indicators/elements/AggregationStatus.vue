<template>
  <tr>
    <td>{{ translate.commonText('aggregation_status') }}</td>
    <td class="capitalize">
      {{
        parseInt(data)
          ? translate.commonText('true')
          : data
          ? translate.commonText('false')
          : translate.missing()
      }}
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    let { data } = toRefs(props);
    const statusData = data.value;
    return { statusData, translate };
  },
});
</script>
