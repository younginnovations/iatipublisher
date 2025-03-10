<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Registry Information</div>
      <div class="mb-4 flex items-center text-xs text-n-50">
        <button>
          <HoverText
            name="IATI Registry Information"
            hover-text="IATI Publisher needs to add your organisation's data to the IATI Registry (iatiregistry.org). To do this, we need to access your organisation's IATI Registry Publisher Account. Please provide your organisation's credentials from the IATI Registry."
          />
        </button>
      </div>
    </div>
    <div class="register mt-6" @keyup.enter="autoVerify">
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
              v-model="publisherId"
              class="register__input mb-2"
              :class="{
                error__input: publishingError.publisher_id,
                'hover:cursor-not-allowed': !isSuperadmin,
              }"
              type="text"
              placeholder="Type Publisher ID here"
              :disabled="!isSuperadmin"
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

            <div class="relative">
              <input
                id="api-token"
                v-model="publishingForm.api_token"
                class="register__input mb-2"
                :class="{
                  error__input: publishingError.api_token,
                }"
                :disabled="userRole !== 'admin'"
                type="text"
                placeholder="Type API Token here"
                @input="updateStore('api_token')"
              />
              <ShimmerLoading
                v-if="!initialApiCallCompleted"
                class="!absolute top-[50%] !m-0 !ml-2 !h-8 !w-[96%] -translate-y-1/2"
              />
            </div>
            <span
              v-if="showTag && publishingInfo.isVerificationRequested"
              :class="{
                tag__correct: publishingForm.token_status === 'Correct',
                tag__pending: publishingForm.token_status === 'Pending',
                tag__incorrect: publishingForm.token_status === 'Incorrect',
              }"
            >
              {{ publishingForm.token_status }}
            </span>
          </div>
          <span v-if="publishingError.api_token" class="error" role="alert">
            {{ publishingError.api_token }}
          </span>
        </div>
      </div>
      <button
        :class="userRole !== 'admin' && 'cursor-not-allowed'"
        class="primary-btn verify-btn"
        @click="submitPublishing"
      >
        Verify
      </button>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, computed, inject, watch } from 'vue';
import { useStore } from '../../store';
import { ActionTypes } from '../../store/setting/actions';
import HoverText from './../../components/HoverText.vue';
import ShimmerLoading from 'Components/ShimmerLoading.vue';

export default defineComponent({
  components: {
    ShimmerLoading,
    HoverText,
  },
  props: {
    organization: {
      type: Object,
      required: true,
    },
    initialApiCallCompleted: {
      type: Boolean,
      required: false,
    },
    showTag: {
      type: Boolean,
      require: false,
    },
  },
  emits: ['submitPublishing'],

  setup(props, { emit }) {
    const tab = ref('publish');
    const store = useStore();
    const userRole = inject('userRole');
    const isSuperadmin = inject('isSuperadmin');
    const publisherId = ref(props.organization.publisher_id);

    watch(
      () => publisherId.value,
      (publisherId) => {
        store.dispatch(ActionTypes['UPDATE_PUBLISHING_FORM'], {
          key: 'publisher_id',
          value: publisherId,
        });
      }
    );

    interface ObjectType {
      [key: string]: string;
    }

    const publishingForm = computed(() => store.state.publishingForm);

    const publishingInfo = computed(() => store.state.publishingInfo);

    const publishingError = computed(
      () => store.state.publishingError as ObjectType
    );

    function submitPublishing() {
      if (userRole === 'admin') {
        emit('submitPublishing');
      }
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
      userRole,
      submitPublishing,
      toggleTab,
      updateStore,
      autoVerify,
      isSuperadmin,
      publisherId,
    };
  },
});
</script>
