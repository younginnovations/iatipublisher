<template>
  <tr>
    <td>Ascending</td>
    <td>
      {{ data? 'True' : 'False' }}
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
    }
  },
});
</script>
