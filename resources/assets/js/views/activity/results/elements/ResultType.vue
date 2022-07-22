<template>
  <div class="text-sm">{{ type[typeData] }}</div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

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
    let { data } = toRefs(props);
    const typeData = data.value;
    return { typeData };
  },
});
</script>
