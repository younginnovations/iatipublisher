<template>
  <tr>
    <td>{{ language.common_lang.reference_label }}</td>
    <td>
      <div
        v-for="(ref, r) in refData"
        :key="r"
        :class="{
          'mb-1.5': r !== Object.keys(refData).length - 1,
        }"
      >
        <span>
          {{ language.common_lang.vocabulary }}:
          {{
            refType.indicatorVocabulary[ref.vocabulary] ??
            language.common_lang.missing.default
          }},
        </span>
        <span>
          {{ language.common_lang.code }}:
          {{ ref.code ?? language.common_lang.missing.default }},
        </span>
        <span v-if="ref.indicator_uri">
          {{ language.common_lang.indicator_uri }}:
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
    const language = window['globalLang'];
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
    return { refData, language };
  },
});
</script>
