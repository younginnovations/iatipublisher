<template>
  <div v-if="!props.status">
    <div v-if="!isSavingStarted">
      <div>
        <h3 class="pb-[2px] text-[20px] font-bold leading-9 text-n-50">
          Set Default Values
        </h3>
        <div class="text-sm">
          These commonly occurring values can be populated here and IATI
          Publisher will automatically apply them to all of your activities.
        </div>
        <div
          class="mt-3 max-h-[373px] overflow-x-hidden overflow-y-scroll rounded-lg bg-n-10 pt-[20px] pl-[27px] pb-[20px] pr-[18px]"
        >
          <!-- All Values Default Start -->
          <div>
            <p class="text-sm font-bold">Default for all data</p>
            <div class="grid grid-cols-2 gap-[22px] pt-4">
              <!-- Default Currency Start -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="default-currency" class="text-[14px]">
                    Default Currency
                  </label>
                  <button>
                    <HoverText
                      name="Default Currency"
                      hover-text="The currency in which you report your financial transactions. You can later manually change the currency on individual transactions and budgets if required."
                      :show-iati-reference="true"
                    />
                  </button>
                </div>
                <Multiselect
                  id="default-currency"
                  class="vue__select"
                  placeholder="Select from dropdown"
                  :searchable="true"
                  :options="props.currencies"
                  :value="allDefaultValue.default_currency"
                  @update:model-value="
                (value:string) => (allDefaultValue.default_currency = value)
              "
                />
                <p class="pt-2 text-xs text-n-40">
                  The currency in which you normally report your financial
                  transactions. Select from dropdown.
                </p>
              </div>
              <!-- Default Currency End -->
              <!-- Default Language Start -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="default-language" class="text-[14px]">
                    Default Language
                  </label>
                  <button>
                    <HoverText
                      name="Default Language"
                      hover-text="The language in which you provide data on your activities. You can later manually change the language on individual text if required."
                      :show-iati-reference="true"
                    />
                  </button>
                </div>
                <Multiselect
                  id="default-language"
                  class="vue__select"
                  placeholder="Select language from dropdown"
                  :searchable="true"
                  :options="props.languages"
                  :value="allDefaultValue.default_language"
                  @update:model-value="
                (value:string) => (allDefaultValue.default_language = value)
              "
                />
                <p class="pt-2 text-xs text-n-40">
                  The language in which you normally report. Select from
                  dropdown.
                </p>
              </div>
              <!-- Default Language End -->
            </div>
          </div>
          <!-- All Values Default End -->
          <!-- Activity Data Default Start -->
          <div class="pt-6">
            <p class="text-sm font-bold">Default for activity data</p>
            <div class="grid grid-cols-2 gap-[22px] pt-4">
              <!-- Default Hierarchy Start -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="ddefault-hierarchy" class="text-[14px]">
                    Default Hierarchy
                  </label>
                  <button>
                    <HoverText
                      width="w-64"
                      name="Default Hierarchy"
                      hover-text="If you are reporting both programmes (parent activities) and projects (child activities),
                choose the hierarchical level that most of your activities are at. e.g. parent activity = 1; child activity = 2.
                <br>If all your activities are at the same level i.e. you have no child activities, then choose 1."
                      :show-iati-reference="true"
                    />
                  </button>
                </div>
                <input
                  id="default-hierarchy"
                  v-model="allDefaultValue.hierarchy"
                  class="mb-2 w-full rounded-[4px] border border-n-20 py-2 pl-4 focus:outline-0 focus-visible:outline-0"
                  type="text"
                  placeholder="Type default hierarchy here"
                />
                <p class="pt-2 text-xs text-n-40">
                  If hierarchy is not reported then 1 is assumed. If multiple
                  levels are reported then, to avoid double counting, financial
                  transactions should only be reported at the lowest
                  hierarchical level.
                </p>
              </div>
              <!-- Default Heirarchy End -->
              <!-- Humanitarian Start -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="humanitarian" class="text-[14px]">
                    Humanitarian
                  </label>
                  <button>
                    <HoverText
                      width="w-72"
                      name="Humanitarian"
                      hover-text="Add a 'Humanitarian Flag' to every activity that your organisation publishes data on. This means that your organisation identifies all their activities as wholly or partially addressing a humanitarian crisis or multiple crises. You can later manually add or remove a Humanitarian Flag on individual activities if required."
                      :show-iati-reference="true"
                    />
                  </button>
                </div>
                <Multiselect
                  id="humanitarian"
                  class="vue__select"
                  placeholder="Select Humanitarian here"
                  :searchable="true"
                  :options="props.humanitarian"
                  :value="allDefaultValue.humanitarian"
                  @update:model-value="
                (value:string) => (allDefaultValue.humanitarian = value)
              "
                />
              </div>
              <!-- Humanitarian End -->
              <!-- Default Flow Type Start -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="default-flow-type" class="text-[14px]"
                    >Default Flow Type</label
                  >
                  <button>
                    <HoverText
                      width="w-72"
                      name="default-flow-type"
                      hover-text="Whether the activity is funded by Official Development Assistance (ODA), Other Official Flows (OOF), etc. <a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-flow-type/'>For more information</a>"
                      :show-iati-reference="true"
                    />
                  </button>
                </div>
                <Multiselect
                  id="default-flow-type"
                  class="vue__select"
                  placeholder="Select Default Flow Type here"
                  :searchable="true"
                  :options="props.defaultFlowType"
                  :value="allDefaultValue.default_flow_type"
                  @update:model-value="
                (value:string) => (allDefaultValue.default_flow_type = value)
              "
                />
                <p class="pt-2 text-xs text-n-40">
                  If selected, then default flow type will be automatically
                  populated in activity when created.
                </p>
              </div>
              <!-- Default Flow Type End -->
              <!-- Default Finance Type Start -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="default-finance-type" class="text-[14px]"
                    >Default Finance Type</label
                  >
                  <button>
                    <HoverText
                      width="w-72"
                      name="default-finance-type"
                      hover-text="The type of finance (e.g. grant, loan, debt relief, etc). This the default value for all transactions in the activity report; it can be overridden by individual transactions. <a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-finance-type/'>For more information</a>"
                      :show-iati-reference="true"
                    />
                  </button>
                </div>
                <Multiselect
                  id="default-finance-type"
                  class="vue__select"
                  placeholder="Select Default Finance Type here"
                  :searchable="true"
                  :options="props.defaultFinanceType"
                  :value="allDefaultValue.default_finance_type"
                  @update:model-value="
                (value:string) => (allDefaultValue.default_finance_type = value)
              "
                />
                <p class="pt-2 text-xs text-n-40">
                  If selected, then default finance type will be automatically
                  populated in activity when created.
                </p>
              </div>
              <!-- Default Finance Type End -->
              <!-- Default Aid Type Start -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="default-aid-type" class="text-[14px]"
                    >Default Aid Type</label
                  >
                  <button>
                    <HoverText
                      width="w-72"
                      position="top-left"
                      name="default-aid-type"
                      hover-text="The type of aid being supplied (project-type intervention, budget support, debt relief, etc.). This element specifies a default for all the activity’s financial transactions; it can be overridden at the individual transaction level. <a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-aid-type/'>For more information</a>"
                      :show-iati-reference="true"
                    />
                  </button>
                </div>
                <Multiselect
                  id="default-aid-type"
                  class="vue__select"
                  placeholder="Select Default Aid Type here"
                  :searchable="true"
                  :options="props.defaultAidType"
                  :value="allDefaultValue.default_aid_type"
                  @update:model-value="
                (value:string) => (allDefaultValue.default_aid_type = value)
              "
                />
                <p class="pt-2 text-xs text-n-40">
                  If selected, then default aid type will be automatically
                  populated in activity when created. Also, Vocabulary type
                  "OECD DAC" will be chosen by default.
                </p>
              </div>
              <!-- Default Aid Type End -->
              <!-- Default Tied Status Start -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="default-tied-status" class="text-[14px]"
                    >Default Tied Status</label
                  >
                  <button>
                    <HoverText
                      width="w-72"
                      position="top-left"
                      name="default-tied-status"
                      hover-text="Whether the aid is untied, tied, or partially tied. This element specifies a default for all the activity’s financial transactions; it can be overridden at the individual transaction level.<a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-tied-status/'>For more information</a>"
                      :show-iati-reference="true"
                    />
                  </button>
                </div>
                <Multiselect
                  id="default-tied-status"
                  class="vue__select"
                  placeholder="Select Default Tied Status here"
                  :searchable="true"
                  :options="props.defaultTiedStatus"
                  :value="allDefaultValue.default_tied_status"
                  @update:model-value="
                (value:string) => (allDefaultValue.default_tied_status = value)
              "
                />
                <p class="pt-2 text-xs text-n-40">
                  If selected, then default tied status will be automatically
                  populated in activity when created.
                </p>
              </div>
              <!-- Default Tied Status End -->
            </div>
          </div>
          <!-- Activity Data Default End -->
        </div>
        <div class="flex items-center gap-1 pt-3 text-xs text-n-40">
          <svg-vue icon="message-icon" />
          <span>
            You can adjust these values later from the 'Default Values' section.
          </span>
        </div>
      </div>
      <div class="mt-3 flex w-full items-center justify-between">
        <button class="text-xs font-bold text-n-40" @click="previousStep">
          Previous
        </button>
        <div class="flex items-center gap-4">
          <button
            class="text-xs font-bold text-n-40"
            @click="emit(`proceedStep`)"
          >
            Skip to next step
          </button>
          <button class="button primary-btn text-xs" @click="proceedStep">
            Save and NEXT
          </button>
        </div>
      </div>
    </div>
    <div v-else>
      <div
        class="flex min-h-[360px] min-w-[733px] items-center justify-center rounded-lg bg-n-10"
      >
        <Transition mode="out-in">
          <div v-if="!isSaved" class="relative">
            <LinesLoader />
          </div>
          <div
            v-else
            class="mt-3 flex w-full flex-col items-center justify-center gap-2"
          >
            <svg-vue icon="green-circle-tick" class="text-[41px]" />
            <span
              class="max-w-[200px] text-center text-sm font-bold text-bluecoral"
              >Default values have been saved successfully.</span
            >
          </div>
        </Transition>
      </div>
    </div>
  </div>

  <div v-else class="h-full min-w-[733px] pt-[130px]">
    <div class="flex h-full flex-col justify-between">
      <div class="rounded-lg bg-n-10 py-[60px] px-[73px]">
        <div class="flex flex-col items-center justify-center text-center">
          <svg-vue icon="green-circle-tick" class="text-[34px]" />
          <div>
            <h2 class="max-w-[587px] py-[5.4px] text-2xl font-bold text-n-50">
              Default values have already been set.
            </h2>
            <p class="max-w-[587px] text-sm text-n-50">
              If you want to make any changes, go to
              <a href="/setting" target="_blank">settings</a>.
            </p>
          </div>
        </div>
      </div>
      <div class="mb-[30px] self-end">
        <button class="button primary-btn text-xs" @click="emit(`proceedStep`)">
          NEXT
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, watchEffect, ref } from 'vue';

import Multiselect from '@vueform/multiselect';
import HoverText from 'Components/HoverText.vue';
import axios from 'axios';
import LinesLoader from 'Components/LinesLoader.vue';

const props = defineProps({
  currencies: {
    type: Object,
    required: true,
  },
  languages: {
    type: Object,
    required: true,
  },
  humanitarian: {
    type: Object,
    required: true,
  },
  defaultFlowType: {
    type: Object,
    required: true,
  },
  defaultFinanceType: {
    type: Object,
    required: true,
  },
  defaultAidType: {
    type: Object,
    required: true,
  },
  defaultTiedStatus: {
    type: Object,
    required: true,
  },
  defaultValues: {
    type: Object,
    required: true,
  },
  fetchData: {
    type: Function,
    required: true,
  },
  status: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits([
  'proceedStep',
  'previousStep',
  'completeStep',
  'removeCompletedStep',
]);
const allDefaultValue = ref({
  default_currency: '',
  default_language: '',
  hierarchy: '',
  humanitarian: '',
  default_flow_type: '',
  default_finance_type: '',
  default_aid_type: '',
  default_tied_status: '',
});

const isSavingStarted = ref(false);
const isSaved = ref(false);

watchEffect(() => {
  if (props.defaultValues) {
    Object.keys(allDefaultValue.value).forEach((key) => {
      if (props.defaultValues[key] !== undefined) {
        allDefaultValue.value[key] = props.defaultValues[key];
      }
    });
  }
});

const proceedStep = () => {
  isSavingStarted.value = true;
  axios
    .post('/setting/store/default', allDefaultValue.value)
    .then(
      (response: {
        data: {
          success: boolean;
          data: {
            default_values: {
              default_currency: string;
              default_language: string;
            };
          };
        };
      }) => {
        if (response.data.success) {
          const defaultValues = response.data.data.default_values;

          setTimeout(() => {
            isSaved.value = true;
          }, 1000);

          setTimeout(() => {
            props.fetchData();

            defaultValueCompletedCheck(defaultValues);

            emit('proceedStep');
          }, 3000);
        }
      }
    )
    .catch((err) => console.log('Error', err));
};

const defaultValueCompletedCheck = (defaultValues: {
  default_currency: string | null | undefined;
  default_language: string | null | undefined;
}) => {
  if (
    defaultValues &&
    defaultValues.default_currency != null &&
    defaultValues.default_currency !== '' &&
    defaultValues.default_language != null &&
    defaultValues.default_language !== ''
  ) {
    emit('completeStep', 2);
  } else {
    emit('removeCompletedStep', 2);
  }
};

const previousStep = () => {
  emit('previousStep');
};
</script>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: all 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
  transform: translateY(100%);
}
</style>
