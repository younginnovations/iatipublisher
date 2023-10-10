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
                <span v-if="cou.region_vocabulary === '1'">
                  <ConditionalTextDisplay
                    :success-text="type.regionCode[cou.region_code]"
                    :condition="cou.region_code"
                    failure-text="code"
                  />
                </span>
                <span v-else>
                  <ConditionalTextDisplay
                    :success-text="cou.custom_code"
                    :condition="cou.custom_code"
                    failure-text="code"
                  />
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

export default defineComponent({
  name: 'TransactionRecipientRegion',
  components: { ConditionalTextDisplay },
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
