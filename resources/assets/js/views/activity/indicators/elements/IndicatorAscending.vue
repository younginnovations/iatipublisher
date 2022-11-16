<template>
  <tr>
    <td>Ascending</td>
    <td>
      {{ parseInt(data)? 'True' : (data?'False':'Missing') }}
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
