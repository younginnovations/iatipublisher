<template>
  <section class="section mb-7 sm:mx-10 sm:mb-10 md:mb-14 xl:mx-24 xl:px-1">
    <div class="section__container">
      <div class="section__title mt-7 text-center leading-10 sm:mt-14">
        <h2>{{ props.translation.create_account }}</h2>
        <p>
          {{ props.translation.create_account_description }}
        </p>
      </div>
      <div class="section__wrapper flex">
        <EmailVerification
          v-if="step === 3"
          :email="formData.email"
          :translation="props.translation"
        ></EmailVerification>
        <div v-else class="form">
          <div class="form__container">
            <span class="text-2xl font-bold text-n-50">{{
              registerForm[step].title
            }}</span>
            <div
              class="feedback mt-6 border-l-2 border-crimson-50 bg-crimson-10 p-4 text-sm text-n-50"
              v-if="!publisherExists"
            >
              <p class="mb-2 flex font-bold">
                <svg-vue class="mr-2 text-xl" icon="warning"></svg-vue>
                {{ props.translation.iati_registry_information }}
              </p>
              <p
                class="ml-8 leading-5 xl:mr-1"
                v-html="props.translation.registry_information"
              ></p>
            </div>
            <div class="form__content">
              <div
                :class="field.class"
                v-for="field in registerForm[step].fields"
                :key="field.name"
              >
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >{{ field.label }}
                    <span class="text-salmon-40" v-if="field.required"> *</span>
                  </label>
                  <HoverText
                    v-if="field.hover_text !== ''"
                    :name="field.label"
                    :hover_text="field.hover_text"
                  ></HoverText>
                </div>
                <input
                  :class="
                    errorData[field.name] != ''
                      ? 'error__input form__input'
                      : 'form__input'
                  "
                  :type="field.type"
                  v-model="formData[field.name]"
                  :placeholder="formData[field.placeholder]"
                  v-if="
                    (field.type === 'text' || field.type === 'password') &&
                    field.name != 'identifier'
                  "
                />

                <input
                  class="form__input"
                  :type="field.type"
                  v-model="formData[field.name]"
                  :value="
                    formData.registration_agency +
                    '-' +
                    formData.registration_number
                  "
                  :placeholder="formData[field.placeholder]"
                  v-if="field.name == 'identifier'"
                  disabled="disabled"
                />

                <Multiselect
                  :class="
                    errorData[field.name] != ''
                      ? 'error__input vue__select'
                      : 'vue__select'
                  "
                  v-if="field.type === 'select'"
                  v-model="formData[field.name]"
                  :options="field.options"
                />

                <span
                  class="text-xs font-normal text-n-40"
                  v-if="field.help_text != '' && errorData[field.name] == ''"
                  >{{ field.help_text }}
                </span>

                <span
                  class="error"
                  role="alert"
                  v-if="errorData[field.name] != ''"
                >
                  {{ errorData[field.name] }}
                </span>
              </div>
            </div>
          </div>
          <div class="flex items-center justify-between">
            <button
              class="btn-back"
              v-if="step != 1"
              @click="goToPreviousForm()"
            >
              <svg-vue class="mr-3 cursor-pointer" icon="left-arrow"></svg-vue>
              {{ props.translation.go_back_button }}
            </button>
            <span class="text-sm font-normal text-n-40" v-if="step == 1"
              >{{ props.translation.already_have_account }}
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise"
                href="#"
                >{{ props.translation.sign_in }}.</a
              ></span
            >
            <button
              class="btn btn-next"
              v-if="step != 3"
              @click="goToNextForm()"
            >
              {{ props.translation.next_step_button }}
              <svg-vue class="text-2xl" icon="right-arrow"></svg-vue>
            </button>
          </div>
          <div class="mt-6 text-center" v-if="step == 2">
            <span class="text-sm font-normal text-n-40"
              >{{ props.translation.already_have_account }}
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise"
                href="#"
                >{{ props.translation.sign_in }}.</a
              ></span
            >
          </div>
        </div>

        <!-- step 1 -->
        <aside>
          <span class="text-base font-bold">{{ props.translation.steps }}</span>
          <ul class="relative mt-6 text-sm text-n-40">
            <li
              :class="[
                step == parseInt(i)
                  ? 'relative mb-6 font-bold text-n-50'
                  : 'mb-6',
              ]"
              v-for="(ele, i) in registerForm"
              :key="ele.title"
            >
              <span class="list__active" v-if="step == parseInt(i)"></span>
              <span class="mr-3 ml-6" v-if="!ele.is_complete">
                {{ i }}
              </span>
              <span class="mr-3 ml-6" v-if="ele.is_complete">
                <svg-vue class="text-xs" icon="checked"> </svg-vue>
              </span>
              {{ ele.title }}
              <p
                class="detail mt-2 font-normal xl:pr-2"
                v-if="step == parseInt(i)"
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
import { defineComponent, reactive, ref, computed } from 'vue';
import axios from 'axios';
import EmailVerification from './EmailVerification.vue';
import HoverText from './../../components/HoverText.vue';
import Multiselect from '@vueform/multiselect';

export default defineComponent({
  components: {
    EmailVerification,
    HoverText,
    Multiselect,
  },

  props: {
    country: String,
    registration_agency: String,
    translation: [String, Array],
  },

  setup(props) {
    const step = ref(1);
    const publisherExists = ref(true);
    const option = ref(['a', 'b']);
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

    const registrationAgency = computed(() => {
      if (formData.country !== '') {
        const uncategorized = ['XI', 'PK', 'IQ', 'NE', 'XR'];
        const agencies = props.registration_agency!;

        formData.registration_agency = '';
        return Object.fromEntries(
          Object.entries(agencies).filter(
            ([key, value]) =>
              key.startsWith(formData.country) ||
              uncategorized.some((k) => key.startsWith(k))
          )
        );
      }

      return props.registration_agency;
    });

    const registerForm = reactive({
      1: {
        title: props.translation['publisher_information'],
        is_complete: false,
        description: props.translation['publisher_description'],
        fields: {
          publisher_name: {
            label: props.translation['publisher_name'],
            name: 'publisher_name',
            placeholder: 'Enter the name of your organization',
            id: 'publisher_name',
            required: true,
            hover_text:
              props.translation['hover_text']['publisher_name_description'],
            type: 'text',
            class: 'col-span-2 mb-4 lg:mb-2',
            help_text: '',
          },
          publisher_id: {
            label: props.translation['publisher_id'],
            name: 'publisher_id',
            placeholder: "For example, 'dfid' and 'worldbank'",
            id: 'publisher_id',
            required: false,
            hover_text:
              props.translation['hover_text']['publisher_id_description'],
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: props.translation['publisher_id_description'],
          },
          country: {
            label: props.translation['country'],
            name: 'country',
            placeholder: 'Select the country',
            id: 'country',
            required: false,
            type: 'select',
            hover_text: props.translation['hover_text']['country_description'],
            options: props.country,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          organization_registration_agency: {
            label: props.translation['registration_agency'],
            name: 'registration_agency',
            placeholder: 'Select your Organization Registration Agency',
            id: 'registration_agency',
            required: true,
            hover_text: '',
            type: 'select',
            options: registrationAgency,
            class: 'mb-4 lg:mb-2 relative',
            help_text: '',
          },
          organization_registration_no: {
            label: props.translation['registration_number'],
            name: 'registration_number',
            placeholder: '',
            id: 'registration_number',
            required: true,
            hover_text: '',
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: '',
          },
          iati_organizational_identifier: {
            label: props.translation['iati_organiational_identifier'],
            name: 'identifier',
            placeholder: '',
            id: 'identifier',
            required: true,
            hover_text:
              props.translation['hover_text']['iati_organiational_description'],
            type: 'text',
            class: 'mb-6',
            help_text: props.translation['help_text'],
          },
        },
      },
      2: {
        title: props.translation['administrator'],
        is_complete: false,
        description: props.translation['administrator_description'],
        fields: {
          username: {
            label: props.translation['username'],
            name: 'username',
            placeholder: '',
            id: 'username',
            required: true,
            hover_text: props.translation['hover_text']['username_description'],
            type: 'text',
            class: 'mb-4 lg:mb-2',
            help_text: '',
          },
          full_name: {
            label: props.translation['full_name'],
            name: 'full_name',
            placeholder: '',
            id: 'full_name',
            hover_text: '',
            required: true,
            type: 'text',
            class: 'col-start-1 mb-4 lg:mb-2',
          },
          email: {
            label: props.translation['email_address'],
            name: 'email',
            placeholder: '',
            id: 'email',
            required: true,
            hover_text: '',
            type: 'text',
            class: 'mb-4 lg:mb-2',
          },
          password: {
            label: props.translation['password_label'],
            name: 'password',
            placeholder: '',
            id: 'password',
            required: true,
            hover_text: '',
            type: 'password',
            class: 'mb-6',
          },
          confirm_password: {
            label: props.translation['confirm_password'],
            name: 'password_confirmation',
            placeholder: '',
            id: 'password_confirmation',
            required: true,
            hover_text: '',
            type: 'password',
            class: 'mb-6',
          },
        },
      },
      3: {
        title: props.translation['email_verification'],
        is_complete: false,
        description: props.translation['email_description'],
      },
    });

    function verifyPublisher() {
      formData.identifier = `${formData.registration_agency}-${formData.registration_number}`;
      axios
        .post('/verifyPublisher', formData)
        .then((res) => {
          const response = res.data;
          publisherExists.value = true;
          const errors = 'errors' in response ? response.errors : [];

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

          if ('publisher_error' in errors) {
            publisherExists.value = false;
          }

          if ('success' in response) {
            console.log('here');
            registerForm['1'].is_complete = true;
            step.value += 1;
          }
        })
        .catch((error) => {
          // const { errors } = error;
          // errors = error.response.data.errors;
          console.log('errors', error);
        });
    }

    function submitForm() {
      axios
        .post('/register', formData)
        .then((res) => {
          const response = res.data;
          const errors = 'errors' in response ? response.data.errors : [];
          errorData.username = errors.username ? errors.username[0] : '';
          errorData.full_name = errors.full_name ? errors.full_name[0] : '';
          errorData.email = errors.email ? errors.email[0] : '';
          errorData.password = errors.password ? errors.password[0] : '';

          if ('success' in response) {
            registerForm['2'].is_complete = true;
            step.value += 1;
          }
        })
        .catch((error) => {
          const { errors } = error.response.data;
          errorData.username = errors.username ? errors.username[0] : '';
          errorData.full_name = errors.full_name ? errors.full_name[0] : '';
          errorData.email = errors.email ? errors.email[0] : '';
          errorData.password = errors.password ? errors.password[0] : '';
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
      goToNextForm,
      goToPreviousForm,
      props,
      option,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

<style lang="scss">
.label {
  @apply pb-2 text-sm font-normal;
}
.section {
  &__container {
    max-width: 1206px;
    margin: auto;

    .feedback {
      width: 702px;
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
    .form {
      @apply bg-white;
      padding: 40px 80px;
      border-top-left-radius: 8px;
      border-bottom-left-radius: 8px;
      width: 862px;

      &__container {
        @apply border-b-2 border-b-n-10;
        margin-bottom: 24px;

        .multiselect-option.is-selected {
          @apply bg-n-20 text-n-50;
        }
        .multiselect-option.is-selected.is-pointed {
          @apply bg-n-20 text-n-50;
        }
        .multiselect.is-active {
          box-shadow: 0 0 0 0;
        }
        .multiselect-dropdown {
          @apply border border-n-50;
        }
        .multiselect-caret {
          -webkit-mask-image: url('/images/dropdown-arrow.svg');
          mask-image: url('/images/dropdown-arrow.svg');
        }
        .vue__select {
          @apply border border-n-30 text-base leading-6 outline-none duration-300;
          padding: 16px 0px 16px 55px;
          height: 52px;

          &:focus {
            @apply border border-n-50 bg-n-10;
            box-shadow: 0 0 0 0;
          }
          &::placeholder {
            letter-spacing: -0.02em;
            @apply text-n-40;
          }
          &:focus::placeholder {
            @apply text-n-50;
          }
        }
        .error__input {
          @apply border border-crimson-50;
        }
      }
    }
    aside {
      @apply bg-eggshell;
      padding: 96px 80px 40px 32px;
      width: 344px;

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
  @media screen and (min-width: 1024px) {
    .form__content {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
      margin-top: 24px;
    }
  }
}
</style>
