<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Default Values</div>
      <div class="flex items-center text-xs text-n-50">
        <span class="mr-1"
          ><span class="text-salmon-50">* </span>Mandatory fields</span
        >
        <button>
          <svg-vue class="text-base" icon="help"></svg-vue>
        </button>
      </div>
    </div>
    <p class="text">
      These values will be used in the xml files which is published to the IATI
      Registry. You have the option to override the activities.
    </p>
    <span class="text-sm font-bold text-n-50">Default for all data</span>
    <div class="register mt-4 mb-6">
      <div class="register__container mb-0">
        <div>
          <div class="flex justify-between">
            <label for="default_currency">Default Currency</label>
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <Multiselect
            class="select"
            v-model="defaultForm.default_currency"
            :options="props.currencies"
            @click="updateStore('default_currency')"
          />

          <p>
            The currency in which you normally report your financial
            transactions. Select from dropdown.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="default_language"
              >Default Language <span class="text-salmon-50">*</span></label
            >
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <Multiselect
            class="select"
            v-model="defaultForm.default_language"
            :options="props.languages"
            @click="updateStore('linked_data_url')"
          />

          <p>
            The language in which you normally report. Select from dropdown.
          </p>
        </div>
      </div>
    </div>
    <span class="text-sm font-bold text-n-50">Default for activity data</span>
    <div class="register mt-4">
      <div class="register__container">
        <div>
          <div class="flex justify-between">
            <label for="default_hierarchy">Default Hierarchy</label>
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="default_hierarchy"
            class="register__input mb-2"
            type="text"
            placeholder="1"
            v-model="defaultForm.hierarchy"
            @input="updateStore('hierarchy')"
          />
          <p>
            IATI allows for activities to be reported hierarchically (eg. parent
            - child ; programme - project - sub-project, etc). For activities at
            lower levels, their hierarchy can be edited as you are entering
            them.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="linked_data_url"
              >Linked Data URL <span class="text-salmon-50">*</span></label
            >
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="data_url"
            class="register__input mb-2"
            type="text"
            placeholder="en - English"
            v-model="defaultForm.linked_data_url"
            @input="updateStore('linked_data_url')"
          />
          <p>
            The language in which you normally report. Select from dropdown.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="humanitarian"
              >Humanitarian <span class="text-salmon-50">*</span></label
            >
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <Multiselect
            class="select"
            v-model="defaultForm.humanitarian"
            :options="props.humanitarian"
            @click="updateStore('default_currency')"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, computed } from 'vue';
import Multiselect from '@vueform/multiselect';
import { useStore } from 'vuex';

export default defineComponent({
  components: {
    Multiselect,
  },

  props: {
    currencies: String,
    languages: String,
    humanitarian: String,
  },

  setup(props) {
    const store = useStore();

    const defaultError = reactive({
      default_currency: '',
      default_language: '',
      hierarchy: '',
      linked_data_url: '',
      humanitarian: 'false',
    });

    const defaultForm = computed(() => {
      return store.state.setting.defaultForm;
    });

    function updateStore(key: string) {
      store.dispatch('setting/updateDefaultForm', {
        state: store.state,
        key: key,
        value: defaultForm.value[key],
      });
    }

    return {
      props,
      defaultForm,
      defaultError,
      updateStore,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
