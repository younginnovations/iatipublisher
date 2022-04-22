<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Registry Information</div>
      <div class="mb-4 flex items-center text-xs text-n-50">
        <span class="mr-1"
          ><span class="text-salmon-50">* </span>Mandatory fields</span
        >
        <button>
          <svg-vue class="text-base" icon="help"></svg-vue>
        </button>
      </div>
    </div>
    <div class="register">
      <div class="register__container">
        <div>
          <div class="relative">
            <div class="flex justify-between">
              <label for="name">Publisher ID</label>
              <button>
                <svg-vue class="text-base" icon="help"></svg-vue>
              </button>
            </div>
            <input
              id="publisher_id"
              :class="
                publishingInfo.publisher_verification
                  ? 'register__input error__input mb-2'
                  : 'register__input mb-2'
              "
              type="text"
              placeholder="yipl"
              v-model="publishingForm.publisher_id"
              @input="updateStore('publisher_id')"
              @focusout="autoVerify"
            />
            <span
              v-if="publishingInfo.isVerificationRequested"
              :class="
                publishingInfo.publisher_verification
                  ? 'tag__correct'
                  : 'tag__incorrect'
              "
            >
              {{
                publishingInfo.publisher_verification ? 'Correct' : 'Incorrect'
              }}
            </span>
          </div>
          <span class="error" role="alert" v-if="publishingError.publisher_id">
            {{ publishingError.publisher_id }}
          </span>
          <p class="xl:pr-2" v-if="!publishingError.publisher_id">
            You need to create user and publisher accounts on the IATI Registry.
            When creating your publisher account you will be asked to specify a
            publisher identifier (typically a unique abbreviation of your
            organisation's name). We recommend that you use the same identifier
            as you specified as your IATI account identifier.
          </p>
        </div>
        <div>
          <div class="relative">
            <div class="flex justify-between">
              <label for="api_token"
                >API Token <span class="text-salmon-50">*</span></label
              >
              <button>
                <svg-vue class="text-base" icon="help"></svg-vue>
              </button>
            </div>
            <input
              id="api_token"
              :class="
                publishingInfo.token_verification
                  ? 'register__input error__input mb-2'
                  : 'register__input mb-2'
              "
              type="text"
              placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ"
              v-model="publishingForm.api_token"
              @input="updateStore('api_token')"
              @focusout="autoVerify"
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
          <p v-if="!publishingError.api_token">
            You can get your API token from the IATI Registry. Follow the link
            to learn how to retrieve your API key
            <a class="font-bold text-bluecoral" href="">Click Here</a>
          </p>
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

export default defineComponent({
  emits: ['submitPublishing'],

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
      if (publishingForm.value.publisher_id && publishingForm.value.api_token) {
        emit('submitPublishing');
      }
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
