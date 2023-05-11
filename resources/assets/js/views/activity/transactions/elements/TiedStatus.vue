<template>
  <div class="text-sm">
    {{
      !isEmpty(tsData[0].tied_status_code)
        ? type.tiedStatusType[tsData[0].tied_status_code]
        : 'Tied Status Code Missing'
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import isEmpty from '../../../../composable/helper';

export default defineComponent({
  name: 'TransactionTiedStatus',
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
      [index: number]: { tied_status_code: string };
    }
    const tsData = data.value as ArrayObject;
    const type = inject('types');
    return { tsData, type };
  },
  methods: { isEmpty },
});
</script>
