<template>
  <div class="elements-detail wider">
    <div
      v-for="(cou, c) in country"
      :key="c"
      class="item"
      :class="{
        'mb-4': c !== Object.keys(country).length - 1,
      }"
    >
      <div class="category">
        <span>{{ type.regionVocabulary[cou.region_vocabulary] }}</span>
      </div>
      <div class="ml-4">
        <table class="mb-3">
          <tbody>
            <tr>
              <td>Code</td>
              <td>
                <span v-if="cou.region_vocabulary === '1'">{{
                  cou.region_code
                    ? type.regionCode[cou.region_code]
                    : 'Code Missing'
                }}</span>
                <span v-else
                  >{{ cou.custom_code ?? '' }}
                  <span
                    v-if="!cou.custom_code"
                    class="text-xs italic text-light-gray"
                    >N/A</span
                  >
                </span>
              </td>
            </tr>
            <tr v-if="cou.vocabulary_uri">
              <td>Vocabulary URI</td>
              <td>
                <a target="_blank" :href="cou.vocabulary_uri">{{
                  cou.vocabulary_uri
                }}</a>
              </td>
            </tr>
            <tr>
              <td>Description</td>
              <td>
                <div
                  v-for="(sd, i) in cou.narrative"
                  :key="i"
                  class="title-content mb-4"
                  :class="{
                    'mb-4': i !== cou.narrative.length - 1,
                  }"
                >
                  <div v-if="sd.narrative" class="language mb-1.5">
                    ({{
                      sd.language
                        ? `Language: ${type.languages[sd.language]}`
                        : 'Language N/A'
                    }})
                  </div>
                  <div class="text-sm">
                    {{ sd.narrative ?? '' }}
                    <span
                      v-if="!sd.narrative"
                      class="text-xs italic text-light-gray"
                      >N/A</span
                    >
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

export default defineComponent({
  name: 'TransactionRecipientRegion',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
  },
  setup(props) {
    const { data } = toRefs(props);

    interface ArrayObject {
      [index: number]: {
        region_vocabulary: number;
        region_code: string;
        custom_code: string;
        vocabulary_uri: string;
        narrative: [{ language: string; narrative: string }];
      };
    }
    const country = data.value as ArrayObject;

    interface TypesInterface {
      regionCode: [];
      languages: [];
    }

    const type = inject('types') as TypesInterface;
    return { country, type };
  },
});
</script>
