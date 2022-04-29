<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Default Values</div>
      <div class="mb-4 flex items-center text-xs text-n-50">
        <span class="mr-1"
          ><span class="text-salmon-50">* </span>Mandatory fields</span
        >
        <button>
          <HoverText
            name="Default Values"
            hover_text="These values will be automatically added in the XML file of an activity to your data files."
          ></HoverText>
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
            <label for="default-currency">Default Currency</label>
            <button>
              <HoverText
                name="Default Currency"
                hover_text="The currency in which you report your financial transactions. You can later manually change the currency on individual transactions and budgets if required."
              ></HoverText>
            </button>
          </div>
          <Multiselect
            id="default-currency"
            class="vue__select"
            placeholder="Select from dropdown"
            v-model="defaultForm.default_currency"
            :options="props.currencies"
            :searchable="true"
            @click="updateStore('default_currency')"
          />
          <span class="error" role="alert" v-if="defaultError.default_currency">
            {{ defaultError.default_currency }}
          </span>

          <p v-if="!defaultError.default_currency">
            The currency in which you normally report your financial
            transactions. Select from dropdown.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="default-language">Default Language</label>
            <button>
              <HoverText
                name="Default Language"
                hover_text="The language in which you provide data on your activities. You can later manually change the language on individual text if required. "
              ></HoverText>
            </button>
          </div>
          <Multiselect
            id="default-language"
            :class="
              defaultError.default_language
                ? 'error__input vue__select'
                : 'vue__select'
            "
            placeholder="Select language from dropdown"
            v-model="defaultForm.default_language"
            :searchable="true"
            :options="props.languages"
            @click="updateStore('default_language')"
          />
          <span class="error" role="alert" v-if="defaultError.default_language">
            {{ defaultError.default_language }}
          </span>

          <p v-if="!defaultError.default_language">
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
            <label for="default-hierarchy">Default Hierarchy</label>
            <button>
              <HoverText
                name="Default Hierarchy"
                hover_text="The hierarchical level within the reporting organisation’s subdivision of its units of aid. (eg activity = 1; sub-activity = 2; sub-sub-activity = 3). "
              ></HoverText>
            </button>
          </div>
          <input
            id="default-hierarchy"
            :class="
              defaultError.hierarchy
                ? 'register__input mb-2'
                : 'register__input mb-2'
            "
            type="text"
            placeholder="Type default hierarchy here"
            v-model="defaultForm.hierarchy"
            @input="updateStore('hierarchy')"
          />
          <span class="error" role="alert" v-if="defaultError.hierarchy">
            {{ defaultError.hierarchy }}
          </span>
          <p v-if="!defaultError.hierarchy">
            IATI allows for activities to be reported hierarchically (eg. parent
            - child ; programme - project - sub-project, etc). For activities at
            lower levels, their hierarchy can be edited as you are entering
            them.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="data-url">Linked Data URL</label>
            <button>
              <HoverText
                name="Linked Data URL"
                hover_text="If a publisher chooses to publish linked data about their IATI activities then allowing them to declare where this data is published would support discovery of it, and any additional information they may choose to publish as Linked Data alongside it."
              ></HoverText>
            </button>
          </div>
          <input
            id="data-url"
            :class="
              defaultError.linked_data_url
                ? 'error__input register__input mb-2'
                : 'register__input mb-2'
            "
            type="text"
            placeholder="Type Linked Data URI here"
            v-model="defaultForm.linked_data_url"
            @input="updateStore('linked_data_url')"
          />
          <span class="error" role="alert" v-if="defaultError.linked_data_url">
            {{ defaultError.linked_data_url }}
          </span>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="humanitarian">Humanitarian</label>

            <button>
              <HoverText
                width="w-80"
                name="Humanitarian"
                hover_text="Do you want to add a 'Humanitarian Flag' to every activity that your organisation publishes data on? This means that your organisation identifies all their activities as wholly or partially addressing a humanitarian crisis or multiple crises. You can later manually add or remove a Humantarian Flag on individual activities if required."
              ></HoverText>
            </button>
          </div>
          <Multiselect
            id="humanitarian"
            :class="
              defaultError.humanitarian
                ? 'error__input vue__select'
                : 'vue__select'
            "
            placeholder="Select Humanitarian here"
            v-model="defaultForm.humanitarian"
            :options="props.humanitarian"
            :searchable="true"
            @click="updateStore('humanitarian')"
          />
          <span class="error" role="alert" v-if="defaultError.humanitarian">
            {{ defaultError.humanitarian }}
          </span>
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
    currencies: [String, Object],
    languages: [String, Object],
    humanitarian: [String, Object],
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
