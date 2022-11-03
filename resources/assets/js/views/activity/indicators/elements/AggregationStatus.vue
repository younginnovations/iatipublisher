<template>
  <tr>
    <td>Aggregation Status</td>
    <td class="capitalize">
      {{ parseInt(data) ? 'True' : data ? 'False' : 'Missing' }}
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
    let { data } = toRefs(props);
    const statusData = data.value;
    return { statusData };
  },
});
</script>
