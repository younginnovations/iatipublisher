<template>
  <tr>
    <td>Measure</td>
    <td>
      {{ measureData ? measureType[measureData] : 'Not Available' }}
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
    let { data } = toRefs(props);
    const measureData = data.value;
    return { measureData };
  },
});
</script>
