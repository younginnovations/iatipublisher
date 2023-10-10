<template>
  <div
    v-for="(post, i) in tdData[0].narrative"
    :key="i"
    class="title-content"
    :class="{
      'mb-4': i !== Object.keys(tdData[0].narrative).length - 1,
    }"
  >
    <div class="language mb-1.5">
      (Language:
      <ConditionalTextDisplay
        :success-text="type[post.language]"
        :condition="type[post.language]"
      />)
    </div>
    <div class="w-[800px] max-w-[80%] overflow-x-hidden text-ellipsis text-sm">
      {{ post.narrative }}
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'ResultTD',
  components: { ConditionalTextDisplay },
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    type: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    /**
     * Typescript interface
     */
    interface NarrativeArray {
      [index: number]: { language: string; narrative: string };
    }

    interface Narratives {
      [index: number]: {
        narrative: NarrativeArray;
      };
    }

    let { data } = toRefs(props);
    const tdData = data.value as Narratives;
    return { tdData };
  },
});
</script>
