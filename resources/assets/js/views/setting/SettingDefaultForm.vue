<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Default Values</div>
      <div class="flex items-center mb-4 text-xs text-n-50">
        <button>
          <HoverText
            :name=language.settings_lang.default_values.label
            :hover-text=language.settings_lang.default_values.hover_text
          />
        </button>
      </div>
    </div>
    <span class="text-sm font-bold text-n-50">{{language.settings_lang.default_for_all_data_label}}</span>
    <div class="mt-4 mb-6 register">
      <div class="mb-0 register__container">
        <div>
          <div class="flex justify-between">
            <label for="default-currency">{{language.settings_lang.default_currency.label}}</label>
            <button>
              <HoverText
                :name=language.settings_lang.default_currency.label
                :hover-text=language.settings_lang.default_currency.hover_text
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-currency"
            v-model="defaultForm.default_currency"
            class="vue__select"
            :placeholder=language.settings_lang.default_currency.placeholder
            :options="props.currencies"
            :searchable="true"
            @click="updateStore('default_currency')"
          />
          <span v-if="defaultError.default_currency" class="error" role="alert">
            {{ defaultError.default_currency }}
          </span>

          <p v-if="!defaultError.default_currency">
            {{ language.settings_lang.default_currency.help }}
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="default-language">{{ language.settings_lang.default_language.label }}</label>
            <button>
              <HoverText
                :name=language.settings_lang.default_language.label
                :hover-text=language.settings_lang.default_language.hover_text
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-language"
            v-model="defaultForm.default_language"
            class="vue__select"
            :class="{
              error__input: defaultError.default_language,
            }"
            :placeholder=language.settings_lang.default_language.placeholder
            :searchable="true"
            :options="props.languages"
            @click="updateStore('default_language')"
          />
          <span v-if="defaultError.default_language" class="error" role="alert">
            {{ defaultError.default_language }}
          </span>

          <p v-if="!defaultError.default_language">
            {{ language.settings_lang.default_language.label }}
          </p>
        </div>
      </div>
    </div>
    <span class="text-sm font-bold text-n-50">{{ language.settings_lang.default_for_activity_label }}</span>
    <div class="mt-4 register">
      <div class="register__container">
        <div>
          <div class="flex justify-between">
            <label for="default-hierarchy">{{ language.settings_lang.default_hierarchy.label }}</label>
            <button>
              <HoverText
                width="w-64"
                :name=language.settings_lang.default_hierarchy.label
                :hover-text=language.settings_lang.default_hierarchy.hover_text
                :show-iati-reference="true"
              />
            </button>
          </div>
          <input
            id="default-hierarchy"
            v-model="defaultForm.hierarchy"
            class="mb-2 register__input"
            type="text"
            :placeholder=language.settings_lang.default_hierarchy.placeholder
            @input="updateStore('hierarchy')"
          />
          <span v-if="defaultError.hierarchy" class="error" role="alert">
            {{ defaultError.hierarchy }}
          </span>
          <p v-if="!defaultError.hierarchy">
            {{ language.settings_lang.default_hierarchy.help }}
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="budget-not-provided">{{ language.settings_lang.budget_not_provided.label }}</label>

            <button>
              <HoverText
                width="w-72"
                :name=language.settings_lang.budget_not_provided.label
                :hover-text=language.settings_lang.budget_not_provided.hover_text
              />
            </button>
          </div>
          <Multiselect
            id="budget_not_provided"
            v-model="defaultForm.budget_not_provided"
            class="vue__select"
            :class="{
              error__input: defaultError.budget_not_provided,
            }"
            :placeholder=language.settings_lang.budget_not_provided.placeholder
            :options="props.budgetNotProvided"
            :searchable="true"
            @click="updateStore('budget_not_provided')"
          />
          <span
            v-if="defaultError.budget_not_provided"
            class="error"
            role="alert"
          >
            {{ defaultError.budget_not_provided }}
          </span>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="humanitarian">{{ language.settings_lang.humanitarian.label }}</label>

            <button>
              <HoverText
                width="w-72"
                :name=language.settings_lang.humanitarian.label
                :hover-text=language.settings_lang.humanitarian.hover_text
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="humanitarian"
            v-model="defaultForm.humanitarian"
            class="vue__select"
            :class="{
              error__input: defaultError.humanitarian,
            }"
            :placeholder=language.settings_lang.humanitarian.placeholder
            :options="props.humanitarian"
            :searchable="true"
            @click="updateStore('humanitarian')"
          />
          <span v-if="defaultError.humanitarian" class="error" role="alert">
            {{ defaultError.humanitarian }}
          </span>
          <p v-if="!defaultError.humanitarian">
            {{ language.settings_lang.humanitarian.help }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue';
import Multiselect from '@vueform/multiselect';
import { useStore } from '../../store';
import { ActionTypes } from '../../store/setting/actions';
import HoverText from './../../components/HoverText.vue';

export default defineComponent({
  components: {
    Multiselect,
    HoverText,
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
    budgetNotProvided: {
      type: [String, Object],
      required: true,
    },
  },

  setup(props) {
    const language = window["global_lang"];
    const store = useStore();

    const defaultForm = computed(() => {
      return store.state.defaultForm;
    });

    const defaultError = computed(() => {
      return store.state.defaultError;
    });

    function updateStore(key: keyof typeof defaultForm.value) {
      store.dispatch(ActionTypes.UPDATE_DEFAULT_VALUES, {
        key: key,
        value: defaultForm.value[key],
      });
    }

    return {
      props,
      defaultForm,
      defaultError,
      updateStore,
      language
    };
  },
});
</script>
