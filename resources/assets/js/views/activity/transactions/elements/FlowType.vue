<template>
  <div class="text-sm">
    {{
      flowData[0].flow_type
        ? type.flowType[flowData[0].flow_type]
        : 'Flow Type Missing'
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

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
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { flow_type: string };
    }
    const flowData = data.value as ArrayObject;
    const type = inject('types');
    return { flowData, type };
  },
});
</script>
