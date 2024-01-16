<template>
  <div class="text-sm">
    {{
      tsData[0].tied_status_code
        ? type.tiedStatusType[tsData[0].tied_status_code]
        : translate.missing('tied_status_code')
    }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: { tied_status_code: string };
    }
    const tsData = data.value as ArrayObject;
    const type = inject('types');
    return { tsData, type, translate };
  },
});
</script>
