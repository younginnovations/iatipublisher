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
          !isEmpty(sec.sector_vocabulary)
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
                    {{ !isEmpty(sec.text) ? sec.text : 'Missing' }}
                  </span>
                  <span v-else-if="sec.code">
                    {{
                      !isEmpty(sec.code) ? type.sectorCode[sec.code] : 'Missing'
                    }}
                  </span>
                  <span v-else-if="sec.category_code">
                    {{
                      !isEmpty(sec.category_code)
                        ? type.sectorCategory[sec.category_code]
                        : 'Missing'
                    }}
                  </span>
                  <span v-else-if="sec.sdg_goal">
                    {{
                      !isEmpty(sec.sdg_goal)
                        ? type.unsdgGoals[sec.sdg_goal]
                        : 'Missing'
                    }}
                  </span>
                  <span v-else-if="sec.sdg_target">
                    {{
                      !isEmpty(sec.sdg_target)
                        ? type.unsdgTargets[sec.sdg_target]
                        : 'Missing'
                    }}
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
                  <span v-if="!isEmpty(sec.vocabulary_uri)">
                    <a href="sec.vocabulary_uri" target="_blank">
                      {{ sec.vocabulary_uri }}
                    </a>
                  </span>
                  <span v-else> Missing</span>
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
                    (
                    {{
                      !isEmpty(sd.language)
                        ? `Language: ${type.languages[sd.language]}`
                        : 'Language Missing'
                    }})
                  </div>
                  <div class="text-sm">
                    {{
                      !isEmpty(sd.narrative)
                        ? sd.narrative
                        : 'Narrative Missing'
                    }}
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
import isEmpty from '../../../../composable/helper';

export default defineComponent({
  name: 'TransactionSector',
  components: {},
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
  methods: { isEmpty },
});
</script>
