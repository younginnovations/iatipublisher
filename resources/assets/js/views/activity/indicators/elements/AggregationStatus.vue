<template>
  <tr>
    <td>Aggregation Status</td>
    <td>
      <ConditionalTextDisplay
        success-text="True"
        :condition="parseInt(data)"
        :show-failure-text-as-plain-text="!!data"
        :failure-text="data ? 'False' : 'aggregation status'"
      />
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'IndicatorAggregationStatus',
  components: { ConditionalTextDisplay },
  props: {
    data: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    let { data } = toRefs(props);
    const statusData = data.value;
    return { statusData };
  },
});
</script>
