<template>
  <tr>
    <td>{{ translate.commonText('ascending') }}</td>
    <td>
      {{
        parseInt(data)
          ? translate.commonText('true')
          : data
          ? translate.commonText('false')
          : translate.missingText()
      }}
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'IndicatorAscending',
  components: {},
  props: {
    data: {
      type: String,
      required: true,
    },
  },
  setup() {
    const translate = new Translate();
    return { translate };
  },
});
</script>
