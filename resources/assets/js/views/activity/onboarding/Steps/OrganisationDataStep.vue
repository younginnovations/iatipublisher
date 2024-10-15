<!-- eslint-disable vue/no-v-html -->
<template>
  <ToastMessage
    v-if="toastVisibility"
    class="toast fixed top-10 right-10"
    :message="toastMessage"
    :type="toastType"
  />

  <Loader v-if="isLoaderVisible" />

  <div v-if="!props.status">
    <div v-if="!isSaving">
      <!-- Error -->
      <div
        v-if="hasError"
        class="flex gap-2 border-l-[3px] border-crimson-40 bg-rose py-[10px] px-[14px]"
      >
        <div>
          <svg-vue
            class="text-[22px]"
            icon="exclamation-warning-fill"
          ></svg-vue>
        </div>
        <div class="text-xs leading-[20px] tracking-[-2%]">
          <p class="font-bold">Verification Required</p>
          <ul class="list-disc">
            <li
              v-for="(message, index) in errorMessages"
              :key="index"
              class="translate-x-3"
              v-html="message"
            ></li>
          </ul>
          <em>
            You can skip this step for now and come back to it once your account
            has been verified.
          </em>
        </div>
      </div>

      <!-- Organization Data Publish -->
      <div>
        <h3 class="pb-[2px] text-[20px] font-bold leading-9 text-n-50">
          Publish Organisation Data
        </h3>
        <div class="text-sm">
          Review the basic information on your organisation and publish it.
        </div>
        <div
          class="mt-3 rounded-lg bg-n-10 pt-[20px] pl-[27px] pb-[20px]"
          :class="{ 'max-h-[270px] overflow-y-auto': hasError }"
        >
          <div class="border-b border-n-20 py-4">
            <p class="flex items-center font-bold">
              <svg-vue
                class="text-base text-bluecoral"
                icon="organisation-elements/building"
              ></svg-vue>
              <span class="ml-1 mr-[10px]">reporting-organisation</span>
              <svg-vue class="text-base text-camel-50" icon="core"></svg-vue>
            </p>
          </div>
          <div class="pt-[18px] pr-5">
            <div class="flex items-center justify-between">
              <p class="text-sm font-bold text-n-50">reporting-org</p>
              <p class="flex items-center gap-1">
                <span class="text-xs text-n-50">Help</span>
                <HoverText
                  name="reporting-org"
                  hover-text="The organisation issuing the report. May be a primary source (reporting on its own activity as donor, implementing agency, etc) or a secondary source (reporting on the activities of another organisation)."
                  :show-iati-reference="true"
                  link="https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/"
                />
              </p>
            </div>
            <div class="grid grid-cols-2 pt-4">
              <!-- Reference -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="reference" class="text-[14px]">
                    reference
                    <span class="required-icon"> *</span>
                  </label>
                  <button>
                    <HoverText
                      name="reference"
                      hover-text="Machine-readable identification string for the organisation issuing the report. Must be in the format {RegistrationAgency}-{RegistrationNumber}."
                      :show-iati-reference="true"
                      link="https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/"
                    />
                  </button>
                </div>
                <input
                  id="reference"
                  v-model="organizationData.ref"
                  class="w-full rounded-[4px] border border-n-20 py-2 pl-4 focus:outline-0 focus-visible:outline-0"
                  :class="{ 'border-crimson-50': hasReferenceError }"
                  type="text"
                  placeholder="Type reference"
                  @keyup="hasReferenceError = false"
                />
                <span v-if="hasReferenceError" class="text-danger error">{{
                  referenceErrorMessage
                }}</span>
                <button
                  class="pt-2 text-xs text-n-40 hover:text-spring-50"
                  @click="showHelp(`reference`)"
                >
                  Help
                </button>
              </div>

              <!-- Type -->
              <div class="w-full max-w-[335px]">
                <div class="flex justify-between pb-2">
                  <label for="type" class="text-[14px]">
                    type
                    <span class="required-icon"> *</span>
                  </label>
                  <button>
                    <HoverText
                      name="type"
                      hover-text="The type of organisation issuing the report."
                      :show-iati-reference="true"
                      link="https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/"
                    />
                  </button>
                </div>
                <Multiselect
                  id="type"
                  class="vue__select"
                  placeholder="Select @type"
                  :searchable="true"
                  :options="props.organizationTypeOptions"
                  :value="organizationData.type"
                  @update:model-value="
                (value:string) => (organizationData.type = value)
              "
                />
                <button
                  class="pt-2 text-xs text-n-40 hover:text-spring-50"
                  @click="showHelp(`type`)"
                >
                  Help
                </button>
              </div>

              <!-- Secondary reporter -->
              <div class="w-full max-w-[335px] pt-6">
                <div class="flex justify-between pb-2">
                  <label for="secondary-reporter" class="text-[14px]">
                    secondary-reporter
                  </label>
                  <button>
                    <HoverText
                      position="top-left"
                      name="secondary-reporter"
                      hover-text="A flag indicating that the reporting organisation of this activity is acting as a secondary reporter. A secondary reporter is one that reproduces data on the activities of an organisation for which it is not directly responsible."
                      :show-iati-reference="true"
                      link="https://iatistandard.org/en/iati-standard/203/organisation-standard/iati-organisations/iati-organisation/reporting-org/"
                    />
                  </button>
                </div>
                <Multiselect
                  id="secondary-reporter"
                  class="vue__select"
                  placeholder="Select secondary-reporter"
                  :searchable="true"
                  :options="secondaryReporterOptions"
                  :value="organizationData.secondary_reporter"
                  @update:model-value="
                (value:string) => (organizationData.secondary_reporter = value)
              "
                />
                <button
                  class="pt-2 text-xs text-n-40 hover:text-spring-50"
                  @click="showHelp(`secondary-reporter`)"
                >
                  Help
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center gap-1 pt-3 text-xs text-n-40">
          <svg-vue icon="message-icon" />
          <span>
            You can adjust these values later from the 'Organisation Data'
            section.
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
            @click="emit('proceedStep')"
          >
            Skip to next step
          </button>
          <button class="button primary-btn text-xs" @click="proceedStep">
            Publish and NEXT
          </button>
        </div>
      </div>
      <Transition name="slide" mode="out-in">
        <SideHelpText
          :title="helpTitle"
          :content="helpContent"
          :visible="helpVisible"
          @close="helpVisible = false"
        />
      </Transition>
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
              >Organisation data has been successfully published.</span
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
            <h2 class="max-w-[693px] py-[5.4px] text-2xl font-bold text-n-50">
              Organisation data has been successfully published.
            </h2>
            <p class="max-w-[587px] text-sm text-n-50">
              If you want to make changes, go to
              <a href="/organisation" target="_blank">Organisation data</a>.
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
import { defineEmits, defineProps, ref } from 'vue';

import Multiselect from '@vueform/multiselect';
import HoverText from 'Components/HoverText.vue';
import SideHelpText from 'Components/SideHelpText.vue';
import axios from 'axios';
import LinesLoader from 'Components/LinesLoader.vue';
import ToastMessage from 'Components/ToastMessage.vue';
import Loader from 'Components/Loader.vue';

const props = defineProps({
  organizationTypeOptions: {
    type: Object,
    required: true,
  },
  previousValues: {
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

const secondaryReporterOptions = [
  { value: '1', label: 'True' },
  { value: '0', label: 'False' },
];

const organizationData = ref({
  ref: props.previousValues[0]?.ref || '',
  type: props.previousValues[0]?.type || '',
  secondary_reporter: props.previousValues[0]?.secondary_reporter || '',
});

const helpTitle = ref('');
const helpContent = ref('');
const helpVisible = ref(false);

const isSaving = ref(false);
const isSaved = ref(false);

const hasError = ref(false);
const errorMessages = ref<string[]>([]);

const isLoaderVisible = ref(false);

const toastVisibility = ref(false);
const toastMessage = ref('');
const toastType = ref(false);

const hasReferenceError = ref(false);
const referenceErrorMessage = ref('');

const contentValues = [
  {
    title: 'reference',
    content:
      '<div class="space-y-1.5"> Provide the IATI Organisation Identifier of the organisation publishing the data. The quickest way to find this is to search for the organisation in the <a target="_blank" href="https://www.iatiregistry.org/publisher/">IATI Publisher List</a>. If you cannot find the organisation, see <a target="_blank" href="https://iatistandard.org/en/guidance/publishing-data/data-quality-and-visualisation/finding-other-organisations-identifiers/">further guidance</a>. </div>',
  },
  {
    title: 'type',
    content:
      '<div class="space-y-1.5"> Select the type that best describes the organisation publishing the data.<a target="_blank" href="https://iatistandard.org/en/iati-standard/203/codelists/organisationtype/">Information on all organisation types.</a></div>',
  },
  {
    title: 'secondary-reporter',
    content: `<div class="space-y-1.5"> Are you reproducing the data reported by another organisation? If so, your organisation is a ‘secondary reporter’ and you should select '<b>Yes</b>’. If you are reporting your own organisation’s data, select ‘<b>No</b>’.<br><br>Please note: you are <b>not</b> a secondary reporter if your organisation is officially assigned as a proxy to report IATI data on behalf of another organisation. </div>`,
  },
];

const showHelp = (title: string) => {
  helpTitle.value = title;
  helpContent.value = contentValues.find((content) => content.title === title)
    ?.content as string;
  helpVisible.value = true;
};

const resendVerificationEmail = () => {
  isLoaderVisible.value = true;
  axios
    .post('/user/verification/email')
    .then((res) => {
      toastVisibility.value = true;
      setTimeout(() => (toastVisibility.value = false), 3000);
      toastMessage.value = res.data.message;
      toastType.value = res.data.success;
      isLoaderVisible.value = false;
    })
    .catch((error) => {
      toastVisibility.value = true;
      setTimeout(() => (toastVisibility.value = false), 3000);
      toastMessage.value = error.data.message;
      toastType.value = false;
      isLoaderVisible.value = false;
    });
};

document.addEventListener('click', (e) => {
  if ((e.target as HTMLElement).classList.contains('resend-verification')) {
    resendVerificationEmail();
  }
});

const transformMessages = (messages: string[]): string[] => {
  return messages.map((message) => {
    switch (message) {
      case 'You have not verified your email address.':
        return `Your email address has not been verified. <span class="resend-verification text-bluecoral cursor-pointer hover:text-spring-50 underline transition-all duration-[400ms]">Resend Verification email</span>`;

      case 'The Publisher ID is not verified in IATI Registry.':
        return 'Your IATI Registry account is pending approval. Contact <a href="mailto:support@iatistandard.org">support@iatistandard.org</a> if your account has not been approved within two working days of registering.';

      default:
        return message;
    }
  });
};

const previousStep = () => {
  emit('previousStep');
};

const proceedStep = () => {
  hasError.value = false;
  isSaving.value = true;
  const finalData = [
    {
      ...organizationData.value,
      narrative: props.previousValues[0]?.narrative || '',
    },
  ];

  axios
    .put('/organisation/reporting_org', {
      reporting_org: finalData,
    })
    .then(() => {
      axios
        .get('organisation/checks-for-organisation-publish')
        .then((response: { data: { success: boolean; message: string[] } }) => {
          if (response.data.success) {
            axios
              .post('/organisation/publish')
              .then(
                (response: {
                  data: { success: boolean; message: string[] };
                }) => {
                  if (response.data.success) {
                    setTimeout(() => {
                      isSaved.value = true;
                    }, 1000);
                    setTimeout(() => {
                      props.fetchData();
                      emit('completeStep', 3);
                      emit('proceedStep');
                    }, 4000);
                  } else {
                    hasError.value = true;
                    errorMessages.value = transformMessages(
                      response.data.message
                    );
                    isSaving.value = false;
                    isSaved.value = false;
                  }
                }
              );
          } else {
            hasError.value = true;
            errorMessages.value = transformMessages(response.data.message);

            isSaving.value = false;
            isSaved.value = false;
          }
        })
        .catch((err) => {
          console.log('Error', err);
          isSaving.value = false;
          isSaved.value = false;
        });
    })
    .catch((err) => {
      emit('removeCompletedStep', 3);
      if (err.response && err.response.data && err.response.data.errors) {
        const errors = err.response.data.errors;

        if (errors['reporting_org.0.ref']) {
          hasReferenceError.value = true;
          referenceErrorMessage.value = errors['reporting_org.0.ref'][0];
        }
      }

      isSaving.value = false;
      isSaved.value = false;
    });
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

.slide-enter-active,
.slide-leave-active {
  transition: all 0.5s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
</style>
