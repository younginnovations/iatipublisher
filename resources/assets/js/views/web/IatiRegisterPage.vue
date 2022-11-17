<template>
  <section class="section mx-3 mb-7 sm:mx-10 sm:mb-10 md:mb-14 xl:mx-24 xl:px-1">
    <Loader v-if="isLoaderVisible" />
    <div class="section__container">
      <div class="section__title">
        <h2>Create IATI Publisher Account and IATI Registry Account</h2>
        <p>
          Register your organisation to start your IATI publishing journey by creating
          accounts in IATI publisher and IATI Registry at once.
        </p>
      </div>
      <div class="section__wrapper flex justify-center">
        <EmailVerification v-if="checkStep('5')" :email="formData['email']" />
        <div v-else class="form input__field" @keyup.enter="goToNextForm">
          <aside class="mb-4 block border-b border-b-n-10 pb-4 xl:hidden">
            <span class="text-base font-bold">Step {{ getCurrentStep() }} out of 5</span>
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
                    {{ form["title"] }}
                  </span>
                </div>
                <p v-if="checkStep(key)" class="detail mt-2 font-normal">
                  {{ form["description"] }}
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
                Please work on following errors before submitting the form again.
              </p>
              <p class="ml-8 xl:mr-1">
              <ul>
              <li v-for="(error, error_key) in IATI" :key="error_key">
              <span>{{error}}</span>
              </li>
              </ul>
              </p>
            </div>
            <div class="form__content">
              <div
                v-for="(field, index, key) in registerForm[getCurrentStep()]['fields']"
                :key="key"
                :class="field.class"
              >
                <div class="mb-2 flex items-center justify-between">
                  <label :for="field.id" class="label"
                    >{{ field["label"] }}
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
                  v-model="formData[field.name]"
                  :placeholder="field.placeholder"
                  :class="{
                    'error_input form__input ': errorData[field.name],
                    'form__input ': !errorData[field.name],
                  }"
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
                  :value="
                    formData.registration_agency + '-' + formData.registration_number
                  "
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

                <span v-if="errorData[field.name] !== ''" class="error" role="alert">
                  {{ errorData[field.name] }}
                </span>
              </div>
            </div>
          </div>
          <div class="flex flex-wrap items-center justify-between">
            <button v-if="!checkStep(1)" class="btn-back" @click="goToPreviousForm()">
              <svg-vue class="mr-3 cursor-pointer" icon="left-arrow" />
              Go back
            </button>
            <span v-if="checkStep(1)" class="pb-4 text-sm font-normal text-n-40 sm:pb-0"
              >Already have an account?
              <a
                class="border-b-2 border-b-transparent font-bold text-bluecoral hover:border-b-2 hover:border-b-turquoise hover:text-bluecoral"
                href="/"
                >Sign In.</a
              ></span
            >
            <button v-if="!checkStep(5)" class="btn btn-next" @click="goToNextForm()">
              Next Step
              <svg-vue class="text-2xl" icon="right-arrow" />
            </button>
          </div>
          <div v-if="checkStep(2)" class="mt-6 text-center">
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

        <aside class="register__sidebar hidden xl:block">
          <span class="text-base font-bold">Step {{ getCurrentStep() }} out of 5</span>
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
                  {{ form["title"] }}
                </span>
              </div>
              <p v-if="checkStep(key)" class="detail mt-2 mb-6 font-normal xl:pr-2">
                {{ form["description"] }}
              </p>
            </li>
          </ul>
        </aside>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { computed, defineComponent, reactive, ref, watch } from "vue";
import axios from "axios";
import EmailVerification from "./EmailVerification.vue";
import HoverText from "./../../components/HoverText.vue";
import Multiselect from "@vueform/multiselect";
import Loader from "../../components/Loader.vue";
import CryptoJS from "crypto-js";

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
    const step = ref(1);
    const publisherExists = ref(true);
    const isLoaderVisible = ref(false);

    interface ObjectType {
      [key: string]: string;
    }

    const errorData: ObjectType = reactive({
      publisher_name: "",
      publisher_id: "",
      country: "",
      registration_agency: "",
      registration_number: "",
      identifier: "",
      publisher_type: "",
      license_id: "",
      image_url: "",
      description: "",
      contact_email: "",
      website: "",
      address: "",
      source: "",
      record_exclusions: "",
      username: "",
      full_name: "",
      email: "",
      password: "",
      password_confirmation: "",
    });

    const formData: ObjectType = reactive({
      publisher_name: "",
      publisher_id: "",
      country: "",
      registration_agency: "",
      registration_number: "",
      identifier: "",
      publisher_type: "",
      license_id: "",
      image_url: "",
      description: "",
      contact_email: "",
      website: "",
      address: "",
      source: "",
      record_exclusions: "",
      username: "",
      full_name: "",
      email: "",
      password: "",
      password_confirmation: "",
    });

    watch(
      () => formData.country,
      () => {
        formData.registration_agency = "";
      }
    );

    const registration_agency = computed(() => {
      const agencies = props.types.registrationAgency;

      if (formData.country) {
        const uncategorized = ["XI", "XR"];

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
          (fieldType === "text" || fieldType === "password" || fieldType === "email") &&
          fieldName != "identifier"
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
        title: "Publisher Information",
        is_complete: false,
        description:
          "This information will be used to create a Publisher in IATI Publisher",
        hover_text:
          "We refer to organisations who publish IATI data as 'Publishers'. Before publishing data, all organisations need their own 'Publisher Account' on the IATI Registry (iatiregistry.org). Enter your organisation's data here and we'll create your organisation's Publisher Account for you. These details will also be saved here in IATI Publisher. ",
        fields: {
          publisher_name: {
            label: "Publisher Name",
            name: "publisher_name",
            placeholder: "Type your organisation name here",
            id: "publisher-name",
            required: true,
            hover_text: "The name of your organisation publishing the data.",
            type: "text",
            class: "col-span-2 mb-4 lg:mb-2",
            help_text: "",
          },
          publisher_id: {
            label: "Publisher ID",
            name: "publisher_id",
            placeholder: "Type your organisation ID here",
            id: "publisher-id",
            required: true,
            hover_text:
              "Provide a unique ID for your organisation. It must be at least two characters long and use lower case letters. You can include letters, numbers and also - (dash) and _ (underscore). Where possible use a short abbreviation of your organisation's name, for example: 'nef_mali' for Near East Foundation Mali.",
            type: "text",
            class: "mb-4 lg:mb-2",
            help_text: "",
          },
          country: {
            label: "Country",
            name: "country",
            placeholder: "Select a Country",
            id: "country_select",
            required: false,
            type: "select",
            hover_text: "Add the location of your organisation.",
            options: props.types.country,
            class: "mb-4 lg:mb-2 relative",
            help_text: "",
          },
          registration_agency: {
            label: "Organisation Registration Agency",
            name: "registration_agency",
            placeholder: "Select an Organisation Registration Agency",
            id: "registration-agency",
            required: true,
            hover_text:
              "Select the agency in your country where your organisation is registered. If you do not know this information please email <a href='mailto:support@iatistandard.org'>support@iatistandard.org</a>",
            type: "select",
            options: registration_agency,
            class: "mb-4 lg:mb-2 relative",
            help_text: "",
          },
          registration_number: {
            label: "Registration Number",
            name: "registration_number",
            placeholder: "Type your Registration Number here",
            id: "registration-number",
            required: true,
            hover_text:
              "Provide the registration number for your organisation that has been provided by organisation registration agency. If you do not know this please email <a href='mailto:support@iatistandard.org'>support@iatistandard.org</a>.",
            type: "text",
            class: "mb-4 lg:mb-2",
            help_text: "for e.g. 123456",
          },
          identifier: {
            label: "IATI Organisational Identifier",
            name: "identifier",
            placeholder: "",
            id: "identifier",
            required: true,
            hover_text:
              'The Organisation Identifier is a unique code for your organisation. This is genereated from the Organisation Registration Agency and Registration Number. For more information read:  <a href="http://iatistandard.org/en/guidance/preparing-organisation/organisation-account/how-to-create-your-iati-organisation-identifier/" target="_blank">How to create your IATI organisation identifier.</a>',
            type: "text",
            class: "mb-4 lg:mb-6",
            help_text:
              "This is autogenerated, please make sure to fill the above fields correctly.",
          },
          publisher_type: {
            label: "Publisher Type",
            name: "publisher_type",
            placeholder: "Select an Organisation Registration Agency",
            id: "publisher-type",
            required: true,
            hover_text:
              "Select the agency in your country where your organisation is registered. If you do not know this information please email <a href='mailto:support@iatistandard.org'>support@iatistandard.org</a>",
            type: "select",
            options: props.types.publisherType,
            class: "mb-4 lg:mb-2 relative",
            help_text: "",
          },
          license_id: {
            label: "Data License",
            name: "license_id",
            placeholder: "Select a Data License",
            id: "data-license",
            required: true,
            hover_text:
              " Select the License under which your data is being published. IATI is an open data standard and requires you to make your data available under an open licence so it can be freely used. One of the most frequently used licenses is Creative Commons Attribution. For more information read: How to license your data.",
            type: "select",
            options: props.types.dataLicense,
            class: "mb-4 lg:mb-2 relative",
            help_text: "",
          },
          iamge_url: {
            label: "Publisher Logo Url",
            name: "image_url",
            placeholder: "For e.g. http://mylogo.com ",
            id: "publisher-logo-url",
            required: false,
            hover_text:
              " Provide a link to an image to your organisation's logo (Optimum size: 200 x 120 px)",
            type: "text",
            class: "mb-4 lg:mb-2 relative",
            help_text: "",
          },
          description: {
            label: "Organization Description",
            name: "description",
            placeholder: "Type Description here",
            id: "organization-description",
            required: false,
            hover_text: " Provide a short description about your organisation.",
            type: "textarea",
            class: "mb-4 col-span-2 lg:mb-2 relative",
            help_text: "",
          },
        },
      },
      2: {
        title: "Contact Information",
        is_complete: false,
        description:
          "This information will be used to create a Publisher in IATI Publisher",
        fields: {
          contact_email: {
            label: "Contact Email",
            name: "contact_email",
            placeholder: "",
            id: "contact-email",
            required: true,
            hover_text:
              "Please add a contact email address for your organisation. Please note that IATI is an open data standard and the email provided here will be visible to others on the IATI Registry.",
            type: "text",
            class: "mb-4  lg:mb-6",
          },
          website: {
            label: "Website",
            name: "website",
            placeholder: "For e.g. http://mywebsite.com",
            id: "website",
            required: false,
            hover_text: "Add the URL to your organisation's website.",
            type: "text",
            class: "mb-4 lg:mb-6",
          },
          address: {
            label: "Address",
            name: "address",
            placeholder: "Type address here",
            id: "website",
            required: false,
            hover_text: "",
            type: "text",
            class: "mb-4 col-span-2 lg:mb-6",
          },
        },
      },
      3: {
        title: "Publishing Aditional Information",
        is_complete: false,
        description:
          "This information will be used to create an admin account in IATI Publisher",
        fields: {
          source: {
            label: "Source",
            name: "source",
            placeholder: "Select a Source",
            id: "contact-email",
            required: true,
            hover_text:
              "Select an option:Primary - your organisation is publishing its own or (associated organisations') data Secondary - your organisation is reproducing data on the activities of another organisation",
            type: "select",
            options: props.types.source,
            class: "mb-4 lg:mb-6",
          },
          record_exclusions: {
            label: "Record Exclusions",
            name: "record_exclusions",
            placeholder: "Type Record Exclusions here",
            id: "record-exclusions",
            required: false,
            hover_text:
              "Does your organisation have an exclusion policy that provide details on what data that it cannot publish? For example an organisation may not be able to publish data because of political sensitivity issues or if information is commercially restricted. Please provide details here about what data your organisation needs to exclude (if any), and a URL to your organisation's exclusion policy (if it has one). For more information read: Information and data you can't publish (exclusions)",
            type: "textarea",
            class: "mb-4  col-span-2 lg:mb-6",
          },
        },
      },
      4: {
        title: "Administrator Information",
        is_complete: false,
        description:
          "This information will be used to create an admin account in IATI Publisher",
        hover_text:
          "Provide your information to create an admin account here on IATI Publisher.",
        fields: {
          username: {
            label: "Username",
            name: "username",
            placeholder: "Type username here",
            id: "username",
            required: true,
            hover_text: "You will need this later to login into IATI Publisher.",
            type: "text",
            class: "mb-4 lg:mb-2",
            help_text: "",
          },
          full_name: {
            label: "Full Name",
            name: "full_name",
            placeholder: "Type your full name here",
            id: "full-name",
            hover_text: "",
            required: true,
            type: "text",
            class: "col-start-1 mb-4 lg:mb-2",
          },
          email: {
            label: "Email Address",
            name: "email",
            placeholder: "Type valid email here",
            id: "email",
            required: true,
            hover_text: "",
            type: "email",
            class: "mb-4 lg:mb-2",
          },
          password: {
            label: "Password",
            name: "password",
            placeholder: "Type password here",
            id: "password",
            required: true,
            help_text: "Minimum length: 6 characters",
            type: "password",
            class: "mb-4 lg:mb-2",
          },
          password_confirmation: {
            label: "Confirm Password",
            name: "password_confirmation",
            placeholder: "Type password here",
            id: "password-confirmation",
            required: true,
            help_text: "Should match the password above",
            type: "password",
            class: "mb-4 lg:mb-6",
          },
        },
      },
      5: {
        title: "Email Verification",
        is_complete: false,
        description:
          "Please verify and activate your IATI Publisher account through your provided email",
      },
    });

    /**
     * Encrypts password
     */
    function encrypt(string: string, key: string) {
      let iv = CryptoJS.lib.WordArray.random(16);
      let salt = CryptoJS.lib.WordArray.random(256);
      let iterations = 999;
      let encryptMethodLength = 256 / 4;
      let hashKey = CryptoJS.PBKDF2(key, salt, {
        hasher: CryptoJS.algo.SHA512,
        keySize: encryptMethodLength / 8,
        iterations: iterations,
      });

      let encrypted = CryptoJS.AES.encrypt(string, hashKey, {
        mode: CryptoJS.mode.CBC,
        iv: iv,
      });
      let encryptedString = CryptoJS.enc.Base64.stringify(encrypted.ciphertext);

      let output = {
        ciphertext: encryptedString,
        iv: CryptoJS.enc.Hex.stringify(iv),
        salt: CryptoJS.enc.Hex.stringify(salt),
        iterations: iterations,
      };

      return CryptoJS.enc.Base64.stringify(
        CryptoJS.enc.Utf8.parse(JSON.stringify(output))
      );
    }

    /**
     * Update Validation errors from api into errorData array
     */
    function updateValidationErrors(errorResponse) {
      for (const field in errorData) {
        errorData[field] = errorResponse[field] ? errorResponse[field][0] : "";
      }
    }

    /**
     * Verifies publisher
     */
    function verifyPublisher() {
      isLoaderVisible.value = true;

      formData.identifier = `${formData.registration_agency}-${formData.registration_number}`;

      let form = {
        password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ""
        ),
      };

      axios
        .post("/iati/register/publisher", { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes("activities")) {
            window.location.href = "/activities";
          }

          const response = res.data;
          publisherExists.value = true;
          const errors = !response.success || "errors" in response ? response.errors : [];
          registerForm["1"].is_complete = false;

          updateValidationErrors(errors);

          if ("publisher_error" in response) {
            publisherExists.value = false;
          }

          if (response.success) {
            registerForm["1"].is_complete = true;
            step.value += 1;
          }

          isLoaderVisible.value = false;
        })
        .catch(() => {
          isLoaderVisible.value = false;
        });
    }

    /**
     * Submits registration Form
     */
    function verifyContactInformation() {
      isLoaderVisible.value = true;

      let form = {
        password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ""
        ),
      };

      axios
        .post("/iati/register/contact", { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes("activities")) {
            window.location.href = "/activities";
          }

          const response = res.data;
          const errors = !response.success || "errors" in response ? response.errors : [];

          updateValidationErrors(errors);
          isLoaderVisible.value = false;
          registerForm["2"].is_complete = false;

          if (response.success) {
            registerForm["2"].is_complete = true;
            step.value += 1;
          }
        })
        .catch((error) => {
          const { errors } = error.response.data;
          updateValidationErrors(errors);
          isLoaderVisible.value = false;
        });
    }

    /**
     * Submits registration Form
     */
    function verifyAdditionalInformation() {
      isLoaderVisible.value = true;

      let form = {
        password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ""
        ),
      };

      axios
        .post("/iati/register/additional", { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes("activities")) {
            window.location.href = "/activities";
          }

          const response = res.data;
          const errors = !response.success || "errors" in response ? response.errors : [];
          updateValidationErrors(errors);
          isLoaderVisible.value = false;
          registerForm["3"].is_complete = false;

          if (response.success) {
            registerForm["3"].is_complete = true;
            step.value += 1;
          }
        })
        .catch((error) => {
          const { errors } = error.response.data;
          updateValidationErrors(errors);

          isLoaderVisible.value = false;
        });
    }

    /**
     * Submits registration Form
     */
    function submitForm() {
      isLoaderVisible.value = true;

      let form = {
        password: encrypt(formData.password, process.env.MIX_ENCRYPTION_KEY ?? ""),
        password_confirmation: encrypt(
          formData.password_confirmation,
          process.env.MIX_ENCRYPTION_KEY ?? ""
        ),
      };

      axios
        .post("/iati/register", { ...formData, ...form })
        .then((res) => {
          if (res.request.responseURL.includes("activities")) {
            window.location.href = "/activities";
          }

          const response = res.data;
          const errors = !response.success || "errors" in response ? response.errors : [];
          updateValidationErrors(errors);
          Object.assign()
          isLoaderVisible.value = false;
          registerForm["1"].is_complete = false;

          if (response.success) {
            registerForm["4"].is_complete = true;
            step.value += 1;
          }
        })
        .catch((error) => {
          const { errors } = error.response.data;
          updateValidationErrors(errors);

          isLoaderVisible.value = false;
        });
    }

    function getCurrentStep() {
      return step.value.toString();
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
        content: "";
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
        content: "";
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
