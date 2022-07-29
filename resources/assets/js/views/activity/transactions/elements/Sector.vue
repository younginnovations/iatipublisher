<template>
  <div class="elements-detail wider">
    <div
      v-for="(sec, s) in sector"
      :key="s"
      class="item"
      :class="{
        'mb-4': s !== Object.keys(sector).length - 1,
      }"
    >
      <div class="category">
        <span>{{
          sec.sector_vocabulary
            ? sectorVocabulary[sec.sector_vocabulary]
            : 'Vocabulary Not Available'
        }}</span>
      </div>
      <div class="ml-4">
        <table class="mb-3">
          <tr>
            <td>Code</td>
            <td>
              <div class="text-sm description">
                <span v-if="sec.text">
                  {{ sec.text ?? 'Not Available' }}
                </span>
                <span v-else-if="sec.code">
                  {{ sec.code ? sectorCode[sec.code] : 'Not Available' }}
                </span>
                <span v-else-if="sec.category_code">
                  {{
                    sec.category_code
                      ? sectorCategory[sec.category_code]
                      : 'Not Available'
                  }}
                </span>
                <span v-else-if="sec.sdg_goal">
                  {{ sec.sdg_goal ? goals[sec.sdg_goal]: 'Not Available' }}
                </span>
                <span v-else-if="sec.sdg_target">
                  {{ sec.sdg_target ? targets[sec.sdg_target] : 'Not Available' }}
                </span>
              </div>
            </td>
          </tr>
          <tr>
            <td>Description</td>
            <td>
              <div
                v-for="(sd, i) in sec.narrative"
                :key="i"
                class="mb-4 title-content"
                :class="{
                  'mb-4': i !== sec.narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  (
                  {{
                    sd.language
                      ? `Language: ${sd.language}`
                      : 'Language Not Available'
                  }})
                </div>
                <div class="text-sm description">
                  {{ sd.narrative ?? 'Narrative Not Available' }}
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'TransactionSector',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    types: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { data, types } = toRefs(props);
    const sectorVocabulary = types.value.sectorVocabulary,
      sectorCode = types.value.sectorCode,
      sectorCategory = types.value.sectorCategory,
      goals = types.value.unsdgGoals,
      targets = types.value.unsdgTargets;

    interface ArrayObject {
      [index: number]: {
        category_code: string;
        code: string;
        narrative: [{ language: string; narrative: string }];
        sdg_goal: string;
        sdg_target: string;
        sector_vocabulary: string;
        text: string;
        vocabulary_uri: string;
      };
    }

    const sector = data.value as ArrayObject;
    return {
      sector,
      sectorVocabulary,
      sectorCode,
      sectorCategory,
      goals,
      targets,
    };
  },
});
</script>
