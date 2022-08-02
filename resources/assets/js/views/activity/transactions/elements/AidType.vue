<template>
  <div class="elements-detail">
    <div
      v-for="(at, i) in atData"
      :key="i"
      class="item"
      :class="{
        'mb-4': i !== Object.keys(atData).length - 1,
      }"
    >
      <div class="category">
        <span>{{ aidTypeVocabulary[at.aid_type_vocabulary] }}</span>
      </div>
      <div clas="ml-4">
        <table class="mb-3">
          <tr>
            <td>Code</td>
            <td>
              <div class="text-sm">
                <span v-if="at.aid_type_code">
                  {{ aidType[at.aid_type_code] }}
                </span>
                <span v-else-if="at.cash_and_voucher_modalities">
                  {{ cashAndVoucherModalities[at.cash_and_voucher_modalities] }}
                </span>
                <span v-else-if="at.earmarking_category">
                  {{ earMarkingCategory[at.earmarking_category] }}
                </span>
                <span v-else-if="at.earmarking_modality">
                  {{ earMarkingModality[at.earmarking_modality] }}
                </span>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'TransactionAidType',
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
    const { data, types } = toRefs(props),
      aidTypeVocabulary = types.value.aidTypeVocabulary,
      aidType = types.value.aidType,
      cashAndVoucherModalities = types.value.cashAndVoucherModalities,
      earMarkingCategory = types.value.earMarkingCategory,
      earMarkingModality = types.value.earMarkingModality;

    interface ArrayObject {
      [index: number]: {
        aid_type_code: string;
        aidtype_vocabulary: string;
        cash_and_voucher_modalities: string;
        earmarking_category: string;
        earmarking_modality: string;
      };
    }
    const atData = data.value as ArrayObject;
    return {
      atData,
      aidTypeVocabulary,
      aidType,
      cashAndVoucherModalities,
      earMarkingCategory,
      earMarkingModality,
    };
  },
});
</script>
