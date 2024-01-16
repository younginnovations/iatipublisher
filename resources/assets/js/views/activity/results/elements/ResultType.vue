<template>
  <div class="text-sm">
    {{ type[typeData] ?? translate.missing() }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ResultType',
  props: {
    data: {
      type: Number,
      required: true,
    },
    type: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const translate = new Translate();
    let { data } = toRefs(props);
    const typeData = data.value;
    return { typeData, translate };
  },
});
</script>
