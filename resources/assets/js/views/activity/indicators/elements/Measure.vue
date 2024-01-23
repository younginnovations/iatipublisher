<template>
  <tr>
    <td>Measure</td>
    <td>
      <ConditionalTextDisplay
        :success-text="measureType[measureData]"
        :condition="measureData"
        failure-text="measure"
      />
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'IndicatorMeasure',
  components: { ConditionalTextDisplay },
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
