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
          : translate.missing('the_amount')
      }}
    </span>
    <span v-if="value[0].amount" class="mb-5">{{ value[0].currency }}</span>
  </div>
  <div v-if="value[0].amount" class="text-sm">
    {{
      value[0].date
        ? `${translate.commonText('valued_at').toLowerCase()} ${dateFormat(
            value[0].date
          )}`
        : ''
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import dateFormat from './../../../../composable/dateFormat';
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { amount: string; currency: string; date: Date };
    }
    const value = data.value as ArrayObject;
    return { value, dateFormat, translate };
  },
});
</script>
