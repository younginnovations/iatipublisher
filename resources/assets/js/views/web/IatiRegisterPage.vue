<template>
  <section
    class="section register-page mx-3 mb-7 sm:mx-10 sm:mb-10 md:mb-14 xl:mx-24 xl:px-1"
  >
    <Loader v-if="isLoaderVisible" />
    <div class="section__container">
      <div class="section__title">
        <h2 class="text-2xl md:text-4xl">
          {{ language.register_lang.create_iati_publisher_header }}
        </h2>
        <p>
          {{ language.register_lang.create_iati_publisher_subheader }}
        </p>
      </div>
      <div class="section__wrapper flex justify-center">
        <EmailVerification v-if="checkStep('5')" :email="formData['email']" />
        <div v-else class="form input__field" @keyup.enter="goToNextForm">
          <aside class="mb-4 block border-b border-b-n-10 pb-4 xl:hidden">
            <span class="text-base font-bold"
              >{{ language.button_lang.step }} {{ getCurrentStep() }}
              {{ language.button_lang.out_of }} 5</span
            >
            <ul class="relative mt-3 text-sm text-n-40">
              <li
                v-for="(form, key, i) in registerForm"
                :key="i"
                :class="{
                  'relative font-bold text-n-50': checkStep(key),
                  'mb-6 hidden': !checkStep(key),
                }"
              >
                <span v-if="checkStep(key)" class="list__active" />
                <div class="flex items-center">
                  <span v-if="!form['is_complete']" class="mr-3">
                    {{ i + 1 }}
                  </span>
                  <span
                    class="font-bold"
                    :class="{
                      'text-n-50': checkStep(key),
                      'text-bluecoral': !checkStep(key) && form.is_complete,
                      'text-n-40': !checkStep(key) && !form.is_complete,
                    }"
                  >
                    {{ form['title'] }}
                  </span>
                </div>
                <p v-if="checkStep(key)" class="detail mt-2 font-normal">
                  {{ form['description'] }}
                </p>
              </li>
            </ul>
          </aside>
          <div class="form__container">
            <div class="flex items-center space-x-1">
              <HoverText
                v-if="registerForm[getCurrentStep()]['hover_text']"
                :hover-text="registerForm[getCurrentStep()]['hover_text']"
                :name="registerForm[getCurrentStep()].title"
                position="right"
              />
              <span class="text-xl font-bold text-n-50 sm:text-2xl">{{
                registerForm[getCurrentStep()].title
              }}</span>
            </div>
            <div
              v-if="Object.keys(iatiError).length > 0"
              class="feedback mt-6 border-l-2 border-crimson-50 bg-crimson-10 p-4 text-sm text-n-50"
            >
              <p class="mb-2 flex font-bold">
                <svg-vue class="mr-2 text-xl" icon="warning" />
                {{ language.common_lang.error.default }}:
              </p>
              <div class="ml-8 xl:mr-1">
                <ul class="list-disc">
                  <li v-for="(error, error_key) in iatiError" :key="error_key">
                    <span v-if="typeof error === 'object'">{{ error[0] }}</span>
                    <span v-else>{{ error }}</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="form__content">
              <div
                v-for="(field, index, key) in registerForm[getCurrentStep()][
                  'fields'
                ]"
                :key="key"
                :class="field.class"
              >
                <div class="mb-2 flex items-center justify-between">
                  <label :for="field.id" class="label"
                    >{{ field['label'] }}
                    <span v-if="field.required" class="text-salmon-40"> *</span>
                  </label>
                  <HoverText
                    v-if="field.hover_text !== ''"
                    :hover-text="field.hover_text"
                    :name="field.label"
                  />
                </div>
                <input
                  v-if="isTextField(field.type, field.name)"
                  :id="field.id"
                  v-model="formData[field.name]"
                  :class="{
                    'error_input form__input': errorData[field.name],
                    form__input: !errorData[field.name],
                  }"
                  :placeholder="field.placeholder"
                  :type="field.type"
                />
                <textarea
                  v-if="field.type === 'textarea'"
                  ref="textarea"
                  v-model="formData[field.name]"
                  :placeholder="field.placeholder"
                  :class="{
                    'error_input form__input ': errorData[field.name],
                    'form__input ': !errorData[field.name],
                  }"
                  @focus="resize($event)"
                  @keyup="resize($event)"
                  @keyup.enter.stop
                />

                <input
                  v-if="field.name === 'identifier'"
                  v-model="formData[field.name]"
                  :class="{
                    'error_input form__input': errorData[field.name],
                    form__input: !errorData[field.name],
                  }"
                  :placeholder="field.placeholder"
                  :type="field.type"
                  disabled="true"
                />

                <Multiselect
                  v-if="field.type === 'select'"
                  v-model="formData[field.name]"
                  :class="{
                    'error_input vue__select': errorData[field.name],
                    vue__select: !errorData[field.name],
                  }"
                  :options="field.options"
                  :placeholder="field.placeholder"
                  :searchable="true"
                />
                <span
                  v-if="field.help_text && errorData[field.name] === ''"
                  class="text-xs font-normal text-n-40"
                  >{{ field.help_text }}
                </span>

                <span
                  v-if="errorData[field.name] !== ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData[field.name] }}
                </span>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap items-center justify-between">
            <button
              v-if="!checkStep(1)"
              class="btn-back"
              @click="goToPreviousForm()"
            >
              <svg-vue class="mr-3 cursor-pointer" icon="left-arrow" />
              {{ language.button_lang.go_back }}
            </button>
            <span
              v-if="checkStep(1)"
              class="pb-4 text-sm font-normal text-n-40 sm:pb-0"
              >{{ language.common_lang.already_have_account }}
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
                href="/"
                >{{ language.button_lang.sign_in }}.</a
              ></span
            >
            <button
              v-if="!checkStep(5)"
              class="btn btn-next"
              @click="goToNextForm()"
            >
              {{ language.button_lang.next_step }}
              <svg-vue class="text-2xl" icon="right-arrow" />
            </button>
          </div>
          <div v-if="checkStep(2)" class="mt-6 text-center">
            <span class="text-sm font-normal text-n-40"
              >{{ language.common_lang.already_have_account }}
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
                href="/"
                >{{ language.button_lang.sign_in }}.</a
              ></span
            >
          </div>
        </div>

        <aside class="register__sidebar hidden xl:block">
          <span class="text-base font-bold"
            >Step {{ getCurrentStep() }} out of 5</span
          >
          <ul class="relative mt-6 text-sm text-n-40">
            <li
              v-for="(form, key, i) in registerForm"
              :key="i"
              :class="{
                'relative font-bold text-n-50': checkStep(key),
                'mb-6 flex items-center': !checkStep(key),
              }"
            >
              <span v-if="checkStep(key)" class="list__active" />
              <div class="flex items-center">
                <span v-if="!form['is_complete']" class="ml-6 mr-3">
                  {{ i + 1 }}
                </span>
                <span v-if="form['is_complete']" class="ml-6 mr-3">
                  <svg-vue class="text-xs" icon="checked"> </svg-vue>
                </span>
                <span
                  :class="{
                    'font-bold text-n-50 ': checkStep(key),
                    'text-bluecoral': !checkStep(key) && form.is_complete,
                    'text-n-40': !checkStep(key) && !form.is_complete,
                  }"
                >
                  {{ form['title'] }}
                </span>
              </div>
              <p
                v-if="checkStep(key)"
                class="detail mt-2 mb-6 font-normal xl:pr-2"
              >
                {{ form['description'] }}
              </p>
            </li>
          </ul>
        </aside>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { computed, defineComponent, reactive, ref, watch } from 'vue';
import axios from 'axios';
import EmailVerification from './EmailVerification.vue';
import HoverText from './../../components/HoverText.vue';
import Multiselect from '@vueform/multiselect';
import Loader from '../../components/Loader.vue';
import encrypt from 'Composable/encryption';

export default defineComponent({
  components: {
    EmailVerification,
    HoverText,
    Multiselect,
    Loader,
  },

  props: {
    types: {
      type: Object,
      required: true,
    },
  },

  setup(props) {
    const language = window['globalLang'];
    const step = ref(1);
    const publisherExists = ref(true);
    const isLoaderVisible = ref(false);
    const textarea = ref(null);
    interface ObjectType {
      [key: string]: string;
    }

    const errorData: ObjectType = reactive({
      publisher_name: '',
      publisher_id: '',
      country: '',
      registration_agency: '',
      registration_number: '',
      identifier: '',
      publisher_type: '',
      license_id: '',
      image_url: '',
      description: '',
      contact_email: '',
      website: '',
      address: '',
      source: '',
      record_exclusions: '',
      username: '',
      full_name: '',
      email: '',
      password: '',
      password_confirmation: '',
    });

    const iatiError: ObjectType = reactive({});

    const formData: ObjectType = reactive({
      publisher_name: '',
      publisher_id: '',
      country: '',
      registration_agency: '',
      registration_number: '',
      identifier: '',
      publisher_type: '',
      license_id: '',
      image_url: '',
      description: '',
      contact_email: '',
      website: '',
      address: '',
      source: '',
      record_exclusions: '',
      username: '',
      full_name: '',
      email: '',
      password: '',
      password_confirmation: '',
      step: '1',
    });

    watch(
      () => formData.country,
      () => {
        formData.registration_agency = '';
      }
    );
    function resize(event) {
      event.target.style.height = 'auto';
      event.target.style.height = `${event.target.scrollHeight}px`;
    }

    watch(
      () => [formData.registration_agency, formData.registration_number],
      () => {
        formData.identifier = formData.registration_agency
          ? formData.registration_agency + '-' + formData.registration_number
          : formData.registration_number;
      },
      { deep: true }
    );

    const registration_agency = computed(() => {
      const agencies = props.types.registrationAgency;

      if (formData.country) {
        const uncategorized = ['XI', 'XR'];

        return Object.fromEntries(
          Object.entries(agencies).filter(
            ([key]) =>
              key.startsWith(formData.country) ||
              uncategorized.some((k) => key.startsWith(k))
          )
        );
      } else {
        return agencies;
      }
    });

    const isTextField = computed(() => {
      return (fieldType: string, fieldName: string) => {
        return (
          (fieldType === 'text' ||
            fieldType === 'password' ||
            fieldType === 'email') &&
          fieldName != 'identifier'
        );
      };
    });

    const checkStep = computed(() => {
      return (formStep: string | number) => {
        return parseInt(formStep.toString()) === step.value;
      };
    });

    /**
     * object with multi-step form information
     */
    const registerForm = reactive({
      1: {
        title: language.register_lang.publisher_information.label,
        is_complete: false,
        description: language.register_lang.publisher_information.description,
        hover_text: language.register_lang.publisher_information.hover_text,
        fields: {
          publisher_name: {
            label: language.register_lang.publisher_name.label,
            name: 'publisher_name',
            placeholder: language.register_lang.publisher_name.placeholder,
            id: 'publisher-name',
            required: true,
            hover_text: language.register_lang.publisher_name.hover_text,
            type: 'text',
            class: 'col-span-2 mb-4 lg:mb-2',
            help_text: '',
          },
          publisher_id: {
            label: language.register_lang.publisher_id.label,
            name: 'publisher_id',
            placeholder: language.register_lang.publisher_id.placeholder,
            id: 'publisher-id',
            required: true,
            hover_text: language.register_lang.publisher_id.hover_text,
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: '',
          },
          country: {
            label: language.register_lang.country.label,
            name: 'country',
            placeholder: language.register_lang.country.placeholder,
            id: 'country_select',
            required: false,
            type: 'select',
            hover_text: language.register_lang.country.hover_text,
            options: props.types.country,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          registration_agency: {
            label: language.register_lang.org_registration_agency.label,
            name: 'registration_agency',
            placeholder:
              language.register_lang.org_registration_agency.placeholder,
            id: 'registration-agency',
            required: true,
            hover_text:
              language.register_lang.org_registration_agency.hover_text,
            type: 'select',
            options: registration_agency,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          registration_number: {
            label: language.register_lang.registration_number.label,
            name: 'registration_number',
            placeholder: language.register_lang.registration_number.placeholder,
            id: 'registration-number',
            required: true,
            hover_text: language.register_lang.registration_number.hover_text,
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: `${language.register_lang.for_eg} 123456`,
          },
          identifier: {
            label: language.register_lang.iati_org_identifier.label,
            name: 'identifier',
            placeholder: '',
            id: 'identifier',
            required: true,
            hover_text: language.register_lang.iati_org_identifier.hover_text,
            type: 'text',
            class: 'mb-4 lg:mb-6',
            help_text: language.register_lang.iati_org_identifier.help_text,
          },
          publisher_type: {
            label: language.register_lang.publisher_type.label,
            name: 'publisher_type',
            placeholder: language.register_lang.publisher_type.placeholder,
            id: 'publisher-type',
            required: true,
            hover_text: language.register_lang.publisher_type.hover_text,
            type: 'select',
            options: props.types.publisherType,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          license_id: {
            label: language.register_lang.data_license.label,
            name: 'license_id',
            placeholder: language.register_lang.data_license.placeholder,
            id: 'data-license',
            required: true,
            hover_text: language.register_lang.data_license.hover_text,
            type: 'select',
            options: props.types.dataLicense,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          image_url: {
            label: language.register_lang.publisher_logo_url.label,
            name: 'image_url',
            placeholder: `${language.register_lang.for_eg} http://mylogo.com `,
            id: 'publisher-logo-url',
            required: false,
            hover_text: language.register_lang.publisher_logo_url.hover_text,
            type: 'text',
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          description: {
            label: language.register_lang.organisation_desc.label,
            name: 'description',
            placeholder: language.register_lang.organisation_desc.placeholder,
            id: 'organization-description',
            required: false,
            hover_text: language.register_lang.organisation_desc.hover_text,
            type: 'textarea',
            class: 'mb-4 col-span-2 lg:mb-2 relative',
            help_text: '',
          },
        },
      },
      2: {
        title: language.register_lang.contact_info.title,
        is_complete: false,
        description: language.register_lang.publisher_information.description,
        fields: {
          contact_email: {
            label: language.register_lang.contact.label,
            name: 'contact_email',
            placeholder: '',
            id: 'contact-email',
            required: true,
            hover_text: language.register_lang.contact.hover_text,
            type: 'text',
            class: 'mb-4  lg:mb-6',
          },
          website: {
            label: language.register_lang.website.label,
            name: 'website',
            placeholder: `${language.register_lang.for_eg} http://mywebsite.com`,
            id: 'website',
            required: false,
            hover_text: language.register_lang.website.hover_text,
            type: 'text',
            class: 'mb-4 lg:mb-6',
          },
          address: {
            label: language.register_lang.address.label,
            name: 'address',
            placeholder: language.register_lang.address.placeholder,
            id: 'address',
            required: false,
            hover_text: language.register_lang.address.hover_text,
            type: 'textarea',
            class: 'mb-4 col-span-2 lg:mb-6',
          },
        },
      },
      3: {
        title: language.register_lang.publishing_additional_info.title,
        is_complete: false,
        description:
          language.register_lang.publishing_additional_info.description,
        fields: {
          source: {
            label: language.register_lang.source.label,
            name: 'source',
            placeholder: language.register_lang.source.placeholder,
            id: 'contact-email',
            required: true,
            hover_text: language.register_lang.source.hover_text,
            type: 'select',
            options: props.types.source,
            class: 'mb-4 lg:mb-6',
          },
          record_exclusions: {
            label: language.register_lang.record_exclusions.label,
            name: 'record_exclusions',
            placeholder: language.register_lang.record_exclusions.placeholder,
            id: 'record-exclusions',
            required: false,
            hover_text: language.register_lang.record_exclusions.hover_text,
            type: 'textarea',
            class: 'mb-4  col-span-2 lg:mb-6',
          },
        },
      },
      4: {
        title: language.register_lang.administrator_information.label,
        is_complete: false,
        description:
          language.register_lang.administrator_information
            .iati_register_description,
        fields: {
          username: {
            label: language.register_lang.username.label,
            name: 'username',
            placeholder: language.register_lang.username.placeholder,
            id: 'username',
            required: true,
            hover_text: language.register_lang.username.hover_text,
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: '',
          },
          full_name: {
            label: language.register_lang.fullname.label,
            name: 'full_name',
            placeholder: language.register_lang.fullname.placeholder,
            id: 'full-name',
            hover_text: '',
            required: true,
            type: 'text',
            class: 'col-start-1 mb-4 lg:mb-2',
          },
          email: {
            label: language.register_lang.email_address.label,
            name: 'email',
            placeholder: language.register_lang.email_address.placeholder,
            id: 'email',
            required: true,
            hover_text: '',
            type: 'email',
            class: 'mb-4 lg:mb-2',
          },
          password: {
            label: language.register_lang.password.label,
            name: 'password',
            placeholder: language.register_lang.password.placeholder,
            id: 'password',
            required: true,
            help_text: language.register_lang.password.help_text,
            type: 'password',
            class: 'mb-4 lg:mb-2',
          },
          password_confirmation: {
            label: language.register_lang.password.confirm,
            name: 'password_confirmation',
            placeholder: language.register_lang.password.placeholder,
            id: 'password-confirmation',
            required: true,
            help_text: language.register_lang.password.confirm_help,
            type: 'password',
            class: 'mb-4 lg:mb-6',
          },
        },
      },
      5: {
        title: language.register_lang.email_verification.title,
        is_complete: false,
        description: language.register_lang.email_verification.description,
      },
    });

    /**
     * Update Validation errors from api into errorData array
     */
    function updateValidationErrors(errorResponse) {
      cleanValidationErrors();
      for (const field in errorData) {
        errorData[field] = errorResponse[field] ? errorResponse[field][0] : '';
      }
    }

    /**
     * Update Validation errors from api into errorData array
     */
    function cleanValidationErrors() {
      for (const field in errorData) {
        errorData[field] = '';
      }
    }

    /**
     * Update IATI and system Error
     */
    function updateErrors(errorResponse) {
      if (
        Object.values(errorData).every((value) => value === '') ||
        step.value === 4
      ) {
        Object.assign(
          iatiError,
          typeof errorResponse === 'string'
            ? { error: errorResponse }
            : errorResponse
        );

        setTimeout(() => {
          cleanIatiErrors();
        }, 35000);
      }
    }

    function cleanIatiErrors() {
      for (const err in iatiError) {
        delete iatiError[err];
      }
    }

    /**
     * Verifies publisher
     */
    function verifyPublisher() {
      isLoaderVisible.value = true;

      formData.identifier = `${formData.registration_agency}-${formData.registration_number}`;
      formData.step = '1';

      let form = {
        password: encrypt(
          formData.password,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
      };

      axios
        .post('/iati/register/publisher', { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes('activities')) {
            window.location.href = '/activities';
          }

          const response = res.data;
          publisherExists.value = true;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];
          registerForm['1'].is_complete = false;

          if ('publisher_error' in response) {
            publisherExists.value = false;
          }

          if (response.success) {
            cleanValidationErrors();
            registerForm['1'].is_complete = true;

            updateStep(1);
          } else {
            updateValidationErrors(errors);
            updateErrors(errors);
          }

          isLoaderVisible.value = false;
        })
        .catch((err) => {
          updateErrors(err);
          isLoaderVisible.value = false;
        });
    }

    /**
     * Submits registration Form
     */
    function verifyContactInformation() {
      isLoaderVisible.value = true;
      formData.step = '2';

      let form = {
        password: encrypt(
          formData.password,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
      };

      axios
        .post('/iati/register/contact', { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes('activities')) {
            window.location.href = '/activities';
          }

          const response = res.data;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];

          updateValidationErrors(errors);
          isLoaderVisible.value = false;
          registerForm['2'].is_complete = false;

          if (response.success) {
            cleanValidationErrors();
            registerForm['2'].is_complete = true;
            updateStep(2);
          } else {
            updateErrors(errors);
          }
        })
        .catch((error) => {
          updateErrors(error);
          isLoaderVisible.value = false;
        });
    }

    /**
     * Submits registration Form
     */
    function verifyAdditionalInformation() {
      isLoaderVisible.value = true;
      formData.step = '3';

      let form = {
        password: encrypt(
          formData.password,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
      };

      axios
        .post('/iati/register/additional', { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes('activities')) {
            window.location.href = '/activities';
          }

          const response = res.data;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];
          updateValidationErrors(errors);
          isLoaderVisible.value = false;
          registerForm['3'].is_complete = false;

          if (response.success) {
            cleanValidationErrors();
            registerForm['3'].is_complete = true;
            updateStep(3);
          } else {
            updateErrors(errors);
          }
        })
        .catch((error) => {
          updateErrors(error);
          isLoaderVisible.value = false;
        });
    }

    /**
     * Submits registration Form
     */
    function submitForm() {
      isLoaderVisible.value = true;
      formData.step = '4';

      let form = {
        password: encrypt(
          formData.password,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ''
        ),
      };

      axios
        .post('/iati/register', { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes('activities')) {
            window.location.href = '/activities';
          }

          const response = res.data;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];
          updateValidationErrors(errors);
          cleanIatiErrors();
          Object.assign(iatiError, errors);
          isLoaderVisible.value = false;
          registerForm['4'].is_complete = false;

          if (response.success) {
            cleanValidationErrors();
            registerForm['4'].is_complete = true;
            updateStep(4);
          }
        })
        .catch((error) => {
          updateErrors(error);

          isLoaderVisible.value = false;
        });
    }

    function getCurrentStep() {
      return step.value.toString();
    }

    function updateStep(current_step) {
      if (current_step === step.value) {
        step.value += 1;
      }
    }

    /**
     * calls submit function based on current step value
     */
    function goToNextForm() {
      switch (step.value) {
        case 1:
          verifyPublisher();
          break;
        case 2:
          verifyContactInformation();
          break;
        case 3:
          verifyAdditionalInformation();
          break;
        case 4:
          submitForm();
          break;
      }
    }

    function goToPreviousForm() {
      cleanIatiErrors();
      step.value -= 1;
    }

    return {
      registerForm,
      formData,
      errorData,
      publisherExists,
      isLoaderVisible,
      goToNextForm,
      goToPreviousForm,
      getCurrentStep,
      checkStep,
      iatiError,
      isTextField,
      props,
      step,
      resize,
      textarea,
      language,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<style lang="scss">
.label {
  @apply text-sm font-normal text-n-50;
}

.section {
  &__container {
    @media screen and (min-width: 1280px) {
      max-width: 1206px;
    }
    max-width: 865px;
    margin: auto;

    .feedback {
      @media screen and (min-width: 1280px) {
        width: 702px;
      }

      p {
        line-height: 22px;
      }
    }

    .section__wrapper {
      box-shadow: 0px 20px 40px 20px rgba(0, 0, 0, 0.05);

      .verification {
        font-size: 190px;
      }
    }

    .section__title {
      @media screen and (min-width: 440px) {
        @apply leading-9;
      }

      @apply my-7 mx-3 text-center leading-7 sm:leading-10 lg:mb-10 lg:mt-14;

      p {
        font-weight: normal;
        font-style: normal;
        @apply text-sm text-n-40 sm:text-base;
      }
    }

    .register__sidebar {
      @apply bg-eggshell;
      padding: 96px 32px 40px;
      width: 344px;

      ul {
        width: 253px;
      }

      ul::before {
        content: '';
        width: 4px;
        height: 100%;
        @apply bg-n-20;
        border-radius: 2px;
        position: absolute;
        left: 0px;
        top: 0px;
      }

      .detail {
        margin-left: 45px;
      }

      .list__active::after {
        position: absolute;
        top: 0;
        left: -1px;
        width: 6px;
        height: 85px;
        @apply bg-turquoise;
        content: '';
        border-radius: 2px;
        z-index: 5;
      }
    }
  }
}

.form {
  @apply bg-white p-5 sm:px-10 sm:py-10 lg:px-20;
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
  width: 862px;

  &__container {
    @apply border-b-2 border-b-n-10;
    margin-bottom: 24px;

    .error__input {
      @apply border border-crimson-50;
    }
  }

  &__content {
    margin-top: 24px;
  }
}

@media screen and (min-width: 1024px) {
  .form__content {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
  }
}
</style>
