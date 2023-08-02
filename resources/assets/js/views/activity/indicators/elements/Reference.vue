<template>
  <tr>
    <td>{{ translate.commonText('reference') }}</td>
    <td>
      <div
        v-for="(ref, r) in refData"
        :key="r"
        :class="{
          'mb-1.5': r !== Object.keys(refData).length - 1,
        }"
      >
        <span>
          {{ translate.commonText('vocabulary') }}:
          {{
            refType.indicatorVocabulary[ref.vocabulary] ?? translate.missing()
          }},
        </span>
        <span>
          {{ translate.commonText('code') }}:
          {{ ref.code ?? translate.missing() }},
        </span>
        <span v-if="ref.indicator_uri">
          {{ translate.commonText('indicator_uri') }}:
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
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
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
    return { refData, translate };
  },
});
</script>
