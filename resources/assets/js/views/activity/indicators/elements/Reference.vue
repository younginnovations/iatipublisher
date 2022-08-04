<template>
  <tr>
    <td>Reference</td>
    <td>
      <div
        v-for="(ref, r) in refData"
        :key="r"
        :class="{
          'mb-1.5': r !== Object.keys(refData).length - 1,
        }"
      >
        <span v-if="ref.vocabulary"> Vocabulary: {{ refType.indicatorVocabulary[ref.vocabulary] }}, </span>
        <span v-if="ref.code"> Code: {{ ref.code }}, </span>
        <span v-if="ref.indicator_uri">
          Indicator URI:
          <a target="_blank" :href="ref.indicator_uri">
            {{ ref.indicator_uri }}
          </a>
        </span>
      </div>
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'IndicatorReference',
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
    refType: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    let { data } = toRefs(props);

    /**
     * Typescript interface
     */
    interface ReferenceArray {
      [index: number]: {
        vocabulary: number;
        code: string;
        indicator_uri: string;
      };
    }
    const refData = data.value as ReferenceArray;
    return { refData };
  },
});
</script>
