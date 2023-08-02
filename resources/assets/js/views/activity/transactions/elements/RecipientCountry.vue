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
        <span>{{ type.countryCode[cou.country_code] }}</span>
      </div>
      <div class="ml-4">
        <table class="mb-3">
          <tbody>
            <tr>
              <td>{{ translate.commonText('description') }}</td>
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
  name: 'TransactionRecipientCountry',
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

    interface ArrayObject {
      [index: number]: {
        country_code: string;
        narrative: [{ language: string; narrative: string }];
      };
    }
    const country = data.value as ArrayObject;

    interface TypesInterface {
      countryCode: [];
      languages: [];
    }

    const type = inject('types') as TypesInterface;
    return { country, type, translate };
  },
});
</script>
