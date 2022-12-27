<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">{{ language.settings_lang.registry_information.label }}</div>
      <div class="flex items-center mb-4 text-xs text-n-50">
        <button>
          <HoverText
            :name=language.settings_lang.registry_information.label
            :hover-text=language.settings_lang.registry_information.hover_text
          />
        </button>
      </div>
    </div>
    <div class="mt-6 register" @keyup.enter="autoVerify">
      <div class="register__container">
        <div>
          <div class="relative">
            <div class="flex justify-between">
              <label for="publisher-id">{{ language.settings_lang.publisher_id.label }}</label>
              <button>
                <HoverText
                  width="w-72"
                  :name=language.settings_lang.publisher_id.label
                  :hover-text=language.settings_lang.publisher_id.hover_text
                  :show-iati-reference="true"
                />
              </button>
            </div>
            <input
              id="publisher-id"
              class="mb-2 register__input"
              :class="{
                error__input: publishingError.publisher_id,
              }"
              type="text"
              :placeholder=language.settings_lang.publisher_id.placeholder
              :value="organization.publisher_id"
              disabled="true"
              @input="updateStore('publisher_id')"
            />
          </div>
          <span v-if="publishingError.publisher_id" class="error" role="alert">
            {{ publishingError.publisher_id }}
          </span>
        </div>
        <div>
          <div class="relative">
            <div class="flex justify-between">
              <label for="api-token">{{ language.settings_lang.api_token.label }} </label>
              <button>
                <HoverText
                  :name=language.settings_lang.api_token.label
                  :hover-text=language.settings_lang.api_token.hover_text
                  :show-iati-reference="true"
                />
              </button>
            </div>
            <input
              id="api-token"
              v-model="publishingForm.api_token"
              class="mb-2 register__input"
              :class="{
                error__input: publishingError.api_token,
              }"
              type="text"
              :placeholder=language.settings_lang.api_token.placeholder
              @input="updateStore('api_token')"
            />
            <span
              v-if="publishingInfo.isVerificationRequested"
              :class="{
                tag__correct: publishingInfo.token_verification,
                tag__incorrect: !publishingInfo.token_verification,
              }"
            >
              {{ publishingInfo.token_verification ? language.settings_lang.correct_label : language.settings_lang.incorrect_label }}
            </span>
          </div>
          <span v-if="publishingError.api_token" class="error" role="alert">
            {{ publishingError.api_token }}
          </span>
        </div>
      </div>
      <button class="primary-btn verify-btn" @click="submitPublishing">
        {{ language.settings_lang.uc_verify }}
      </button>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, computed } from 'vue';
import { useStore } from '../../store';
import { ActionTypes } from '../../store/setting/actions';
import HoverText from './../../components/HoverText.vue';

export default defineComponent({
  components: {
    HoverText,
  },
  props: {
    organization: {
      type: Object,
      required: true,
    },
  },
  emits: ['submitPublishing'],

  setup(props, { emit }) {
    const language = window["global_lang"];
    const tab = ref('publish');
    const store = useStore();

    interface ObjectType {
      [key: string]: string;
    }

    const publishingForm = computed(() => store.state.publishingForm);

    const publishingInfo = computed(() => store.state.publishingInfo);

    const publishingError = computed(
      () => store.state.publishingError as ObjectType
    );

    function submitPublishing() {
      emit('submitPublishing');
    }

    function autoVerify() {
      emit('submitPublishing');
    }

    function updateStore(key: keyof typeof publishingForm.value) {
      store.dispatch(ActionTypes.UPDATE_PUBLISHING_FORM, {
        key: key,
        value: publishingForm.value[key],
      });
    }

    function toggleTab() {
      tab.value = tab.value === 'publish' ? 'default' : 'publish';
    }

    return {
      tab,
      publishingForm,
      publishingInfo,
      publishingError,
      store,
      props,
      submitPublishing,
      toggleTab,
      updateStore,
      autoVerify,
      language
    };
  },
});
</script>
