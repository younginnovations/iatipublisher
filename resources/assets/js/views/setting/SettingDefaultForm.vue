<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">
        Default Values
      </div>
      <div class="mb-4 flex items-center text-xs text-n-50">
        <button>
          <HoverText
            name="Default Values"
            hover-text="These values will be automatically added to your data files."
          />
        </button>
      </div>
    </div>
    <span class="text-sm font-bold text-n-50">Default for all data</span>
    <div class="register mt-4 mb-6">
      <div class="register__container mb-0">
        <div>
          <div class="flex justify-between">
            <label for="default-currency">Default Currency</label>
            <button>
              <HoverText
                name="Default Currency"
                hover-text="The currency in which you report your financial transactions. You can later manually change the currency on individual transactions and budgets if required."
              />
            </button>
          </div>
          <Multiselect
            id="default-currency"
            v-model="defaultForm.default_currency"
            class="vue__select"
            placeholder="Select from dropdown"
            :options="props.currencies"
            :searchable="true"
            @click="updateStore('default_currency')"
          />
          <span
            v-if="defaultError.default_currency"
            class="error"
            role="alert"
          >
            {{ defaultError.default_currency }}
          </span>

          <p v-if="!defaultError.default_currency">
            If you do not set your default currency, you have to choose and
            select currency manually for all the financial transactions.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="default-language">Default Language</label>
            <button>
              <HoverText
                name="Default Language"
                hover-text="The language in which you provide data on your activities. You can later manually change the language on individual text if required."
              />
            </button>
          </div>
          <Multiselect
            id="default-language"
            v-model="defaultForm.default_language"
            :class="
              defaultError.default_language
                ? 'error__input vue__select'
                : 'vue__select'
            "
            placeholder="Select language from dropdown"
            :searchable="true"
            :options="props.languages"
            @click="updateStore('default_language')"
          />
          <span
            v-if="defaultError.default_language"
            class="error"
            role="alert"
          >
            {{ defaultError.default_language }}
          </span>

          <p v-if="!defaultError.default_language">
            If you do not set your default language, you have to choose and
            select language for all the narrative text in activity and
            organisation.
          </p>
        </div>
      </div>
    </div>
    <span class="text-sm font-bold text-n-50">Default for activity data</span>
    <div class="register mt-4">
      <div class="register__container">
        <div>
          <div class="flex justify-between">
            <label for="default-hierarchy">Default Hierarchy</label>
            <button>
              <HoverText
                width="w-64"
                name="Default Hierarchy"
                hover-text="If you are reporting both programmes (parent activities) and projects (child activities),
                choose the hierarchical level that most of your activities are at. e.g. parent activity = 1; child activity = 2.
                <br>If all your activities are at the same level i.e. you have no child activities, then choose 1."
              />
            </button>
          </div>
          <input
            id="default-hierarchy"
            v-model="defaultForm.hierarchy"
            :class="
              defaultError.hierarchy
                ? 'register__input mb-2'
                : 'register__input mb-2'
            "
            type="text"
            placeholder="Type default hierarchy here"
            @input="updateStore('hierarchy')"
          >
          <span
            v-if="defaultError.hierarchy"
            class="error"
            role="alert"
          >
            {{ defaultError.hierarchy }}
          </span>
          <p v-if="!defaultError.hierarchy">
            If hierarchy is not reported then 1 is assumed. If multiple levels
            are reported then, to avoid double counting, financial transactions
            should only be reported at the lowest hierarchical level.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="humanitarian">Humanitarian</label>

            <button>
              <HoverText
                width="w-72"
                name="Humanitarian"
                hover-text="Add a 'Humanitarian Flag' to every activity that your organisation publishes data on. This means that your organisation identifies all their activities as wholly or partially addressing a humanitarian crisis or multiple crises. You can later manually add or remove a Humanitarian Flag on individual activities if required."
              />
            </button>
          </div>
          <Multiselect
            id="humanitarian"
            v-model="defaultForm.humanitarian"
            :class="
              defaultError.humanitarian
                ? 'error__input vue__select'
                : 'vue__select'
            "
            placeholder="Select Humanitarian here"
            :options="props.humanitarian"
            :searchable="true"
            @click="updateStore('humanitarian')"
          />
          <span
            v-if="defaultError.humanitarian"
            class="error"
            role="alert"
          >
            {{ defaultError.humanitarian }}
          </span>
          <p v-if="!defaultError.hierarchy">
            If not selected, it will be set to 'Yes' in all the activities.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed, ref } from 'vue';
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
  },

  setup(props) {
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
    };
  },
});
</script>
