<template>
  <div class="elements-detail wider">
    <div class="ml-4">
      <table class="mb-3">
        <tr>
          <td>Organisation Identifier Code</td>
          <td>
            <div class="text-sm description">
              {{ PoData[0].organization_identifier_code }}
            </div>
          </td>
        </tr>
        <tr>
          <td>Description</td>
          <td>
            <div
              v-for="(po, i) in PoData[0].narrative"
              :key="i"
              class="mb-4 title-content"
              :class="{
                'mb-4': i !== PoData[0].narrative.length - 1,
              }"
            >
              <div class="language mb-1.5">(Language: {{ po.language }})</div>
              <div class="text-sm description">
                {{ po.narrative }}
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td>Provider Activity ID</td>
          <td>
            <div class="text-sm description">
              {{ PoData[0].receiver_activity_id }}
            </div>
          </td>
        </tr>
        <tr>
          <td>Type</td>
          <td>
            <div class="text-sm description">
              {{ types[PoData[0].type] }}
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'TransactionReceiverOrganisation',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    types: {
      type: Object,
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
    return { PoData };
  },
});
</script>
