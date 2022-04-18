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
              class="register__input mb-2"
              type="text"
              placeholder="yipl"
              v-model="publishingForm.publisher_id"
              @input="updateStore('publisher_id')"
            />
            <span class="tag">Correct</span>
          </div>
          <p class="xl:pr-2">
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
              class="register__input mb-2"
              type="text"
              placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ"
              v-model="publishingForm.api_token"
              @input="updateStore('api_token')"
            />
            <span class="tag">Correct</span>
          </div>
          <p>
            You can get your API token from the IATI Registry. Follow the link
            to learn how to retrieve your API key
            <a class="font-bold text-bluecoral" href="#">Click Here</a>
          </p>
        </div>
      </div>
      <button class="primary-btn verify-btn">Verify</button>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, reactive, computed } from 'vue';
import { useStore } from 'vuex';

export default defineComponent({
  setup(props) {
    const tab = ref('publish');
    const store = useStore();

    const publishingForm = computed(() => store.state.setting.publishingForm);

    const publishingError = computed(() => store.state.setting.publishingError);

    function updateStore(key: string) {
      console.log(key, publishingForm, publishingForm.value['publisher_id']);
      store.dispatch('setting/updatePublisherInfo', {
        state: store.state,
        key: key,
        value: publishingForm.value[key],
      });
    }

    function toggleTab() {
      tab.value = tab.value === 'publish' ? 'default' : 'publish';
    }

    return {
      tab,
      toggleTab,
      publishingForm,
      publishingError,
      store,
      props,
      updateStore,
    };
  },
});
</script>
