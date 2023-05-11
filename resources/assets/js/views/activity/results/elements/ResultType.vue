<template>
  <div class="text-sm">
    {{ isEmpty(type[typeData]) ? 'Missing' : type[typeData] }}
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import isEmpty from '../../../../composable/helper';

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
  methods: { isEmpty },
});
</script>
