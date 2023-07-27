<template>
  <section
    class="section mx-3 mb-7 sm:mx-10 sm:mb-10 md:mb-14 xl:mx-24 xl:px-1"
  >
    <Loader v-if="isLoaderVisible" />
    <div class="section__container">
      <div class="section__title">
        <h2>{{ translate.registerText('create_iati_publisher_header') }}</h2>
        <p>
          {{ translate.registerText('create_iati_publisher_subheader') }}
        </p>
      </div>
      <div class="section__wrapper flex justify-center">
        <EmailVerification v-if="checkStep('3')" :email="formData['email']" />
        <div v-else class="form input__field" @keyup.enter="goToNextForm">
          <aside class="mb-4 block border-b border-b-n-10 pb-4 xl:hidden">
            <span class="text-base font-bold"
              >{{ translate.button('step') }} {{ getCurrentStep() }}
              {{ translate.button('out_of') }} 3</span
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
              v-if="!publisherExists"
              class="feedback mt-6 border-l-2 border-crimson-50 bg-crimson-10 p-4 text-sm text-n-50 xl:h-32"
            >
              <p class="mb-2 flex font-bold">
                <svg-vue class="mr-2 text-xl" icon="warning" />
                {{
                  translate.registerText('information_doesnt_match_registry')
                }}
              </p>
              <p class="ml-8 xl:mr-1">
                {{ translate.registerText('if_you_are_account_holder') }}
                <span
                  ><a href="https://iatiregistry.org/">{{
                    translate.commonText('iati_registry')
                  }}</a></span
                >, {{ translate.registerText('make_sure_your') }}
                <span class="font-bold"
                  >{{ translate.registerText('publisher_name.label') }},
                  {{ translate.registerText('publisher_id.label') }}
                  {{ translate.commonText('and') }} IATI
                  {{ translate.commonText('organisation_id') }}</span
                >
                {{ translate.registerText('match_your_iati_registry_info') }}.
                {{ translate.commonText('contact') }}
                <span
                  ><a
                    class="text-bluecoral"
                    href="mailto:support@iatistandard.org"
                    >support@iatistandard.org</a
                  ></span
                >
                {{ translate.commonText('for_more_details') }}.
              </p>
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
              {{ translate.button('go_back') }}
            </button>
            <span
              v-if="checkStep(1)"
              class="pb-4 text-sm font-normal text-n-40 sm:pb-0"
              >{{ translate.commonText('already_have_account') }}
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
                href="/"
                >{{ translate.button('sign_in') }}.</a
              ></span
            >
            <button
              v-if="!checkStep(3)"
              class="btn btn-next"
              @click="goToNextForm()"
            >
              {{ translate.button('next_step') }}
              <svg-vue class="text-2xl" icon="right-arrow" />
            </button>
          </div>
          <div v-if="checkStep(2)" class="mt-6 text-center">
            <span class="text-sm font-normal text-n-40"
              >{{ translate.commonText('already_have_account') }}
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
                href="/"
                >{{ translate.button('sign_in') }}.</a
              ></span
            >
          </div>
        </div>

        <aside class="register__sidebar hidden xl:block">
          <span class="text-base font-bold"
            >{{ translate.button('step') }} {{ getCurrentStep() }}
            {{ translate.button('out_of') }} 3</span
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
import { computed, defineComponent, reactive, ref, watch, toRefs } from 'vue';
import axios from 'axios';
import EmailVerification from './EmailVerification.vue';
import HoverText from './../../components/HoverText.vue';
import Multiselect from '@vueform/multiselect';
import Loader from '../../components/Loader.vue';
import encrypt from 'Composable/encryption';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  components: {
    EmailVerification,
    HoverText,
    Multiselect,
    Loader,
  },

  props: {
    country: {
      type: [String, Object],
      required: true,
    },
    agency: {
      type: [String, Object],
      required: true,
    },
    uncategorizedOrganisationRegistrationAgency: {
      type: [Object],
      required: true,
    },
  },

  setup(props) {
    const translate = new Translate();
    const step = ref(1);
    const publisherExists = ref(true);
    const isLoaderVisible = ref(false);

    let { agency } = toRefs(props);

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
      username: '',
      full_name: '',
      email: '',
      password: '',
      password_confirmation: '',
    });

    const formData: ObjectType = reactive({
      publisher_name: '',
      publisher_id: '',
      country: '',
      registration_agency: '',
      registration_number: '',
      identifier: '',
      username: '',
      full_name: '',
      email: '',
      password: '',
      password_confirmation: '',
    });

    watch(
      () => formData.country,
      () => {
        formData.registration_agency = '';
      }
    );

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
      const agencies = agency.value;

      if (formData.country) {
        const uncategorized = props.uncategorizedOrganisationRegistrationAgency;

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

    const registerForm = reactive({
      1: {
        title: translate.registerText('publisher_information.label'),
        is_complete: false,
        description: translate.registerText(
          'publisher_information.description'
        ),
        hover_text: translate.registerText('publisher_information.hover_text'),
        fields: {
          publisher_name: {
            label: translate.registerText('publisher_name.label'),
            name: 'publisher_name',
            placeholder: translate.registerText('publisher_name.placeholder'),
            id: 'publisher-name',
            required: true,
            hover_text: translate.registerText('publisher_name.hover_text'),
            type: 'text',
            class: 'col-span-2 mb-4 lg:mb-2',
            help_text: '',
          },
          publisher_id: {
            label: translate.registerText('publisher_id.label'),
            name: 'publisher_id',
            placeholder: translate.registerText('publisher_id.placeholder'),
            id: 'publisher-id',
            required: true,
            hover_text: translate.registerText('publisher_id.hover_text'),
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: '',
          },
          country: {
            label: translate.registerText('country.label'),
            name: 'country',
            placeholder: translate.registerText('country.placeholder'),
            id: 'country_select',
            required: false,
            type: 'select',
            hover_text: translate.registerText('country.hover_text'),
            options: props.country,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          organization_registration_agency: {
            label: translate.registerText('org_registration_agency.label'),
            name: 'registration_agency',
            placeholder: translate.registerText(
              'org_registration_agency.placeholder'
            ),
            id: 'registration-agency',
            required: true,
            hover_text: translate.registerText(
              'org_registration_agency.hover_text'
            ),
            type: 'select',
            options: registration_agency,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          organization_registration_no: {
            label: translate.registerText('org_registration_no.label'),
            name: 'registration_number',
            placeholder: translate.registerText(
              'org_registration_no.placeholder'
            ),
            id: 'registration-number',
            required: true,
            hover_text: translate.registerText(
              'org_registration_no.hover_text'
            ),
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: `${translate.registerText('for_eg')} 123456`,
          },
          iati_organizational_identifier: {
            label: translate.registerText('iati_org_identifier.label'),
            name: 'identifier',
            placeholder: '',
            id: 'identifier',
            required: true,
            hover_text: translate.registerText(
              'iati_org_identifier.hover_text'
            ),
            type: 'text',
            class: 'mb-4 lg:mb-6',
            help_text: translate.registerText('iati_org_identifier.help_text'),
          },
        },
      },
      2: {
        title: translate.registerText('administrator_information.label'),
        is_complete: false,
        description: translate.registerText(
          'administrator_information.register_description'
        ),
        hover_text: translate.registerText(
          'administrator_information.hover_text'
        ),
        fields: {
          username: {
            label: translate.registerText('username.label'),
            name: 'username',
            placeholder: translate.registerText('username.placeholder'),
            id: 'username',
            required: true,
            hover_text: translate.registerText('username.hover_text'),
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: '',
          },
          full_name: {
            label: translate.registerText('fullname.label'),
            name: 'full_name',
            placeholder: translate.registerText('fullname.placeholder'),
            id: 'full-name',
            hover_text: '',
            required: true,
            type: 'text',
            class: 'col-start-1 mb-4 lg:mb-2',
          },
          email: {
            label: translate.registerText('email_address.label'),
            name: 'email',
            placeholder: translate.registerText('email_address.placeholder'),
            id: 'email',
            required: true,
            hover_text: '',
            type: 'email',
            class: 'mb-4 lg:mb-2',
          },
          password: {
            label: translate.registerText('password.label'),
            name: 'password',
            placeholder: translate.registerText('password.placeholder'),
            id: 'password',
            required: true,
            hover_text: '',
            type: 'password',
            class: 'mb-4 lg:mb-2',
          },
          confirm_password: {
            label: translate.registerText('password.confirm'),
            name: 'password_confirmation',
            placeholder: translate.registerText('password.placeholder'),
            id: 'password-confirmation',
            required: true,
            hover_text: '',
            type: 'password',
            class: 'mb-4 lg:mb-6',
          },
        },
      },
      3: {
        title: translate.registerText('email_verification.title'),
        is_complete: false,
        description: translate.registerText('email_verification.description'),
      },
    });

    const updateFormErrors = (errors = []) => {
      const errorLength = Object.keys(errors).length;

      if (errorLength === 0) {
        for (const errKey in errorData) {
          errorData[errKey] = '';
        }
      }

      if (errorLength > 0) {
        for (const errKey in errorData) {
          errorData[errKey] = errKey in errors ? errors[errKey][0] : '';
        }
      }
    };

    function verifyPublisher() {
      isLoaderVisible.value = true;

      formData.identifier = `${formData.registration_agency}-${formData.registration_number}`;

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
        .post('/verifyPublisher', { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes('activities')) {
            window.location.href = '/activities';
          }

          const response = res.data;
          publisherExists.value = true;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];

          updateFormErrors(errors);

          if ('publisher_error' in response) {
            publisherExists.value = false;
          }

          if (response.success) {
            registerForm['1'].is_complete = true;
            step.value += 1;
          }

          isLoaderVisible.value = false;
        })
        .catch(() => {
          isLoaderVisible.value = false;
        });
    }

    function submitForm() {
      isLoaderVisible.value = true;

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
        .post('/register', { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes('activities')) {
            window.location.href = '/activities';
          }

          const response = res.data;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];
          updateFormErrors(errors);
          errorData.password_confirmation = errors.password_confirmation
            ? errors.password_confirmation[0]
            : errors.password
            ? errors.password[0]
            : '';
          isLoaderVisible.value = false;

          if (response.success) {
            registerForm['2'].is_complete = true;
            step.value += 1;
          }
        })
        .catch((error) => {
          const { errors } = error.response.data;
          isLoaderVisible.value = false;
          updateFormErrors(errors);
          errorData.password_confirmation = errors.password_confirmation
            ? errors.password_confirmation[0]
            : errors.password
            ? errors.password[0]
            : '';
        });
    }

    function getCurrentStep() {
      return step.value.toString();
    }

    function goToNextForm() {
      if (step.value === 1) verifyPublisher();
      if (step.value === 2) submitForm();
    }

    function goToPreviousForm() {
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
      isTextField,
      props,
      translate,
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
        height: 175px;
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
