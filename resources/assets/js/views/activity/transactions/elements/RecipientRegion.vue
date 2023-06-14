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
              <td>{{ language.common_lang.code }}</td>
              <td>
                <span v-if="cou.region_vocabulary === '1'">{{
                  cou.region_code
                    ? type.regionCode[cou.region_code]
                    : language.common_lang.missing.element.replace(
                        ':element',
                        language.common_lang.code
                      )
                }}</span>
                <span v-else>{{
                  cou.custom_code ??
                  language.common_lang.missing.element.replace(
                    ':element',
                    language.common_lang.code
                  )
                }}</span>
              </td>
            </tr>
            <tr v-if="cou.vocabulary_uri">
              <td>{{ language.common_lang.vocabulary_uri }}</td>
              <td>
                <a target="_blank" :href="cou.vocabulary_uri">{{
                  cou.vocabulary_uri
                }}</a>
              </td>
            </tr>
            <tr>
              <td>{{ language.common_lang.description }}</td>
              <td>
                <div
                  v-for="(sd, i) in cou.narrative"
                  :key="i"
                  class="title-content mb-4"
                  :class="{
                    'mb-4': i !== cou.narrative.length - 1,
                  }"
                >
                  <div class="language mb-1.5">
                    (
                    {{
                      sd.language
                        ? `${language.common_lang.language}: ${
                            type.languages[sd.language]
                          }`
                        : language.common_lang.missing.element.replace(
                            ':element',
                            language.common_lang.language
                          )
                    }})
                  </div>
                  <div class="text-sm">
                    {{ sd.narrative ?? language.common_lang.missing.narrative }}
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
    const language = window['globalLang'];
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
    return { country, type, language };
  },
});
</script>
