<template>
  <div class="text-sm">
    {{ type[typeData] ?? language.common_lang.missing.default }}
  </div>
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
    const language = window['globalLang'];
    let { data } = toRefs(props);
    const typeData = data.value;
    return { typeData, language };
  },
});
</script>
