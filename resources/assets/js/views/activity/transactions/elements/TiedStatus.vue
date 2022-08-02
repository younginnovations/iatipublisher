<template>
  <div>{{ tiedStatusType[tsData[0].tied_status_code] }}</div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'TransactionTiedStatus',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    tiedStatusType: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { tied_status_code: string };
    }
    const tsData = data.value as ArrayObject;
    return { tsData };
  },
});
</script>
