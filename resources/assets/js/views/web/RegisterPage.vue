<template>
  <section class="section mb-7 sm:mx-10 sm:mb-10 md:mb-14 xl:mx-24 xl:px-1">
    <Loader v-if="isLoaderVisible"></Loader>
    <div class="section__container">
      <div class="section__title mt-7 text-center leading-10 sm:mt-14">
        <h2>Create IATI Publisher Account</h2>
        <p>
          Register your organisation to start your IATI publishing journey by
          creating an account in IATI publisher.
        </p>
      </div>
      <div class="section__wrapper flex">
        <EmailVerification
          v-if="step === 3"
          :email="formData.email"
        ></EmailVerification>
        <div v-else class="form input__field" @keyup.enter="goToNextForm">
          <div class="form__container">
            <div class="flex items-center space-x-1">
              <HoverText
                v-if="registerForm[step].hover_text"
                :hover_text="registerForm[step].hover_text"
                :name="registerForm[step].title"
                :position="right"
              ></HoverText>
              <span class="text-2xl font-bold text-n-50">{{
                registerForm[step].title
              }}</span>
            </div>
            <div
              v-if="!publisherExists"
              class="feedback mt-6 h-32 border-l-2 border-crimson-50 bg-crimson-10 p-4 text-sm text-n-50"
            >
              <p class="mb-2 flex font-bold">
                <svg-vue class="mr-2 text-xl" icon="warning"></svg-vue>
                Sorry, the information you provided doesn’t match your IATI
                Registry information.
              </p>
              <p class="ml-8 xl:mr-1">
                Please note that if you’re an account holder in
                <span
                  ><a href="https://iatiregistry.org/">IATI Registry</a></span
                >, make sure your
                <span class="font-bold"
                  >Publisher Name, Publisher ID and IATI Organisation ID</span
                >
                match your IATI Registry Information. Contact
                <span
                  ><a
                    class="text-bluecoral"
                    href="mailto:support@iatistandard.org"
                    >support@iatistandard.org</a
                  ></span
                >
                for more details.
              </p>
            </div>
            <div class="form__content">
              <div
                v-for="field in registerForm[step].fields"
                :key="field.name"
                :class="field.class"
              >
                <div class="flex items-center justify-between">
                  <label :for="field.id" class="label"
                    >{{ field.label }}
                    <span v-if="field.required" class="text-salmon-40"> *</span>
                  </label>
                  <HoverText
                    v-if="field.hover_text !== ''"
                    :hover_text="field.hover_text"
                    :name="field.label"
                  ></HoverText>
                </div>
                <input
                  v-if="
                    (field.type === 'text' ||
                      field.type === 'password' ||
                      field.type === 'email') &&
                    field.name != 'identifier'
                  "
                  :id="field.id"
                  v-model="formData[field.name]"
                  :class="
                    errorData[field.name] != ''
                      ? 'error__input form__input'
                      : 'form__input'
                  "
                  :placeholder="field.placeholder"
                  :type="field.type"
                />

                <input
                  v-if="field.name == 'identifier'"
                  v-model="formData[field.name]"
                  :class="
                    errorData[field.name] != ''
                      ? 'error__input form__input'
                      : 'form__input'
                  "
                  :placeholder="field.placeholder"
                  :type="field.type"
                  :value="
                    formData.registration_agency +
                    '-' +
                    formData.registration_number
                  "
                  disabled="disabled"
                />

                <Multiselect
                  v-if="field.type === 'select'"
                  v-model="formData[field.name]"
                  :class="
                    errorData[field.name] != ''
                      ? 'error__input vue__select'
                      : 'vue__select'
                  "
                  :options="field.options"
                  :placeholder="field.placeholder"
                  :searchable="true"
                />

                <span
                  v-if="field.help_text != '' && errorData[field.name] == ''"
                  class="text-xs font-normal text-n-40"
                  >{{ field.help_text }}
                </span>

                <span
                  v-if="errorData[field.name] != ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData[field.name] }}
                </span>
              </div>
            </div>
          </div>
          <div class="flex items-center justify-between">
            <button
              v-if="step != 1"
              class="btn-back"
              @click="goToPreviousForm()"
            >
              <svg-vue class="mr-3 cursor-pointer" icon="left-arrow"></svg-vue>
              Go back
            </button>
            <span v-if="step == 1" class="text-sm font-normal text-n-40"
              >Already have an account?
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
                href="/"
                >Sign In.</a
              ></span
            >
            <button
              class="btn btn-next w-40"
              v-if="step != 3"
              @click="goToNextForm()"
            >
              Next Step
              <svg-vue class="text-2xl" icon="right-arrow"></svg-vue>
            </button>
          </div>
          <div v-if="step == 2" class="mt-6 text-center">
            <span class="text-sm font-normal text-n-40"
              >Already have an account?
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
                href="/"
                >Sign In.</a
              ></span
            >
          </div>
        </div>

        <aside class="register__sidebar">
          <span class="text-base font-bold">Step {{ step }} out of 3</span>
          <ul class="relative mt-6 text-sm text-n-40">
            <li
              v-for="(ele, i) in registerForm"
              :key="ele.title"
              :class="[
                step == parseInt(i)
                  ? 'relative font-bold text-n-50'
                  : 'mb-6 flex items-center',
              ]"
            >
              <span v-if="step == parseInt(i)" class="list__active"></span>
              <span v-if="!ele.is_complete" class="mr-3 ml-6">
                {{ i }}
              </span>
              <span v-if="ele.is_complete" class="mr-3 ml-6">
                <svg-vue class="text-xs" icon="checked"> </svg-vue>
              </span>
              <span
                :class="[
                  step == parseInt(i)
                    ? 'font-bold text-n-50'
                    : ele.is_complete
                    ? 'font-bold text-bluecoral'
                    : 'font-normal text-n-40',
                ]"
              >
                {{ ele.title }}
              </span>
              <p
                v-if="step == parseInt(i)"
                class="detail mt-2 mb-6 font-normal xl:pr-2"
              >
                {{ ele.description }}
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
    registration_agency: {
      type: [String, Object],
      required: true,
    },
  },

  setup(props) {
    const step = ref(1);
    const publisherExists = ref(true);
    const isLoaderVisible = ref(false);

    const errorData = reactive({
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

    const formData = reactive({
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

    const registrationAgency = computed(() => {
      const agencies = props.registration_agency!;

      if (formData.country) {
        const uncategorized = ['XI', 'XR'];

        return Object.fromEntries(
          Object.entries(agencies).filter(
            ([key, value]) =>
              key.startsWith(formData.country) ||
              uncategorized.some((k) => key.startsWith(k))
          )
        );
      } else {
        return agencies;
      }
    });

    const registerForm = reactive({
      1: {
        title: 'Publisher Information',
        is_complete: false,
        description:
          'This information will be used to create a Publisher in IATI Publisher',
        hover_text:
          'Provide information about your organisation. You will need to provide the same information that you used to create your Publisher Account on the IATI Registry (iatiregistry.org).',
        fields: {
          publisher_name: {
            label: 'Publisher Name',
            name: 'publisher_name',
            placeholder: 'Type your Publisher Name here',
            id: 'publisher-name',
            required: true,
            hover_text: 'Provide the name of your organisation.',
            type: 'text',
            class: 'col-span-2 mb-4 lg:mb-2',
            help_text: '',
          },
          publisher_id: {
            label: 'Publisher ID',
            name: 'publisher_id',
            placeholder: 'Type your organisation ID here',
            id: 'publisher-id',
            required: true,
            hover_text:
              "This is the unique ID for your organisation that you created when you set up your IATI Registry Publisher Account. It should be a shorter version of your organisation's name, which will include lowercase letters and may include numbers, - (dash) or _ (underscore). For example nef_mali' for Near East Foundation Mali.",
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: '',
          },
          country: {
            label: 'Country',
            name: 'country',
            placeholder: 'Select a Country',
            id: 'country_select',
            required: false,
            type: 'select',
            hover_text: 'Add the location of your organisation.',
            options: props.country,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          organization_registration_agency: {
            label: 'Organisation Registration Agency',
            name: 'registration_agency',
            placeholder: 'Select an Organisation Registration Agency',
            id: 'registration-agency',
            required: true,
            hover_text:
              'Provide the name of the agency in your country where you organisation is registered. If you do not know this information please email support@iatistandard.org.',
            type: 'select',
            options: registrationAgency,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          organization_registration_no: {
            label: 'Organisation Registration Number',
            name: 'registration_number',
            placeholder: 'Type your Registration Number here',
            id: 'registration-number',
            required: true,
            hover_text:
              'Add the registration number for your organisation that has been provided by the registration agency named above.',
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: 'for e.g. 123456',
          },
          iati_organizational_identifier: {
            label: 'IATI Organisational Identifier',
            name: 'identifier',
            placeholder: '',
            id: 'identifier',
            required: true,
            hover_text:
              'The Organisation Identifier is a unique code for your organisation. This is genereated from the Organisation Registration Agency and Registration Number. For more information read: <a href="http://iatistandard.org/en/guidance/preparing-organisation/organisation-account/how-to-create-your-iati-organisation-identifier/" target="_blank">How to create your IATI organisation identifier.</a>',
            type: 'text',
            class: 'mb-4 lg:mb-6',
            help_text:
              'This is autogenerated, please make sure to fill the above fields correctly.',
          },
        },
      },
      2: {
        title: 'Administrator Information',
        is_complete: false,
        description:
          'This information will be used to create an admin account in IATI Publisher',
        hover_text:
          'Provide your information to create an admin account here on IATI Publisher.',
        fields: {
          username: {
            label: 'Username',
            name: 'username',
            placeholder: 'Type username here',
            id: 'username',
            required: true,
            hover_text:
              'You will need this later to login into IATI Publisher.',
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: '',
          },
          full_name: {
            label: 'Full Name',
            name: 'full_name',
            placeholder: 'Type your full name here',
            id: 'full-name',
            hover_text: '',
            required: true,
            type: 'text',
            class: 'col-start-1 mb-4 lg:mb-2',
          },
          email: {
            label: 'Email Address',
            name: 'email',
            placeholder: 'Type valid email here',
            id: 'email',
            required: true,
            hover_text: '',
            type: 'email',
            class: 'mb-4 lg:mb-2',
          },
          password: {
            label: 'Password',
            name: 'password',
            placeholder: 'Type password here',
            id: 'password',
            required: true,
            hover_text: '',
            type: 'password',
            class: 'mb-4 lg:mb-2',
          },
          confirm_password: {
            label: 'Confirm Password',
            name: 'password_confirmation',
            placeholder: 'Type password here',
            id: 'password-confirmation',
            required: true,
            hover_text: '',
            type: 'password',
            class: 'mb-4 lg:mb-6',
          },
        },
      },
      3: {
        title: 'Email Verification',
        is_complete: false,
        description:
          'Please verify and activate your IATI Publisher account through your provided email',
      },
    });

    function verifyPublisher() {
      formData.identifier = `${formData.registration_agency}-${formData.registration_number}`;
      isLoaderVisible.value = true;
      axios
        .post('/verifyPublisher', formData)
        .then((res) => {
          const response = res.data;
          publisherExists.value = true;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];

          errorData.publisher_name = errors.publisher_name
            ? errors.publisher_name[0]
            : '';
          errorData.publisher_id = errors.publisher_id
            ? errors.publisher_id[0]
            : '';
          errorData.registration_agency = errors.registration_agency
            ? errors.registration_agency[0]
            : '';
          errorData.registration_number = errors.registration_number
            ? errors.registration_number[0]
            : '';
          errorData.identifier = errors.identifier ? errors.identifier[0] : '';

          if ('publisher_error' in response) {
            publisherExists.value = false;
          }

          if (response.success) {
            registerForm['1'].is_complete = true;
            step.value += 1;
          }

          isLoaderVisible.value = false;
        })
        .catch((error) => {
          isLoaderVisible.value = false;
        });
    }

    function submitForm() {
      isLoaderVisible.value = true;

      axios
        .post('/register', formData)
        .then((res) => {
          const response = res.data;
          const errors =
            !response.success || 'errors' in response ? response.errors : [];
          errorData.username = errors.username ? errors.username[0] : '';
          errorData.full_name = errors.full_name ? errors.full_name[0] : '';
          errorData.email = errors.email ? errors.email[0] : '';
          errorData.password = errors.password ? errors.password[0] : '';
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
          errorData.username = errors.username ? errors.username[0] : '';
          errorData.full_name = errors.full_name ? errors.full_name[0] : '';
          errorData.email = errors.email ? errors.email[0] : '';
          errorData.password = errors.password ? errors.password[0] : '';
          errorData.password_confirmation = errors.password_confirmation
            ? errors.password_confirmation[0]
            : errors.password
            ? errors.password[0]
            : '';
        });
    }

    function goToNextForm() {
      if (step.value === 1) verifyPublisher();
      if (step.value === 2) submitForm();
    }

    function goToPreviousForm() {
      step.value -= 1;
    }

    return {
      step,
      registerForm,
      formData,
      errorData,
      publisherExists,
      isLoaderVisible,
      goToNextForm,
      goToPreviousForm,
      props,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<style lang="scss">
.label {
  @apply text-sm font-normal;
}

.section {
  &__container {
    max-width: 1206px;
    margin: auto;

    .feedback {
      width: 702px;

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
      margin-bottom: 40px;

      p {
        font-weight: normal;
        font-size: 16px;
        font-style: normal;
        @apply text-n-40;
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
  @apply bg-white;
  padding: 40px 80px;
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
}

@media screen and (min-width: 1024px) {
  .form__content {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-top: 24px;
  }
}
</style>
