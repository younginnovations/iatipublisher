<template>
  <section class="section-wrapper">
    <Loader v-if="loaderVisibility" />
    <div class="setting input__field">
      <span class="text-xs font-bold text-n-40">Settings</span>
      <div class="flex items-center justify-between">
        <div class="my-2 flex items-center sm:mt-4 sm:mb-6">
          <a href="/activities"><svg-vue icon="left-arrow" /></a>
          <h2 class="ml-3 text-heading-5 font-bold text-n-50 sm:text-heading-4">
            Settings
          </h2>
        </div>
        <div>
          <Toast v-if="toastVisibility" :message="toastMessage" :type="toastType" />
        </div>
      </div>
      <div :class="tab === 'default' ? 'overflow-y-auto' : ''" class="setting__container">
        <div class="flex">
          <button
            class="tab-btn mr-2"
            :class="{
              active__tab: tab === 'publish',
            }"
            @click="toggleTab('publish')"
          >
            Publishing Settings
          </button>
          <button
            class="tab-btn"
            :class="{
              active__tab: tab === 'default',
            }"
            @click="toggleTab('default')"
          >
            Default Values
          </button>
        </div>
        <SettingPublishingForm
          v-if="tab === 'publish'"
          :organization="props.organization"
          @keyup.enter="submitForm"
          @submit-publishing="submitForm"
        />
        <SettingDefaultForm
          v-else
          :currencies="currencies"
          :languages="languages"
          :humanitarian="humanitarian"
          :budget-not-provided="budgetNotProvided"
          @keyup.enter="submitForm"
        />
      </div>
    </div>
    <div
      class="fixed bottom-0 left-0 w-full bg-eggshell py-5 px-6 shadow-dropdown sm:pr-40"
    >
      <div class="flex items-center justify-end">
        <a class="ghost-btn mr-4 sm:mr-8" href="/activities">Cancel</a>
        <button
          class="primary-btn save-btn"
          @click="submitForm('setting/store/publisher')"
        >
          {{ tab === "publish" ? "Save publishing setting" : "Save default values" }}
        </button>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, computed, onMounted, provide } from "vue";
import { useStore } from "../../store";
import { ActionTypes } from "../../store/setting/actions";
import axios from "axios";
import SettingDefaultForm from "./SettingDefaultForm.vue";
import SettingPublishingForm from "./SettingPublishingForm.vue";
import Loader from "../../components/Loader.vue";
import Toast from "Components/ToastMessage.vue";

export default defineComponent({
  components: {
    SettingDefaultForm,
    SettingPublishingForm,
    Loader,
    Toast,
  },

  props: {
    currencies: {
      type: [String, Object],
      required: true,
    },
    languages: {
      type: [String, Object],
      required: true,
    },
    humanitarian: {
      type: [String, Object],
      required: true,
    },
    organization: {
      type: [String, Object],
      required: true,
    },
    budgetNotProvided: {
      type: Object,
      required: true,
    },
    userRole: {
      type: String,
      required: true,
    },
  },

  setup(props) {
    const tab = ref("publish");
    const store = useStore();
    const loaderVisibility = ref(false);
    const toastVisibility = ref(false);
    const toastMessage = ref("");
    const toastType = ref(false);

    const publishingForm = computed(() => store.state.publishingForm);

    const publishingInfo = computed(() => store.state.publishingInfo);

    const publishingError = computed(() => store.state.publishingError);

    const defaultForm = computed(() => store.state.defaultForm);

    const defaultError = computed(() => store.state.defaultError);

    function updateStore(
      name: keyof typeof ActionTypes,
      key: string,
      value: string | boolean
    ) {
      store.dispatch(ActionTypes[name], {
        key: key,
        value: value,
      });
    }

    onMounted(async () => {
      const { data } = await axios.get("/setting/data");
      const settingData = data.data;

      if (settingData) {
        const defaultValues = settingData.default_values
          ? settingData.default_values
          : {};
        const publisherInfo = settingData.publishing_info
          ? settingData.publishing_info
          : {};
        const activityValues = settingData.activity_default_values
          ? settingData.activity_default_values
          : {};

        if (publisherInfo) {
          for (const key in publisherInfo) {
            updateStore(
              typeof publisherInfo[key] === "string"
                ? "UPDATE_PUBLISHING_FORM"
                : "UPDATE_PUBLISHER_INFO",
              key,
              publisherInfo[key]
            );
          }

          if (publisherInfo.api_token) {
            updateStore("UPDATE_PUBLISHER_INFO", "isVerificationRequested", true);
          }
        }

        if (defaultValues) {
          for (const key in defaultValues) {
            updateStore("UPDATE_DEFAULT_VALUES", key, defaultValues[key]);
          }
        }

        if (activityValues) {
          for (const key in activityValues) {
            updateStore("UPDATE_DEFAULT_VALUES", key, activityValues[key]);
          }
        }
      }
    });

    function toggleTab(page: string) {
      toastVisibility.value = false;
      tab.value = page;
    }

    function submitDefault() {
      for (const data in defaultError.value) {
        updateStore("UPDATE_DEFAULT_ERROR", data, "");
      }
      loaderVisibility.value = true;

      axios
        .post("/setting/store/default", defaultForm.value)
        .then((res) => {
          const response = res.data;
          loaderVisibility.value = false;
          toastVisibility.value = true;
          setTimeout(() => (toastVisibility.value = false), 5000);
          toastMessage.value = response.message;
          toastType.value = response.success;

          if (response.success) {
            updateStore("UPDATE_PUBLISHER_INFO", response.data.hierarchial, "");
          }

          loaderVisibility.value = false;
        })
        .catch((error) => {
          const { errors } = error.response.data;

          for (const e in errors) {
            updateStore("UPDATE_DEFAULT_ERROR", e, errors[e][0]);
          }

          loaderVisibility.value = false;
        });
    }

    function submitPublishing(url: string) {
      loaderVisibility.value = true;

      for (const data in publishingError.value) {
        updateStore("UPDATE_PUBLISHING_ERROR", data, "");
      }

      axios
        .post(url, {
          ...publishingInfo.value,
          ...publishingForm.value,
        })
        .then((res) => {
          const response = res.data;

          if (response.success) {
            updateStore(
              "UPDATE_PUBLISHER_INFO",
              "publisher_verification",
              response.data.publisher_verification
            );

            updateStore(
              "UPDATE_PUBLISHER_INFO",
              "token_verification",
              response.data.token_verification
            );

            updateStore("UPDATE_PUBLISHER_INFO", "isVerificationRequested", true);
          }

          loaderVisibility.value = false;
          toastVisibility.value = true;
          setTimeout(() => (toastVisibility.value = false), 5000);
          toastMessage.value = response.message;
          toastType.value = response.success;
        })
        .catch((error) => {
          const { errors } = error.response.data;

          for (const e in errors) {
            updateStore("UPDATE_PUBLISHING_ERROR", e, errors[e][0]);
          }

          loaderVisibility.value = false;
        });
    }

    function submitForm(url = "setting/verify") {
      if (tab.value === "publish") submitPublishing(url);
      if (tab.value === "default") submitDefault();
    }

    provide("userRole", props.userRole);

    return {
      props,
      tab,
      defaultError,
      publishingError,
      store,
      loaderVisibility,
      toastVisibility,
      toastMessage,
      toastType,
      toggleTab,
      submitForm,
    };
  },
});
</script>
