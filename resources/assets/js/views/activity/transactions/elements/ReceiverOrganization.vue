<template>
  <div class="elements-detail wider">
    <div class="ml-4">
      <table class="mb-3">
        <tbody>
          <tr>
            <td>Organisation Identifier Code</td>
            <td>
              <div class="text-sm">
                {{ PoData[0].organization_identifier_code ?? 'Missing' }}
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
                  ({{
                    po.language
                      ? `Language: ${type.languages[po.language]}`
                      : 'Language Missing'
                  }})
                </div>
                <div class="text-sm">
                  {{ po.narrative ?? 'Narrative Missing' }}
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Provider Activity ID</td>
            <td>
              <div class="text-sm">
                {{ PoData[0].receiver_activity_id ?? 'Missing' }}
              </div>
            </td>
          </tr>
          <tr>
            <td>Type</td>
            <td>
              <div class="text-sm">
                {{
                  PoData[0].type
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

export default defineComponent({
  name: 'TransactionReceiverOrganisation',
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
        receiver_activity_id: string;
        type: string;
      };
    }
    const PoData = data.value as ArrayObject;
    const type = inject('types');
    return { PoData, type };
  },
});
</script>
