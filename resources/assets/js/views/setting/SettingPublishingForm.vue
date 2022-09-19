<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Registry Information</div>
      <div class="flex items-center mb-4 text-xs text-n-50">
        <button>
          <HoverText
            name="IATI Registry Information"
            hover-text="IATI Publisher needs to add your organisation's data to the IATI Registry (iatiregistry.org). To do this, we need to access your organisation's IATI Registry Publisher Account. Please provide your organisation's credentials from the IATI Registry."
          />
        </button>
      </div>
    </div>
    <div class="mt-6 register" @keyup.enter="autoVerify">
      <div class="register__container">
        <div>
          <div class="relative">
            <div class="flex justify-between">
              <label for="publisher-id">Publisher ID </label>
              <button>
                <HoverText
                  width="w-72"
                  name="Publisher ID"
                  hover-text="This is the unique ID for your organisation that you created when you set up your IATI Registry Publisher Account. It is a shortened version of your organisation's name, which will include lowercase letters and may include numbers and also - (dash) and _ (underscore). For example nef_mali' for Near East Foundation Mali."
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
              placeholder="Type Publisher ID here"
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
              <label for="api-token">API Token </label>
              <button>
                <HoverText
                  name="API Token"
                  hover-text="The API token is a unique key that is generated from your organisation's IATI Registry Publisher Account. It is required to give IATI Publisher permission to add data to the IATI Registry on your behalf. Generate a Token in the 'My Account' tab by <a href='https://www.iatiregistry.org/user/login' target='_blank' target='_blank'>logging</a> into to the IATI Registry."
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
              placeholder="Type API Token here"
              @input="updateStore('api_token')"
            />
            <span
              v-if="publishingInfo.isVerificationRequested"
              :class="{
                tag__correct: publishingInfo.token_verification,
                tag__incorrect: !publishingInfo.token_verification,
              }"
            >
              {{ publishingInfo.token_verification ? 'Correct' : 'Incorrect' }}
            </span>
          </div>
          <span v-if="publishingError.api_token" class="error" role="alert">
            {{ publishingError.api_token }}
          </span>
        </div>
      </div>
      <button class="primary-btn verify-btn" @click="submitPublishing">
        Verify
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
    };
  },
});
</script>
