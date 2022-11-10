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
        <span>{{
          type.aidTypeVocabulary[at.aid_type_vocabulary] ?? 'Missing'
        }}</span>
      </div>
      <div clas="ml-4">
        <table class="mb-3">
          <tr>
            <td>Code</td>
            <td>
              <div class="text-sm">
                <span v-if="at.aid_type_code">
                  {{ type.aidType[at.aid_type_code] }}
                </span>
                <span v-else-if="at.cash_and_voucher_modalities">
                  {{
                    type.cashAndVoucherModalities[
                      at.cash_and_voucher_modalities
                    ]
                  }}
                </span>
                <span v-else-if="at.earmarking_category">
                  {{ type.earMarkingCategory[at.earmarking_category] }}
                </span>
                <span v-else-if="at.earmarking_modality">
                  {{ type.earMarkingModality[at.earmarking_modality] }}
                </span>
                <span v-else> Missing </span>
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs, inject } from 'vue';

export default defineComponent({
  name: 'TransactionAidType',
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
      aid_type_code: string;
      aid_type_vocabulary: string;
      cash_and_voucher_modalities: string;
      earmarking_category: string;
      earmarking_modality: string;
    }
    const atData = data.value as ArrayObject[];

    interface TypesInterface {
      aidType: [];
      aidTypeVocabulary: [];
      cashAndVoucherModalities: [];
      earMarkingCategory: [];
      earMarkingModality: [];
    }

    const type = inject('types') as TypesInterface;
    return {
      atData,
      type,
    };
  },
});
</script>
