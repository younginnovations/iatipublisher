<template>
  <section class="section mb-7 sm:mx-10 sm:mb-10 md:mb-14 xl:mx-24 xl:px-1">
    <div class="section__container">
      <div class="section__title mt-7 text-center leading-10 sm:mt-14">
        <h2>Create IATI Publisher Account</h2>
        <p>
          Register your organisation to start your IATI publishing journey by
          creating an account in IATI publisher.
        </p>
      </div>
      <EmailVerification
        v-if="step === 3"
        :email="formData.email"
      ></EmailVerification>
      <div v-else class="section__wrapper flex">
        <div class="form">
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
                Sorry, the information you provided doesn’t match your IATI
                Registry information.
              </p>
              <p class="ml-8 leading-5 xl:mr-1">
                Please note that if you’re an account holder in IATI Registry,
                make sure your
                <span class="font-bold"
                  >Publisher Name,Publisher ID and IATI Organisation ID</span
                >
                match your IATI Registry Information. Contact
                <span
                  ><a
                    class="text-n-40 hover:text-n-50"
                    href="mailto:support@iatistandard.org"
                    >support@iatistandard.org</a
                  ></span
                >
                for more details.
              </p>
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
                    <span class="text-crimson-40" v-if="field.required">
                      *</span
                    >
                  </label>
                  <svg-vue class="cursor-pointer" icon="help"></svg-vue>
                </div>
                <input
                  class="form__input error__input"
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

                <select
                  class="form__input"
                  v-model="formData[field.name]"
                  :placeholder="field.placeholder"
                  v-if="field.type === 'select'"
                >
                  <option v-for="(ele, i) in field.options" :key="i" :value="i">
                    {{ ele }}
                  </option>
                </select>

                <span
                  class="text-tiny font-normal text-n-40"
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
              Go back
            </button>
            <span class="text-sm font-normal text-n-40" v-if="step == 1"
              >Already have an account?
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise"
                href="#"
                >Sign In.</a
              ></span
            >
            <button
              class="btn btn-next"
              v-if="step != 3"
              @click="goToNextForm()"
            >
              Next Step
              <svg-vue class="text-2xl" icon="right-arrow"></svg-vue>
            </button>
          </div>
          <div class="mt-6 text-center" v-if="step == 2">
            <span class="text-sm font-normal text-n-40"
              >Already have an account?
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise"
                href="#"
                >Sign In.</a
              ></span
            >
          </div>
        </div>

        <!-- step 1 -->
        <aside>
          <span class="text-base font-bold">Step 1 out of 3</span>
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

export default defineComponent({
  components: {
    EmailVerification,
  },

  props: {
    country: String,
    registration_agency: String,
  },

  setup(props) {
    const step = ref(1);
    const publisherExists = ref(true);
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
        console.log(formData.country);
        // return map.call(props.registration_agency, ({key, value}) => {
        //   console.log(key, value);
        //   // if (formData.country === key.split('-')[0]) {
        //   //   console.log('has',key,value);
        //   //   return { key: value };
        //   // }
        // });

        // return new Map<string,string>map.has(props.registration_agency, ({key, value}) => {
        //   console.log(key, value);
        //   // if (formData.country === key.split('-')[0]) {
        //   //   console.log('has',key,value);
        //   //   return { key: value };
        //   // }
        // });

        // return props.registration_agency.filter(function (data) {
        //   return data;
        // });
      }

      return props.registration_agency;
    });

    const registerForm = reactive({
      1: {
        title: 'Publisher Information',
        is_complete: false,
        description:
          'This information will be used to create a Publisher in IATI Publisher',
        fields: {
          publisher_name: {
            label: 'Publisher Name',
            name: 'publisher_name',
            placeholder: 'Enter the name of your organization',
            required: true,
            type: 'text',
            class: 'col-span-2 mb-4',
            help_text: '',
          },
          publisher_id: {
            label: 'Publisher ID',
            name: 'publisher_id',
            placeholder: "For example, 'dfid' and 'worldbank'",
            required: false,
            type: 'text',
            class: 'mb-4',
            help_text:
              'You can use a unique abbreviated form of your organization name',
          },
          country: {
            label: 'Country',
            name: 'country',
            placeholder: 'Select the country',
            required: false,
            type: 'select',
            options: props.country,
            class: 'mb-4',
            help_text: '',
          },
          organization_registration_agency: {
            label: 'Organization Registration Agency',
            name: 'registration_agency',
            placeholder: 'Select your Organization Registration Agency',
            required: true,
            type: 'select',
            options: registrationAgency,
            class: 'mb-4',
            help_text: '',
          },
          organization_registration_no: {
            label: 'Organization Registration Number',
            name: 'registration_number',
            placeholder: '',
            required: true,
            type: 'text',
            class: 'mb-4',
            help_text: '',
          },
          iati_organizational_identifier: {
            label: 'IATI Organizational Identifier',
            name: 'identifier',
            placeholder: '',
            required: true,
            type: 'text',
            class: 'mb-4',
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
        fields: {
          username: {
            label: 'Username',
            name: 'username',
            placeholder: '',
            required: true,
            type: 'text',
            class: 'mb-4',
            help_text: '',
          },
          full_name: {
            label: 'Full Name',
            name: 'full_name',
            placeholder: '',
            required: true,
            type: 'text',
            class: 'col-start-1 mb-4',
          },
          email: {
            label: 'Email Address',
            name: 'email',
            placeholder: '',
            required: true,
            type: 'text',
            class: 'mb-4',
          },
          password: {
            label: 'Password',
            name: 'password',
            placeholder: '',
            required: true,
            type: 'password',
            class: 'mb-4',
          },
          confirm_password: {
            label: 'Confirm Password',
            name: 'password_confirmation',
            placeholder: '',
            required: true,
            type: 'password',
            class: 'mb-4',
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
          // console.log('errors', error);
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
    };
  },
});
</script>

<style lang="scss">
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

        .label {
          font-size: 14px;
          font-weight: normal;
          font-style: normal;
        }
      }
      &__input {
        @apply border border-n-30;
        width: 100%;
        padding: 13px 0 13px 16px;
        margin-top: 8px;
        outline: none;
        border-radius: 4px;
        transition: 0.3s;

        &::placeholder {
          @apply text-n-40;
          font-size: 14px;
          font-weight: normal;
          font-style: normal;
          letter-spacing: -0.02em;
        }
        &:focus {
          @apply border border-n-50 bg-n-10;
        }
        &:focus::placeholder {
          @apply text-n-50;
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
