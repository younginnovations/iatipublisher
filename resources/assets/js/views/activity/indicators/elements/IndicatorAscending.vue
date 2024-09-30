<template>
  <tr>
    <td>Ascending</td>
    <td>
      {{ parseInt(data) ? 'True' : data ? 'False' : '' }}
      <span
        v-if="!parseInt(data) && !data"
        class="text-xs italic text-light-gray"
        >N/A</span
      >
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
});
</script>
