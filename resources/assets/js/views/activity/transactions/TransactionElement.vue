<template>
  <div
    :id="elementName"
    class="px-3 py-3 activities__content--element text-n-50"
    :class="{
      'basis-full': width === 'full',
      'basis-6/12': width === '',
    }"
  >
    <div class="p-4 bg-white rounded-lg">
      <div class="flex mb-4">
        <div class="flex title grow">
          <div class="text-sm font-bold title">{{ elementName }}</div>
        </div>
        <div class="flex items-center icons">
          <!-- <svg-vue class="mr-1.5" icon="core"></svg-vue> -->
          <HoverText hover-text="example text" class="text-n-40"></HoverText>
        </div>
      </div>
      <div class="w-full h-px mb-4 divider bg-n-20"></div>
      <div>
        <template v-if="elementName === 'description'">
          <Description :data="elementData" />
        </template>

        <template v-else-if="elementName === 'aid_type'">
          <AidType :data="elementData" :types="types" />
        </template>

        <template v-else-if="elementName === 'transaction_type'">
          <TransactionType :data="elementData" :types="transactionTypes" />
        </template>

        <template v-else-if="elementName === 'transaction_date'">
          <TransactionDate :data="elementData" />
        </template>

        <template v-else-if="elementName === 'value'">
          <Value :data="elementData" />
        </template>

        <template v-else-if="elementName === 'humanitarian'">
          {{ data != '0' }}
        </template>

        <template v-else-if="elementName === 'provider_organization'">
          <ProviderOrganization
            :data="elementData"
            :types="organizationTypes"
          />
        </template>

        <template v-else-if="elementName === 'receiver_organization'">
          <ReceiverOrganization
            :data="elementData"
            :types="organizationTypes"
          />
        </template>

        <template v-else-if="elementName === 'disbursement_channel'">
          <DisbursementChannel
            :data="elementData"
            :types="disbursementChannel"
          />
        </template>

        <template v-else-if="elementName === 'sector'">
          <Sector :data="elementData" :types="types" />
        </template>

        <template v-else-if="elementName === 'recipient_country'">
          <RecipientCountry :data="elementData" :country-code="countryCode" />
        </template>

        <template v-else-if="elementName === 'recipient_region'">
          <RecipientRegion :data="elementData" :region-code="regionCode" />
        </template>

        <template v-else-if="elementName === 'flow_type'">
          <FlowType :data="elementData" :flow-type="flowType" />
        </template>

        <template v-else-if="elementName === 'finance_type'">
          <FinanceType :data="elementData" :finance-type="financeType" />
        </template>

        <template v-else-if="elementName === 'tied_status'">
          <TiedStatus :data="elementData" :tied-status-type="tiedStatusType" />
        </template>
        <template v-else>
          {{ data??'Not Available' }}
        </template>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import HoverText from './../../../components/HoverText.vue';
import dateFormat from './../../../composable/dateFormat';
import {
  Description,
  AidType,
  TransactionType,
  TransactionDate,
  Value,
  ProviderOrganization,
  ReceiverOrganization,
  DisbursementChannel,
  Sector,
  RecipientCountry,
  RecipientRegion,
  FlowType,
  FinanceType,
  TiedStatus,
} from './elements/Index';

export default defineComponent({
  name: 'ActivityElement',
  components: {
    HoverText,
    Description,
    AidType,
    TransactionType,
    TransactionDate,
    Value,
    ProviderOrganization,
    ReceiverOrganization,
    DisbursementChannel,
    Sector,
    RecipientCountry,
    RecipientRegion,
    FlowType,
    FinanceType,
    TiedStatus,
  },
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    elementName: {
      type: String,
      required: true,
    },
    editUrl: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      required: false,
      default: '',
    },
    types: {
      type: Object,
      required: true,
    },
    hoverText: {
      type: String,
      required: false,
      default: '',
    },
  },
  setup(props) {
    let { data, types } = toRefs(props),
      elementData = data.value,
      transactionTypes = types.value.transactionType,
      organizationTypes = types.value.organizationType,
      disbursementChannel = types.value.disbursementChannel,
      sectorVocabulary = types.value.sectorVocabulary,
      countryCode = types.value.countryCode,
      regionCode = types.value.regionCode,
      flowType = types.value.flowType,
      financeType = types.value.financeType,
      tiedStatusType = types.value.tiedStatusType;

    /**
     * Joins data from array with a comma
     * @param language
     */

    interface Entry {
      [key: string]: string;
    }

    function getLanguages(language: Entry[]) {
      return language.map((entry) => entry.language).join(', ');
    }
    return {
      elementData,
      getLanguages,
      dateFormat,
      transactionTypes,
      organizationTypes,
      disbursementChannel,
      sectorVocabulary,
      countryCode,
      regionCode,
      flowType,
      financeType,
      tiedStatusType,
    };
  },
});
</script>
