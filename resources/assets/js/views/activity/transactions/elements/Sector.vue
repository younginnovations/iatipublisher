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
            ? type.sectorVocabulary[sec.sector_vocabulary]
            : 'Vocabulary Missing'
        }}</span>
      </div>
      <div class="ml-4">
        <table class="mb-3">
          <tbody>
            <tr>
              <td>Code</td>
              <td>
                <div class="text-sm">
                  <span v-if="sec.text">
                    <ConditionalTextDisplay
                      :success-text="sec.text"
                      :condition="sec.text"
                      failure-text="code"
                    />
                  </span>
                  <span v-else-if="sec.code">
                    <ConditionalTextDisplay
                      :success-text="sec.code"
                      :condition="type.sectorCode[sec.code]"
                      failure-text="code"
                    />
                  </span>
                  <span v-else-if="sec.category_code">
                    <ConditionalTextDisplay
                      :success-text="sec.category_code"
                      :condition="type.sectorCategory[sec.category_code]"
                      failure-text="code"
                    />
                  </span>
                  <span v-else-if="sec.sdg_goal">
                    <ConditionalTextDisplay
                      :success-text="sec.sdg_goal"
                      :condition="type.unsdgGoals[sec.sdg_goal]"
                      failure-text="code"
                    />
                  </span>
                  <span v-else-if="sec.sdg_target">
                    <ConditionalTextDisplay
                      :success-text="sec.sdg_target"
                      :condition="type.unsdgTargets[sec.sdg_target]"
                      failure-text="code"
                    />
                  </span>
                </div>
              </td>
            </tr>
            <tr
              v-if="
                sec.sector_vocabulary === '98' || sec.sector_vocabulary === '99'
              "
            >
              <td>Vocabulary URI</td>
              <td>
                <div class="text-sm">
                  <span v-if="sec.vocabulary_uri">
                    <a href="sec.vocabulary_uri" target="_blank">
                      {{ sec.vocabulary_uri }}
                    </a>
                  </span>
                  <span v-else>
                    <MissingDataItem item="vocabulary uri" />
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
                  class="title-content mb-4"
                  :class="{
                    'mb-4': i !== sec.narrative.length - 1,
                  }"
                >
                  <div class="language mb-1.5">
                    (Language:
                    <ConditionalTextDisplay
                      :success-text="type.languages[sd.language]"
                      :condition="sd.language"
                    />)
                  </div>
                  <div class="text-sm">
                    <ConditionalTextDisplay
                      :success-text="sd.narrative"
                      :condition="sd.narrative"
                      failure-text="narrative"
                    />
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';
import MissingDataItem from 'Components/MissingDataItem.vue';

export default defineComponent({
  name: 'TransactionSector',
  components: { MissingDataItem, ConditionalTextDisplay },
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
  },
  setup(props) {
    const { data } = toRefs(props);

    interface Sector {
      sectorVocabulary: object;
      sectorCode: {};
      sectorCategory: {};
      unsdgGoals: {};
      unsdgTargets: {};
      languages: {};
    }

    const type = inject('types') as Sector;

    interface ArrayObject {
      category_code: string;
      code: string;
      narrative: [{ language: string; narrative: string }];
      sdg_goal: string;
      sdg_target: string;
      sector_vocabulary: string;
      text: string;
      vocabulary_uri: string;
    }

    const sector = data.value as ArrayObject[];

    return {
      sector,
      type,
    };
  },
});
</script>
