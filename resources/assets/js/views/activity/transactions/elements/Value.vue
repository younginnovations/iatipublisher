<template>
  <div class="flex items-end overflow-x-auto">
    <span
      :class="{
        'text-[64px]': value[0].amount,
      }"
    >
      {{
        value[0].amount
          ? Number(value[0].amount).toLocaleString()
          : "Amount Missing"
      }}
    </span>
    <span v-if="value[0].amount" class="mb-5">{{ value[0].currency }}</span>
  </div>
  <div v-if="value[0].amount" class="text-sm">
    {{ value[0].date ? `valued at ${dateFormat(value[0].date)}` : "" }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from "vue";
import dateFormat from "./../../../../composable/dateFormat";

export default defineComponent({
  name: "TransactionValue",
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
