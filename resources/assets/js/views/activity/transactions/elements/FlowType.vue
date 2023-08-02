<template>
  <div class="text-sm">
    {{
      flowData[0].flow_type
        ? type.flowType[flowData[0].flow_type]
        : translate.missing('flow_type')
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'TransactionFlowType',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
  },
  setup(props) {
    const translate = new Translate();
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { flow_type: string };
    }
    const flowData = data.value as ArrayObject;
    const type = inject('types');
    return { flowData, type, translate };
  },
});
</script>
