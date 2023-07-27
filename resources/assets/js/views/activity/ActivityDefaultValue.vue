<template>
  <section class="section-wrapper activity-default-value">
    <Loader v-if="loaderVisibility" />
    <div class="setting input__field">
      <span class="text-xs font-bold text-n-40">{{
        translate.textFromKey('activity_default.override_default_values.label')
      }}</span>
      <div class="flex items-center justify-between">
        <div class="mt-4 mb-6 flex items-center">
          <a :href="`/activity/${activityId}`"><svg-vue icon="left-arrow" /></a>
          <h2 class="ml-3 text-heading-4 font-bold text-n-50">
            {{
              translate.textFromKey(
                'activity_default.override_default_values.label'
              )
            }}
          </h2>
        </div>
        <div class="flex w-full justify-end lg:w-[auto]">
          <Toast
            v-if="toastVisibility"
            :message="toastMessage"
            :type="toastType"
          />
        </div>
      </div>
      <div class="setting__container overflow-x-hidden">
        <div class="mb-8 text-xs text-n-40">
          {{
            translate.textFromKey(
              'activity_default.override_default_values.text'
            )
          }}
        </div>
        <div class="register mt-4">
          <div class="register__container mb-0">
            <div>
              <div class="flex justify-between">
                <label for="default-currency">{{
                  translate.textFromKey('activity_default.currency.label')
                }}</label>
                <button>
                  <HoverText
                    :name="
                      translate.textFromKey(
                        'activity_default.currency.hover_header'
                      )
                    "
                    :hover-text="
                      translate.textFromKey(
                        'activity_default.currency.hover_text'
                      )
                    "
                    :show-iati-reference="true"
                  />
                </button>
              </div>
              <Multiselect
                id="default-currency"
                v-model="defaultValues.default_currency"
                class="vue__select"
                :placeholder="
                  translate.textFromKey('activity_default.currency.placeholder')
                "
                :options="currencies"
                :searchable="true"
              />
              <div v-if="defaultErrors.default_currency.length > 0">
                <div
                  v-for="(error, e) in defaultErrors?.default_currency"
                  :key="e"
                  class="error"
                  role="alert"
                >
                  <span class="text-xs">{{ error }}</span>
                </div>
              </div>
              <p
                v-if="defaultErrors.default_currency.length === 0"
                class="text-xs text-n-40"
              >
                {{
                  translate.textFromKey('activity_default.currency.help_text')
                }}
              </p>
            </div>

            <div>
              <div class="flex justify-between">
                <label for="default-currency">{{
                  translate.textFromKey('activity_default.language.label')
                }}</label>
                <button>
                  <HoverText
                    :name="
                      translate.textFromKey(
                        'activity_default.language.hover_header'
                      )
                    "
                    :hover-text="
                      translate.textFromKey(
                        'activity_default.language.hover_text'
                      )
                    "
                    :show-iati-reference="true"
                  />
                </button>
              </div>
              <Multiselect
                id="default-language"
                v-model="defaultValues.default_language"
                class="vue__select"
                :placeholder="
                  translate.textFromKey('activity_default.language.placeholder')
                "
                :searchable="true"
                :options="props.languages"
              />
              <div v-if="defaultErrors.default_language.length > 0">
                <div
                  v-for="(error, e) in defaultErrors.default_language"
                  :key="e"
                  class="error"
                  role="alert"
                >
                  <span class="text-xs">{{ error }}</span>
                </div>
              </div>
              <p
                v-if="defaultErrors.default_language.length === 0"
                class="text-xs text-n-40"
              >
                {{
                  translate.textFromKey('activity_default.language.help_text')
                }}
              </p>
            </div>

            <div>
              <div class="flex justify-between">
                <label for="default-hierarchy">{{
                  translate.textFromKey('activity_default.hierarchy.label')
                }}</label>
                <button>
                  <HoverText
                    width="w-64"
                    :name="
                      translate.textFromKey(
                        'activity_default.hierarchy.hover_header'
                      )
                    "
                    :hover-text="
                      translate.textFromKey(
                        'activity_default.hierarchy.hover_text'
                      )
                    "
                    :show-iati-reference="true"
                  />
                </button>
              </div>
              <input
                id="default-hierarchy"
                v-model="defaultValues.hierarchy"
                class="register__input mb-2"
                type="text"
                :placeholder="
                  translate.textFromKey(
                    'activity_default.hierarchy.placeholder'
                  )
                "
              />
              <div v-if="defaultErrors.hierarchy.length > 0">
                <div
                  v-for="(error, e) in defaultErrors.hierarchy"
                  :key="e"
                  class="error"
                  role="alert"
                >
                  <span class="text-xs">{{ error }}</span>
                </div>
              </div>
              <p
                v-if="defaultErrors.hierarchy.length === 0"
                class="text-xs text-n-40"
              >
                {{
                  translate.textFromKey('activity_default.hierarchy.help_text')
                }}
              </p>
            </div>

            <div>
              <div class="flex justify-between">
                <label for="default-currency">{{
                  translate.textFromKey(
                    'activity_default.budget_not_provided.label'
                  )
                }}</label>
                <button>
                  <HoverText
                    width="w-72"
                    :name="
                      translate.textFromKey(
                        'activity_default.budget_not_provided.hover_header'
                      )
                    "
                    :hover-text="
                      translate.textFromKey(
                        'activity_default.budget_not_provided.hover_text'
                      )
                    "
                  />
                </button>
              </div>
              <Multiselect
                id="budget_not_provided"
                v-model="defaultValues.budget_not_provided"
                class="vue__select"
                :placeholder="
                  translate.textFromKey(
                    'activity_default.budget_not_provided.placeholder'
                  )
                "
                :options="budgetNotProvided"
                :searchable="true"
              />
              <div v-if="defaultErrors.budget_not_provided.length > 0">
                <div
                  v-for="(error, e) in defaultErrors.budget_not_provided"
                  :key="e"
                  class="error"
                  role="alert"
                >
                  <span class="text-xs">{{ error }}</span>
                </div>
              </div>
            </div>

            <div>
              <div class="flex justify-between">
                <label for="default-currency">{{
                  translate.textFromKey('activity_default.humanitarian.label')
                }}</label>
                <button>
                  <HoverText
                    width="w-72"
                    :name="
                      translate.textFromKey(
                        'activity_default.humanitarian.hover_header'
                      )
                    "
                    :hover-text="
                      translate.textFromKey(
                        'activity_default.humanitarian.hover_text'
                      )
                    "
                    :show-iati-reference="true"
                  />
                </button>
              </div>
              <Multiselect
                id="humanitarian"
                v-model="defaultValues.humanitarian"
                class="vue__select"
                :placeholder="
                  translate.textFromKey(
                    'activity_default.humanitarian.placeholder'
                  )
                "
                :options="humanitarian"
                :searchable="true"
              />
              <div v-if="defaultErrors.humanitarian.length > 0">
                <div
                  v-for="(error, e) in defaultErrors.humanitarian"
                  :key="e"
                  class="error"
                  role="alert"
                >
                  <span class="text-xs">{{ error }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="fixed bottom-0 left-0 w-full bg-eggshell py-5 pr-40 shadow-dropdown"
    >
      <div class="flex items-center justify-end">
        <a class="ghost-btn mr-8" :href="`/activity/${activityId}`">{{
          translate.textFromKey('activity_default.cancel_label')
        }}</a>
        <button class="primary-btn save-btn" @click="submitForm()">
          {{
            translate.textFromKey('activity_default.save_default_values_label')
          }}
        </button>
      </div>
    </div>
  </section>
</template>
<script setup lang="ts">
import { defineProps, ref, onMounted } from 'vue';

import Multiselect from '@vueform/multiselect';
import axios from 'axios';

import Loader from 'Components/Loader.vue';
import Toast from 'Components/ToastMessage.vue';
import { Translate } from 'Composable/translationHelper';

const translate = new Translate();

/**
 * Props
 */
const props = defineProps({
  currencies: {
    type: [String, Object],
    required: true,
  },
  languages: {
    type: [String, Object],
    required: true,
  },
  activityId: { type: Number, required: true },
  budgetNotProvided: {
    type: [String, Object],
    required: true,
  },
  humanitarian: {
    type: [String, Object],
    required: true,
  },
});

/**
 * Reactive variables
 */

const defaultValues = ref({
    budget_not_provided: '',
    default_currency: '',
    default_language: '',
    hierarchy: '',
    humanitarian: '',
  }),
  defaultErrors = ref({
    budget_not_provided: [],
    default_currency: [],
    default_language: [],
    hierarchy: [],
    humanitarian: [],
  });

const errorReset = defaultErrors.value;

/**
 * On Mounted
 */
onMounted(async () => {
  const { data } = await axios.get(
    `/activity/${props.activityId}/default_values/data`
  );
  const defaultData = data.data;
  if (defaultData) {
    defaultValues.value = defaultData;
  }
});

/**
 * Ref
 */
const loaderVisibility = ref(false),
  toastVisibility = ref(false),
  toastMessage = ref(''),
  toastType = ref(false);

/**
 * Submit form
 *
 */

function submitForm() {
  loaderVisibility.value = true;
  defaultErrors.value = errorReset;
  axios
    .put(`/activity/${props.activityId}/default_values`, defaultValues.value)
    .then((res) => {
      const response = res.data;
      loaderVisibility.value = false;
      toastVisibility.value = true;
      setTimeout(() => (toastVisibility.value = false), 5000);
      toastMessage.value = response?.message;
      toastType.value = response?.success;
      loaderVisibility.value = false;
    })
    .catch((error) => {
      defaultErrors.value = {
        ...defaultErrors.value,
        ...error.response.data?.errors,
      };

      toastVisibility.value = true;
      toastMessage.value = error.response.data?.message;
      toastType.value = false;
      loaderVisibility.value = false;
    });
}
</script>
