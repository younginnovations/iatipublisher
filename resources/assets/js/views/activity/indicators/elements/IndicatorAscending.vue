<template>
  <tr>
    <td>Ascending</td>
    <td>
      <ConditionalTextDisplay
        success-text="True"
        :condition="parseInt(data)"
        :show-failure-text-as-plain-text="!!data"
        :failure-text="data ? 'False' : 'ascending'"
      />
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'IndicatorAscending',
  components: { ConditionalTextDisplay },
  props: {
    data: {
      type: String,
      required: true,
    },
  },
});
</script>
