<template>
  <div class="elements-detail wider">
    <div class="ml-4">
      <table class="mb-3">
        <tbody>
          <tr>
            <td>Organisation Identifier Code</td>
            <td>
              <div class="text-sm">
                <ConditionalTextDisplay
                  :success-text="PoData[0].organization_identifier_code"
                  :condition="PoData[0].organization_identifier_code"
                  failure-text="organisation identifier code"
                />
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
                  (Language:
                  <ConditionalTextDisplay
                    :success-text="type.languages[po.language]"
                    :condition="po.language"
                  />)
                </div>
                <div class="text-sm">
                  <ConditionalTextDisplay
                    :success-text="po.narrative"
                    :condition="po.narrative"
                    failure-text="narrative"
                  />
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Receiver Activity ID</td>
            <td>
              <div class="text-sm">
                <ConditionalTextDisplay
                  :success-text="PoData[0].receiver_activity_id"
                  :condition="PoData[0].receiver_activity_id"
                  failure-text="receiver activity id"
                />
              </div>
            </td>
          </tr>
          <tr>
            <td>Type</td>
            <td>
              <div class="text-sm">
                <ConditionalTextDisplay
                  :success-text="PoData[0].type"
                  :condition="type.organizationType[PoData[0].type]"
                  failure-text="type"
                />
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
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';

export default defineComponent({
  name: 'TransactionReceiverOrganisation',
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
