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
            : translate.missing('vocabulary')
        }}</span>
      </div>
      <div class="ml-4">
        <table class="mb-3">
          <tbody>
            <tr>
              <td>{{ translate.commonText('code') }}</td>
              <td>
                <div class="text-sm">
                  <span v-if="sec.text">
                    {{ sec.text ?? translate.missing() }}
                  </span>
                  <span v-else-if="sec.code">
                    {{
                      sec.code ? type.sectorCode[sec.code] : translate.missing()
                    }}
                  </span>
                  <span v-else-if="sec.category_code">
                    {{
                      sec.category_code
                        ? type.sectorCategory[sec.category_code]
                        : translate.missing()
                    }}
                  </span>
                  <span v-else-if="sec.sdg_goal">
                    {{
                      sec.sdg_goal
                        ? type.unsdgGoals[sec.sdg_goal]
                        : translate.missing()
                    }}
                  </span>
                  <span v-else-if="sec.sdg_target">
                    {{
                      sec.sdg_target
                        ? type.unsdgTargets[sec.sdg_target]
                        : translate.missing()
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
              <td>{{ translate.commonText('vocabulary_uri') }}</td>
              <td>
                <div class="text-sm">
                  <span v-if="sec.vocabulary_uri">
                    <a href="sec.vocabulary_uri" target="_blank">
                      {{ sec.vocabulary_uri }}
                    </a>
                  </span>
                  <span v-else>{{ translate.missing() }}</span>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ translate.commonText('description') }}</td>
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
                      sd.language
                        ? `${translate.commonText('language')}: ${
                            type.languages[sd.language]
                          }`
                        : translate.missing('language')
                    }})
                  </div>
                  <div class="text-sm">
                    {{ sd.narrative ?? translate.missing('narrative') }}
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
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
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
      translate,
    };
  },
});
</script>
