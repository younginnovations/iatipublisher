<template>
  <div class="flex items-end">
    <span class="text-[64px]">{{ value[0].amount }}</span>
    <span class="mb-5">{{ value[0].currency }}</span>
  </div>
  <div>valued at {{ dateFormat(value[0].date) }}</div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import dateFormat from './../../../../composable/dateFormat';

export default defineComponent({
  name: 'TransactionValue',
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
      [index: number]: { amount: string; currency: string; date: Date };
    }
    const value = data.value as ArrayObject;
    return { value, dateFormat };
  },
});
</script>
