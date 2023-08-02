<template>
  <div class="elements-detail wider">
    <div class="ml-4">
      <table class="mb-3">
        <tbody>
          <tr>
            <td>{{ translate.commonText('organiser_identifier_code') }}</td>
            <td>
              <div class="text-sm">
                {{
                  PoData[0].organization_identifier_code ?? translate.missing()
                }}
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('description') }}</td>
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
                      ? `${translate.commonText('language')}: ${
                          type.languages[po.language]
                        }`
                      : `${translate.commonText(
                          'language'
                        )}:${translate.missing()}`
                  }})
                </div>
                <div class="text-sm">
                  {{ po.narrative ?? translate.missing('narrative') }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('provider_activity_id') }}</td>
            <td>
              <div class="text-sm">
                {{ PoData[0].provider_activity_id ?? translate.missing() }}
              </div>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('type') }}</td>
            <td>
              <div class="text-sm">
                {{
                  PoData[0].type
                    ? type.organizationType[PoData[0].type]
                    : translate.missing()
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
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
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
    return { PoData, type, translate };
  },
});
</script>
