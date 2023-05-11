<template>
  <div class="elements-detail wider">
    <div class="ml-4">
      <table class="mb-3">
        <tbody>
          <tr>
            <td>Organisation Identifier Code</td>
            <td>
              <div class="text-sm">
                {{
                  !isEmpty(PoData[0].organization_identifier_code)
                    ? PoData[0].organization_identifier_code
                    : 'Missing'
                }}
              </div>
            </td>
          </tr>
          <tr>
            <td>Description</td>
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
                    !isEmpty(po.language)
                      ? `Language: ${type.languages[po.language]}`
                      : 'Language: Missing'
                  }})
                </div>
                <div class="text-sm">
                  {{
                    !isEmpty(po.narrative) ? po.narrative : 'Narrative Missing'
                  }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Provider Activity ID</td>
            <td>
              <div class="text-sm">
                {{
                  !isEmpty(PoData[0].provider_activity_id)
                    ? PoData[0].provider_activity_id
                    : 'Missing'
                }}
              </div>
            </td>
          </tr>
          <tr>
            <td>Type</td>
            <td>
              <div class="text-sm">
                {{
                  !isEmpty(PoData[0].type)
                    ? type.organizationType[PoData[0].type]
                    : 'Missing'
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
import isEmpty from '../../../../composable/helper';

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
    return { PoData, type };
  },
  methods: { isEmpty },
});
</script>
