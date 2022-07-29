<template>
  {{ flowData[0].flow_type ? flowType[flowData[0].flow_type] : 'Flow Type Not Available' }}
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'TransactionFlowType',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    flowType: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { flow_type: string };
    }
    const flowData = data.value as ArrayObject;
    return { flowData };
  },
});
</script>
