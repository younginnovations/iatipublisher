<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Registry Information</div>
      <div class="mb-4 flex items-center text-xs text-n-50">
        <button>
          <HoverText
            name="IATI Registry Information"
            hoverText="IATI Publisher needs to add your organisation's data to the IATI Registry (iatiregistry.org). To do this, we need to access your organisation's IATI Registry Publisher Account. Please provide your organisation's credentials from the IATI Registry."
          ></HoverText>
        </button>
      </div>
    </div>
    <div class="register mt-6">
      <div class="register__container">
        <div>
          <div class="relative">
            <div class="flex justify-between">
              <label for="publisher-id">Publisher ID </label>
              <button>
                <HoverText
                  width="w-72"
                  name="Publisher ID"
                  hoverText="This is the unique ID for your organisation that you created when you set up your IATI Registry Publisher Account. It is a shortened version of your organisation's name, which will include lowercase letters and may include numbers and also - (dash) and _ (underscore). For example nef_mali' for Near East Foundation Mali."
                ></HoverText>
              </button>
            </div>
            <input
              id="publisher-id"
              :class="
                publishingError.publisher_id
                  ? 'register__input error__input mb-2'
                  : 'register__input mb-2'
              "
              type="text"
              placeholder="Type Publisher ID here"
              :value="props.organization.publisher_id"
              @input="updateStore('publisher_id')"
              disabled="disabled"
            />
          </div>
          <span class="error" role="alert" v-if="publishingError.publisher_id">
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
                  hoverText="The API token is a unique key that is generated from your organisation's IATI Registry Publisher Account. It is required to give IATI Publisher permission to add data to the IATI Registry on your behalf. Generate a Token in the 'My Account' tab by <a href='https://www.iatiregistry.org/user/login' target='_blank' target='_blank'>logging</a> into to the IATI Registry."
                ></HoverText>
              </button>
            </div>
            <input
              id="api-token"
              :class="
                publishingError.api_token
                  ? 'register__input error__input mb-2'
                  : 'register__input mb-2'
              "
              type="text"
              placeholder="Type API Token here"
              v-model="publishingForm.api_token"
              @input="updateStore('api_token')"
            />
            <span
              v-if="publishingInfo.isVerificationRequested"
              :class="
                publishingInfo.token_verification
                  ? 'tag__correct'
                  : 'tag__incorrect'
              "
            >
              {{ publishingInfo.token_verification ? 'Correct' : 'Incorrect' }}
            </span>
          </div>
          <span class="error" role="alert" v-if="publishingError.api_token">
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
  emits: ['submitPublishing'],
  props: {
    organization: {
      type: Object,
      required: true,
    },
  },

  setup(props, { emit }) {
    const tab = ref('publish');
    const store = useStore();

    const publishingForm = computed(() => store.state.publishingForm);

    const publishingInfo = computed(() => store.state.publishingInfo);

    const publishingError = computed(() => store.state.publishingError);

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
