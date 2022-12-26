<template>
  <div class="elements-detail wider">
    <div class="ml-4">
      <table class="mb-3">
        <tbody>
          <tr>
            <td>{{ language.common_lang.organiser_identifier_code }}</td>
            <td>
              <div class="text-sm">
                {{
                  PoData[0].organization_identifier_code ??
                  language.common_lang.missing.default
                }}
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.description }}</td>
            <td>
              <div
                v-for="(po, i) in PoData[0].narrative"
                :key="i"
                class="title-content mb-4"
                :class="{
                  'mb-4': i !== PoData[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  (
                  {{
                    po.language
                      ? `${language.common_lang.language}: ${
                          type.languages[po.language]
                        }`
                      : `${language.common_lang.language}:${language.common_lang.missing.default}`
                  }})
                </div>
                <div class="text-sm">
                  {{ po.narrative ?? language.common_lang.missing.narrative }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.provider_activity_id }}</td>
            <td>
              <div class="text-sm">
                {{
                  PoData[0].provider_activity_id ??
                  language.common_lang.missing.default
                }}
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.type }}</td>
            <td>
              <div class="text-sm">
                {{
                  PoData[0].type
                    ? type.organizationType[PoData[0].type]
                    : language.common_lang.missing.default
                }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

export default defineComponent({
  name: 'TransactionProviderOrganisation',
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
        narrative: [{ language: string; narrative: string }];
        organization_identifier_code: string;
        provider_activity_id: string;
        type: string;
      };
    }
    const PoData = data.value as ArrayObject;

    interface TypesInterface {
      organizationType: [];
      languages: [];
    }
    const type = inject('types') as TypesInterface;
    return { PoData, type, language };
  },
});
</script>
